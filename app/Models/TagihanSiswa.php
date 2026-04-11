<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\TahunAjar;
use App\Domain\Pembayaran\PembayaranStatus;
use App\Domain\Pembayaran\PembayaranKeterangan;
use DomainException;

class TagihanSiswa extends Model
{
    use HasFactory;

    protected $table = 'tagihan_siswa';

    protected $fillable = [
        'siswa_id',
        'tahun_ajar_id',
        'semester',
        'total_tagihan',
        'total_dibayar',
        'lunas',
        'tunggakan'
    ];

    protected $casts = [
        'total_tagihan' => 'decimal:2',
        'total_dibayar' => 'decimal:2',
        'lunas' => 'boolean'
    ];

    /*
    |------------------------------
    | RELASI
    |------------------------------
    */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function tahunAjar()
    {
        return $this->belongsTo(TahunAjar::class, 'tahun_ajar_id');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'tagihan_siswa_id');
    }

    public function pembayaranValid()
    {
        return $this->pembayaran()->where('status', 'valid');
    }

    /*
    |------------------------------
    | ATTRIBUTE (UNTUK TEST)
    |------------------------------
    */

    public function getTotalDibayarAttribute()
    {
        return (float) $this->attributes['total_dibayar'];
    }

    public function getSisaTagihanAttribute()
    {
        return max(0, $this->total_tagihan - $this->total_dibayar);
    }

    public function getStatusAttribute()
    {
        return $this->total_dibayar >= $this->total_tagihan
            ? 'Lunas'
            : 'Belum Lunas';
    }

    /*
    |------------------------------
    | METHOD SESUAI TEST
    |------------------------------
    */

    public function prosesPembayaran(float $jumlah, ?string $keterangan = null): Pembayaran
    {
        return $this->bayar($jumlah, $keterangan);
    }

    /*
    |------------------------------
    | LOGIC PEMBAYARAN
    |------------------------------
    */

    public function bayar(float $jumlah, ?string $keterangan = null, ?string $idempotencyKey = null): Pembayaran
    {
        if ($jumlah <= 0) {
            throw new DomainException('Jumlah pembayaran tidak valid');
        }

        return DB::transaction(function () use ($jumlah, $keterangan, $idempotencyKey) {

            $tagihan = self::with('tahunAjar')
                ->whereKey($this->id)
                ->lockForUpdate()
                ->firstOrFail();

            $tahunAjarAktif = TahunAjar::where('aktif', true)->first();

            if (!$tahunAjarAktif) {
                throw new DomainException('Tahun ajar tidak aktif');
            }

            $tunggakan = $tagihan->tahun_ajar_id !== $tahunAjarAktif->id;

            // ===============================
            // 🔒 IDEMPOTENCY (STRONG VERSION)
            // ===============================
            if ($idempotencyKey) {
                $existing = $tagihan->pembayaran()
                    ->where('idempotency_key', $idempotencyKey)
                    ->lockForUpdate()
                    ->first();

                if ($existing) {
                    return $existing;
                }
            }

            // ===============================
            // 🔥 HITUNG ULANG
            // ===============================
            $totalDibayar = $tagihan->pembayaranValid()->sum('jumlah');
            $sisaTagihan  = max(0, $tagihan->total_tagihan - $totalDibayar);

            if ($sisaTagihan <= 0) {
                throw new DomainException('Tagihan sudah lunas');
            }

            if ($jumlah > $sisaTagihan) {
                throw new DomainException('Pembayaran melebihi sisa tagihan');
            }

            // ===============================
            // 💾 INSERT PEMBAYARAN
            // ===============================
            try {
                $pembayaran = $tagihan->pembayaran()->create([
                    'jumlah'           => $jumlah,
                    'user_id'          => auth()->id() ?? 1,
                    'status'           => 'valid',
                    'tanggal_bayar'    => now(),
                    'keterangan'       => $keterangan ?? 'Pembayaran SPP',
                    'kode_transaksi'   => 'PAY-' . now()->format('YmdHis') . rand(100,999),
                    'idempotency_key'  => $idempotencyKey,
                    'tunggakan'        => $tunggakan,
                ]);
            } catch (\Illuminate\Database\QueryException $e) {

                // 🔥 ambil ulang data kalau bentrok UNIQUE
                if ($idempotencyKey) {
                    $existing = $tagihan->pembayaran()
                        ->where('idempotency_key', $idempotencyKey)
                        ->first();

                    if ($existing) {
                        return $existing;
                    }
                }

                throw new DomainException('Transaksi duplikat / race condition');
            }

            // ===============================
            // 🔁 UPDATE TAGIHAN
            // ===============================
            $totalDibayarBaru = $tagihan->pembayaranValid()->sum('jumlah');

            $tagihan->update([
                'total_dibayar' => $totalDibayarBaru,
                'lunas' => $totalDibayarBaru >= $tagihan->total_tagihan,
            ]);

            return $pembayaran;
        });
    }
}
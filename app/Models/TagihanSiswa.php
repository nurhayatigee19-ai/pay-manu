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

            // ============================
            // 1. VALIDASI TAHUN AJAR AKTIF
            // ============================
            $tahunAjarAktif = TahunAjar::where('aktif', true)->first();

            if (!$tahunAjarAktif) {
                throw new DomainException('Tahun ajar tidak aktif');
            }

            // ============================
            // 2. TENTUKAN STATUS TUNGGAKAN
            // ============================
            $tunggakan = $tagihan->tahun_ajar_id !== $tahunAjarAktif->id;

            // ============================
            // 3. VALIDASI STATUS TAGIHAN
            // ============================
            if ($tagihan->tahun_ajar_id === $tahunAjarAktif->id) {
                // Tagihan tahun aktif → OK
            } else {
                // Tagihan lama → hanya boleh jika dianggap tunggakan
                // (secara logika ini pasti true, tapi kita eksplisitkan)
                if (!$tunggakan) {
                    throw new DomainException('Tahun ajar tidak aktif');
                }
            }

            // ============================
            // 4. HITUNG PEMBAYARAN
            // ============================
            $totalDibayar = $tagihan->pembayaranValid()->sum('jumlah');

            $sisaTagihan = max(0, $tagihan->total_tagihan - $totalDibayar);

            if ($sisaTagihan <= 0) {
                throw new DomainException('Tagihan sudah lunas');
            }

            if ($jumlah > $sisaTagihan) {
                throw new DomainException('Pembayaran melebihi sisa tagihan');
            }

            // ============================
            // 5. SIMPAN PEMBAYARAN
            // ============================
            $pembayaran = $tagihan->pembayaran()->create([
                'jumlah' => $jumlah,
                'user_id' => Auth::id() ?? 1,
                'status' => 'valid',
                'tanggal_bayar' => now(),
                'keterangan' => $keterangan ?? 'Pembayaran SPP',
                'kode_transaksi' => 'PAY-' . now()->format('YmdHis') . rand(100,999),
                'idempotency_key' => $idempotencyKey,
                'tunggakan' => $tunggakan,
            ]);

            // ============================
            // 6. UPDATE TAGIHAN
            // ============================
            $tagihan->total_dibayar += $jumlah;
            $tagihan->lunas = $tagihan->total_dibayar >= $tagihan->total_tagihan;
            $tagihan->save();

            return $pembayaran;
        });
    }
}
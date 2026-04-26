<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siswa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'siswa';

    protected $fillable = [
        'nis',
        'nama',
        'kelas_id'
    ];

    // validasi otomatis
    public static function rules($id = null)
    {
        return [
            'nis' => 'required|unique:siswa,nis,' . $id,
            'nama' => 'required|string|max:100',
            'kelas_id' => 'required|exists:kelas,id',
        ];
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function tagihanSiswa()
    {
        return $this->hasMany(TagihanSiswa::class);
    }

    public function pembayaran()
    {
        return $this->hasManyThrough(
            \App\Models\Pembayaran::class,
            \App\Models\TagihanSiswa::class,
            'siswa_id',
            'tagihan_siswa_id'
        );
    }

    // METHOD BARU: Cek apakah siswa bisa dihapus
    public function canBeDeleted()
    {
        // Siswa TIDAK BISA dihapus jika memiliki tagihan atau pembayaran
        $hasTagihan = $this->tagihanSiswa()->count() > 0;
        $hasPembayaran = $this->pembayaran()->count() > 0;
        
        return !$hasTagihan && !$hasPembayaran;
    }

    // METHOD BARU: Scope untuk data aktif (belum dihapus)
    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }
}
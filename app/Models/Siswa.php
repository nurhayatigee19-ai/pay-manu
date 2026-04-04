<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';

    protected $fillable = [
        'nis',
        'nama',
        'kelas_id'
    ];

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
}
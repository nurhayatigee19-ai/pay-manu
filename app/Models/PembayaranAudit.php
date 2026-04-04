<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PembayaranAudit extends Model
{
    use HasFactory;

    protected $table = 'pembayaran_audit';

    protected $fillable = [
        'pembayaran_id',
        'user_id',
        'aksi',
        'data_lama',
        'data_baru'
    ];

    protected $casts = [
        'data_lama' => 'array',
        'data_baru' => 'array',
    ];

    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
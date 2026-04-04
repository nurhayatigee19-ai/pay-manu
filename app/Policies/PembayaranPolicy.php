<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Pembayaran;

class PembayaranPolicy
{
    public function create(User $user)
    {
        return $user->role === 'stafkeuangan';
    }

    public function batalkan(User $user, Pembayaran $pembayaran)
    {
        return $user->role === 'stafkeuangan';
    }

    public function viewAny(User $user)
    {
        return in_array($user->role, [
            'stafkeuangan',
            'kepsek'
        ]);
    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePembayaranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // INI KUNCI UTAMA
    public function expectsJson(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tagihan_siswa_id' => ['required', 'exists:tagihan_siswa,id'],
            'jumlah'           => ['required', 'numeric', 'min:1'],
        ];
    }
}
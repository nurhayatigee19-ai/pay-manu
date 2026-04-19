<?php

namespace App\Http\Requests\Siswa;

use Illuminate\Foundation\Http\FormRequest;

class DeleteSiswaRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->role === 'staf keuangan';
    }

    public function rules()
    {
        return [
            'id' => 'required|exists:siswa,id'
        ];
    }
}
<?php

namespace App\Http\Requests\Siswa;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSiswaRequest extends FormRequest
{
    public function authorize()
    {
        // Hanya staf keuangan yang bisa edit
        return auth()->user()->role === 'staf keuangan';
    }

    public function rules()
    {
        $id = $this->route('id');

        return [
            'nis' => [
                'required',
                'string',
                'max:20',
                Rule::unique('siswa', 'nis')->ignore($id),
            ],
            'nama' => 'required|string|max:100',
            'kelas_id' => 'required|exists:kelas,id',
        ];
    }

    public function messages()
    {
        return [
            'nis.required' => 'NIS wajib diisi',
            'nis.unique' => 'NIS sudah terdaftar',
            'nama.required' => 'Nama siswa wajib diisi',
            'kelas_id.required' => 'Kelas wajib dipilih',
            'kelas_id.exists' => 'Kelas tidak valid',
        ];
    }
}
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        // jika sudah ada staf keuangan, blokir registrasi
        if (User::where('role','stafkeuangan')->exists()) {
            abort(403,'Registrasi sudah ditutup');
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {

        // jika staf sudah ada → tidak boleh daftar lagi
        if (User::where('role','stafkeuangan')->exists()) {
            abort(403,'Registrasi sudah ditutup');
        }

        $this->validator($request->all())->validate();

        $this->create($request->all());

        return redirect()
            ->route('login')
            ->with('success','Registrasi staf keuangan berhasil. Silakan login.');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required','string','max:255'],
            'email' => ['required','string','email','max:255','unique:users'],
            'password' => ['required','string','min:8','confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'], // otomatis di-hash oleh model
            'role' => 'stafkeuangan'
        ]);
    }
}

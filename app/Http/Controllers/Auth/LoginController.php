<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Redirect otomatis setelah login berdasarkan role
     */
    protected function redirectTo()
    {
        $role = auth()->user()->role;

        return match ($role) {
            'stafkeuangan' => '/stafkeuangan/dashboard',
            'kepsek'       => '/kepsek/dashboard',
            default        => abort(403, 'Role tidak dikenal'),
        };
    }

    /**
     * Tampilkan form login
     */
    public function showLoginForm()
    {
        if (auth()->check()) {
            Auth::logout();
        }

        return view('auth.login');
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
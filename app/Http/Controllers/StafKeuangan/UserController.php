<?php

namespace App\Http\Controllers\StafKeuangan;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        $users = User::latest()->get();

        return view('stafkeuangan.user.index', compact('users'));
    }

    public function create()
    {
        return view('stafkeuangan.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, // TANPA Hash::make
            'role' => $request->role
        ]);

        return redirect()
        ->route('stafkeuangan.user.index')
        ->with('success','User berhasil dibuat');
    }

    public function edit(User $user)
    {
        return view('stafkeuangan.user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'role' => 'required'
        ]);

        $user->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'role'=>$request->role
        ]);

        return redirect()
        ->route('stafkeuangan.user.index')
        ->with('success','User berhasil diupdate');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()
        ->route('stafkeuangan.user.index')
        ->with('success','User berhasil dihapus');
    }

    public function resetPassword(User $user)
    {
        $user->update([
            'password' => '123456' // tanpa Hash::make
        ]);

        return redirect()
        ->route('stafkeuangan.user.index')
        ->with('success','Password berhasil direset (123456)');
    }

}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return $user->is_admin ? redirect('/admin/dashboard') : redirect('/vote');
        }

        return back()->withErrors(['Username atau password salah']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function registerForm()
{
    return view('auth.register');
}

public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'username' => 'required|string|unique:users,username',
        'password' => 'required|string|min:6|confirmed',
    ]);

    $user = User::create([
        'name' => $request->name,
        'username' => $request->username,
        'password' => Hash::make($request->password),
        'is_admin' => false,
        'has_voted' => false,
    ]);    

    Auth::login($user);

    return redirect('/vote')->with('message', 'Registrasi berhasil!');
}
}

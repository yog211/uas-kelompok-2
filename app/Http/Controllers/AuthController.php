<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function post(Request $request)
    {
        // dd(request()->all());
        $cre = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($cre)) {
            session()->regenerate();
            return redirect()->intended('/dashboard');
        } else {
            return redirect()->back()->with('warning', 'Username Atau Password Anda Salah');
        }
    }



    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }
}

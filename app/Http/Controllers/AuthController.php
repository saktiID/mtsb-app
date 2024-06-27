<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * method index login
     */
    public function index()
    {
        return view('auth.login');
    }


    /**
     * method auth login
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required|min:5'
        ], [
            'username.required' => 'Kolom username tidak boleh kosong.',
            'password.required' => 'Kolom password tidak boleh kosong.',
            'password.min' => 'Kolom password kurang dari 5 karakter.',
        ]);

        $attempt = Auth::attempt([
            'username' => $request->username,
            'password' => $request->password
        ]);

        if ($attempt) {
            return redirect()->route('home');
        } else {
            $msg = 'Username atau password salah.';
            return redirect()->route('login',)->withInput()->with('response', $msg);
        }
    }

    /**
     * method auth log out
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}

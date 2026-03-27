<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return Auth::user()->role === 'admin' ? redirect()->route('admin.dashboard') : redirect()->route('user.dashboard');
        }

        $num1 = rand(1, 9);
        $num2 = rand(1, 9);
        session(['captcha_result' => $num1 + $num2]);

        return view('auth.login', compact('num1', 'num2'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'captcha' => 'required|numeric'
        ]);

        if ($request->captcha != session('captcha_result')) {
            return back()->with('error', 'Jawaban captcha tidak tepat. Silakan coba lagi.')->onlyInput('email');
        }

        session()->forget('captcha_result');

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            $role = Auth::user()->role;
            return redirect()->route($role === 'admin' ? 'admin.dashboard' : 'user.dashboard');
        }

        return back()->with('error', 'Email atau password salah.')->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}

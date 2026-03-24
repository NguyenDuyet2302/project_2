<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Tên tài khoản hoặc mật khẩu không chính xác!',
        ]);
    }

    public function showAdminLoginForm()
    {
        return view('admin.login');
    }

    public function adminLoginPost(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role == 1) {
                $request->session()->regenerate();
                return redirect()->route('dashboard');
            } else {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Tài khoản này không có quyền quản trị viên!',
                ]);
            }
        }
        return back()->withErrors([
            'email' => 'Tên tài khoản hoặc mật khẩu không chính xác!',
        ]);
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}

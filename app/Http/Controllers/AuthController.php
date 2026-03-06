<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // ========================================================
    // 1. DÀNH CHO KHÁCH THUÊ BÌNH THƯỜNG
    // ========================================================
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

    // ========================================================
    // 2. DÀNH CHO ADMIN (GIAO DIỆN FIGMA XANH MINT)
    // ========================================================
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

        // QUAN TRỌNG: Dùng Auth::attempt để tìm trong bảng 'users'
        if (Auth::attempt($credentials)) {

            // Đã tìm thấy tài khoản và đúng mật khẩu.
            // Giờ kiểm tra xem ông này có phải Admin (role = 1) không?
            if (Auth::user()->role == 1) {
                $request->session()->regenerate();
                return redirect()->route('dashboard'); // Phi thẳng vào Dashboard
            } else {
                // Đúng mật khẩu nhưng chỉ là user thường -> Đuổi ra
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Tài khoản này không có quyền quản trị viên!',
                ]);
            }
        }

        // Sai email hoặc sai mật khẩu
        return back()->withErrors([
            'email' => 'Tên tài khoản hoặc mật khẩu không chính xác!', // Đã sửa lại thông báo
        ]);
    }

    // ========================================================
    // 3. ĐĂNG XUẤT CHUNG
    // ========================================================
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Đăng xuất xong đẩy về lại trang login của Admin
        return redirect()->route('admin.login');
    }
}

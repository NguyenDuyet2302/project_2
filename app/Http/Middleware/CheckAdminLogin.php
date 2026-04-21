<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Kiểm tra xem người này đã đăng nhập chưa
        if (Auth::check()) {
            // 2. Vì bạn chỉ mới làm Admin, nên cứ đăng nhập thành công là cho vào
            // Sau này nếu có thêm Khách trọ, bạn chỉ cần thêm: && Auth::user()->role == 1
            return $next($request);
        }

        // Nếu chưa đăng nhập thì mới bắt quay về trang login
        return redirect()->route('admin.login');
    }
}

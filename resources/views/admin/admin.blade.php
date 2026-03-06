<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hệ thống trọ</title>
    <style>
        body { margin: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; display: flex; height: 100vh; background-color: #bfff70; /* Màu vàng chanh chủ đạo */ }

        /* Sidebar */
        .sidebar { width: 280px; background-color: #b2ffd9; /* Màu xanh mint nhạt bên trái */ display: flex; flex-direction: column; padding: 30px 20px; box-sizing: border-box; }

        .brand { display: flex; align-items: center; gap: 15px; font-size: 1.5rem; color: #000; margin-bottom: 40px; }
        .logo-home { width: 45px; height: 45px; }

        /* Các nút Sidebar kiểu Pill */
        .nav-list { display: flex; flex-direction: column; gap: 15px; flex-grow: 1; }
        .nav-item {
            background-color: #00c853; color: #000; padding: 18px 25px; border-radius: 15px;
            text-decoration: none; display: flex; align-items: center; gap: 15px;
            font-weight: 500; font-size: 1.1rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .nav-item:hover { background-color: #00e676; }
        .nav-item img { width: 24px; height: 24px; }

        /* Nút đăng xuất */
        .logout-container { text-align: center; padding-bottom: 20px; }
        .logout-btn {
            background-color: #00c853; color: #000; border: none; padding: 12px 35px;
            border-radius: 25px; cursor: pointer; font-size: 1rem; font-weight: bold;
        }

        /* Vùng chính */
        .main-wrapper { flex: 1; display: flex; flex-direction: column; padding: 25px 40px; box-sizing: border-box; }

        /* Topbar Header */
        .top-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; }
        .house-pill {
            background-color: #00c853; color: #000; padding: 15px 30px; border-radius: 20px;
            display: flex; align-items: center; gap: 15px; font-weight: bold; font-size: 1.1rem;
        }
        .user-badges { display: flex; gap: 20px; }
        .badge {
            background: #fff; padding: 10px 20px; border-radius: 15px;
            display: flex; align-items: center; gap: 10px; font-weight: bold; font-size: 0.9rem;
        }
        .badge-admin { background-color: #00ffa3; } /* Badge chủ trọ màu xanh sáng */

        .content-area { flex: 1; }
    </style>
</head>
<body>
<div class="sidebar">
    <div class="brand">
        <svg class="logo-home" viewBox="0 0 100 100">
            <polygon points="10,50 50,15 90,50" fill="#ff4d4d" />
            <rect x="18" y="50" width="64" height="35" fill="#add8e6" />
            <circle cx="50" cy="62" r="6" fill="#0000ff" />
            <path d="M 42 85 L 42 75 A 8 8 0 0 1 58 75 L 58 85 Z" fill="#ff0000" />
        </svg>
        Hệ thống trọ
    </div>

    <div class="nav-list">
        <a href="{{ route('dashboard') }}" class="nav-item">📒 TỔNG QUAN</a>

        <a href="{{ route('rooms.index') }}" class="nav-item">🏠 QUẢN LÝ PHÒNG</a>
        <a href="#" class="nav-item">☰ Quản Lý Khách</a>
        <a href="{{ route('contracts.index') }}" class="nav-item">📑 quản Lý Hợp Đồng</a>
        <a href="{{ route('invoices.index') }}" class="nav-item">⚙️ Quản Lý Hóa Đơn</a>
    </div>

    <div class="logout-container">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">Đăng xuất</button>
        </form>
    </div>
</div>

<div class="main-wrapper">
    <div class="top-header">
        <div class="house-pill">
            <span style="font-size: 1.5rem;">🍄</span> NHÀ TRỌ DUYỆT 7 Trọ
        </div>
        <div class="user-badges">
            <div class="badge badge-admin">🏠 CHỦ TRỌ</div>
            <div class="badge">👨‍💼 NGƯỜI THUÊ</div>
        </div>
    </div>

    <div class="content-area">
        @yield('admin_content')
    </div>
</div>
</body>
</html>

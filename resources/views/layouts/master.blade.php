<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hệ thống trọ')</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        /* 1. Đặt màu nền chung cho toàn web (Xanh lá mạ nhạt) và reset margin */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #c9ffce;
            box-sizing: border-box;
        }

        /* 2. CHIA 2 CỘT: Ép toàn bộ khung hình thành Flexbox */
        .master-container {
            display: flex;
            min-height: 100vh; /* Chiều cao tối thiểu bằng 100% màn hình */
        }

        /* 3. CỘT TRÁI (SIDEBAR) */
        .sidebar {
            width: 250px;
            padding: 20px;
            display: flex;
            flex-direction: column; /* Xếp các phần tử dọc xuống */
        }

        /* Chỉnh logo */
        .sidebar .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 30px;
        }
        .sidebar .logo h2 { margin: 0; font-size: 1.2rem; }
        .sidebar .logo img { width: 30px; height: 30px; } /* Sửa lại kích thước icon nếu cần */

        /* Chỉnh Menu */
        .sidebar .menu ul {
            list-style: none; /* Bỏ dấu chấm tròn */
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .sidebar .menu a {
            display: block;
            background-color: #00c97b; /* Màu xanh đậm của nút menu */
            color: #000;
            text-decoration: none;
            padding: 15px 20px;
            border-radius: 12px;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        /* Nút đăng xuất đẩy xuống đáy */
        .sidebar .logout {
            margin-top: auto;
            padding-bottom: 20px;
        }

        .sidebar .logout button {
            background-color: #00c97b;
            border: none;
            padding: 12px 25px;
            border-radius: 20px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        /* 4. CỘT PHẢI (CHỨA HEADER VÀ NỘI DUNG) */
        .main-wrapper {
            flex: 1; /* Tự động phình to chiếm hết khoảng trống còn lại */
            padding: 20px 30px 20px 10px;
            display: flex;
            flex-direction: column;
        }

        /* 5. HEADER */
        .header {
            display: flex;
            justify-content: space-between; /* Đẩy 2 cục văng ra 2 bên mép */
            align-items: flex-start;
            margin-bottom: 30px;
        }

        .header-left {
            background-color: #00c97b;
            padding: 15px 40px;
            border-radius: 15px;
            font-weight: bold;
            font-size: 1.2rem;
            color: #000;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .header-right {
            display: flex;
            gap: 15px;
        }

        .role-badge, .user-info {
            background-color: #00ff9d;
            padding: 12px 25px;
            border-radius: 15px;
            font-weight: bold;
            color: #000;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
        }

        /* 6. VÙNG HIỂN THỊ NỘI DUNG CHÍNH */
        .content-area {
            flex: 1; /* Trải dài xuống đáy */
        }
    </style>
</head>
<body>

<div class="master-container">

    <aside class="sidebar">
        <div class="logo">
            <span style="font-size: 1.5rem;">🏠</span>
            <h2>Hệ thống trọ</h2>
        </div>
        <nav class="menu">
            <ul>
                <li><a href="{{ url('/dashboard') }}">Tổng quan</a></li>
                <li><a href="{{ url('/rooms') }}">Quản lý phòng</a></li>
                <li><a href="{{ url('/users') }}">Quản lý khách</a></li>
                <li><a href="{{ url('/contracts') }}">Quản lý hợp đồng</a></li>
                <li><a href="{{ url('/invoices') }}">Quản lý hóa đơn</a></li>
            </ul>
        </nav>
        <div class="logout">
            <button>Đăng xuất</button>
        </div>
    </aside>

    <div class="main-wrapper">

        <header class="header">
            <div class="header-left">
                BIG BJ BOY
            </div>
            <div class="header-right">
                <span class="role-badge">Chủ trọ</span>
            </div>
        </header>

        <main class="content-area">
            {{-- Nơi này sẽ nhận nội dung từ các trang con truyền vào --}}
            @yield('content')
        </main>

    </div>
</div>

</body>
</html>

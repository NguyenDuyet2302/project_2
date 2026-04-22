<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">
    <title>Hệ thống 7 trọ</title>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --color-main: #ffffff;
            --bg-main: #F4EFEA;
            --color-primary: #9C7A63;
            --text-dark: #2D231E;
            --text-light: #F9F6F0;
            --accent: #E8D8C4;
        }

        body {
            margin: 0;
            font-family: sans-serif;
            background-color: var(--bg-main);
            color: var(--text-dark);
        }

        .navbar {
            background-color: var(--color-main);
            padding: 15px 10%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .brand {
            font-size: 24px;
            font-weight: bold;
            color: var(--color-primary);
            letter-spacing: 1px;
        }

        .nav-links {
            display: flex;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text-dark);
            margin-left: 25px;
            font-weight: 500;
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .hero {
            background-color: var(--color-primary);
            color: var(--text-light);
            padding: 40px;
            border-radius: 15px;
            margin-bottom: 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .section-title {
            border-left: 4px solid var(--color-primary);
            padding-left: 15px;
            margin-bottom: 25px;
            font-size: 22px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        }

        .room-number {
            font-size: 32px;
            margin: 10px 0;
            color: var(--color-primary);
        }

        .service-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 12px;
            overflow: hidden;
        }

        .service-table th {
            background: var(--accent);
            padding: 15px;
            text-align: left;
        }

        .service-table td {
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
        }

        .badge-usage {
            background: #fff3cd;
            color: #856404;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: bold;
        }

        .logout-btn {
            color: #B85C47;
            cursor: pointer;
            border: none;
            background: none;
            font-weight: bold;
        }

        .btn-auth {
            background-color: var(--color-primary);
            color: white !important;
            padding: 10px 20px;
            border-radius: 8px;
            margin-left: 15px;
        }

        .room-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .room-item {
            background: white;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="brand">
        7 TRỌ
    </div>
    <div class="nav-links">
        <a href="{{ route('home') }}">
            Trang chủ
        </a>
        @if(Auth::check())
            <a href="{{ route('customer.home') }}">
                Phòng của tôi
            </a>
            <form action="{{ route('logout') }}"
                  method="POST"
                  style="display: inline; margin-left: 20px;">
                @csrf
                <button type="submit"
                        class="logout-btn">
                    Thoát
                </button>
            </form>
        @else
            <a href="{{ route('admin.login') }}"
               class="btn-auth">
                Đăng nhập
            </a>
            <a href="{{ route('register') }}"
               class="btn-auth">
                Đăng ký
            </a>
        @endif
    </div>
</nav>

<div class="container">
    @if(Auth::check())
        <div class="hero">
            <div>
                <h1 style="margin: 0;">
                    Xin chào, {{ $khach->name ?? 'Khách hàng' }}!
                </h1>
                <p style="margin: 10px 0 0; opacity: 0.9;">
                    Cảm ơn bạn đã tin tưởng hệ thống 7 Trọ
                </p>
            </div>
            <i class="fa fa-home-user fa-4x"
               style="opacity: 0.3;"></i>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 40px;">
            <div class="card">
                <div class="section-title">
                    Phòng đang thuê
                </div>
                @if($hopdong)
                    <div class="room-number">
                        Phòng {{ $hopdong->room->number }}
                    </div>
                    <p>
                        Giá thuê:
                        <b>{{ number_format($hopdong->room->price) }} VNĐ</b>
                    </p>
                @else
                    <p>
                        Bạn hiện chưa có phòng nào.
                    </p>
                @endif
            </div>

            <div class="card">
                <div class="section-title">
                    Thông tin cá nhân
                </div>
                <p>
                    SĐT: {{ $khach->phone }}
                </p>
                <p>
                    CCCD: {{ $khach->id_card }}
                </p>
            </div>
        </div>

        <div class="card">
            <div class="section-title">
                Chi tiết dịch vụ
            </div>
            @if(count($ds_dien_nuoc) > 0)
                <table class="service-table">
                    <thead>
                    <tr>
                        <th>Loại</th>
                        <th>Dùng</th>
                        <th>Ngày ghi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($ds_dien_nuoc as $item)
                        <tr>
                            <td>
                                {{ $item->service->name }}
                            </td>
                            <td>
                                    <span class="badge-usage">
                                        {{ $item->new_index - $item->old_index }}
                                    </span>
                            </td>
                            <td>
                                {{ date('d/m/Y', strtotime($item->reading_date)) }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p>
                    Chưa có dữ liệu tháng này.
                </p>
            @endif
        </div>
    @else
        <div class="hero">
            <div>
                <h1 style="margin: 0;">
                    Chào mừng đến với 7 Trọ!
                </h1>
                <p style="margin: 10px 0 0;">
                    Vui lòng đăng nhập để xem thông tin cá nhân.
                </p>
            </div>
        </div>

        <div class="section-title">
            Danh sách phòng trống
        </div>
        <div class="room-grid">
            @foreach($rooms as $room)
                <div class="room-item">
                    <div class="room-number">
                        Phòng {{ $room->number }}
                    </div>
                    <p>
                        Giá: {{ number_format($room->price) }} VNĐ
                    </p>
                    <a href="{{ route('register') }}"
                       class="btn-auth"
                       style="margin-left: 0;">
                        Đăng ký thuê
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>

{{--<footer style="text-align: center; padding: 40px; color: #888;">--}}
{{--    &copy; 2024 Hệ Thống 7 Trọ.--}}
{{--</footer>--}}

</body>
</html>

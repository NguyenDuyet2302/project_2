<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hệ thống 7 trọ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            font-weight: bold;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            transition: 0.3s;
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

        .logout-btn {
            color: #B85C47;
            cursor: pointer;
            border: none;
            background: none;
            font-weight: bold;
            margin-left: 20px;
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
    <div class="brand">7 TRỌ</div>
    <div class="nav-links">
        @if(Auth::check())
            <a href="{{ route('customer.profile') }}">Thông tin cá nhân</a>
            <a href="{{ route('customer.home') }}">Phòng của tôi</a>
            <a href="{{ route('customer.statistics') }}">Thống kê tiêu thụ</a>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="logout-btn">Thoát</button>
            </form>
        @else
            <a href="{{ route('admin.login') }}" class="btn-auth">Đăng nhập</a>
            <a href="{{ route('register') }}" class="btn-auth">Đăng ký</a>
        @endif
    </div>
</nav>

<div class="container">
    @if(Auth::check())
        <div class="hero">
            <div>
                <h1 style="margin: 0;">Xin chào, {{ $customer->fullname ?? 'Khách hàng' }}!</h1>
                <p style="margin: 10px 0 0; opacity: 0.9;">Hệ thống quản lý trọ </p>
            </div>
            <i class="fa fa-home-user fa-4x" style="opacity: 0.3;"></i>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 40px;">
            <!-- Phần Phòng đang thuê -->
            <div class="card" style="cursor: pointer;" onclick="location.href='{{ route('customer.contract') }}'">
                <div class="section-title">Phòng đang thuê (Nhấn để xem hợp đồng)</div>
                @if($contract)
                    <div class="room-number">Phòng {{ $contract->room->number }}</div>
                    <p>Diện tích: <b>{{ $contract->room->area }} m²</b></p>
                    <p>Giá thuê: <b>{{ number_format($contract->room->price) }} VNĐ</b></p>
                @else
                    <p>Bạn hiện chưa có phòng nào.</p>
                @endif
            </div>

            <!-- Phần Thông tin cá nhân -->
            <div class="card" style="cursor: pointer;" onclick="location.href='{{ route('customer.profile') }}'">
                <div class="section-title">Thông tin cá nhân</div>
                <p>SĐT: {{ $customer->phone }}</p>
                <p>CCCD: {{ $customer->id_card }}</p>
                <p style="color: var(--color-primary); font-weight: bold; margin-top: 10px;">Chỉnh sửa ngay <i class="fa fa-chevron-right"></i></p>
            </div>
        </div>

        <!-- Phần Hóa đơn chi tiết -->
        <div class="card">
            <div class="section-title">Hóa đơn thanh toán hàng tháng</div>
            @if(isset($invoices) && $invoices->count() > 0)
                <table class="service-table">
                    <thead>
                    <tr>
                        <th>Tháng/Năm</th>
                        <th>Chi tiết dịch vụ (Ghi chỉ số)</th>
                        <th>Tổng tiền</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($invoices as $invoice)
                        <tr>
                            <td><b>{{ $invoice->created_at->format('m/Y') }}</b></td>
                            <td>
                                @if($invoice->invoiceDetails->isNotEmpty())
                                    <div style="font-size: 0.9rem; margin-bottom: 5px;">
                                        Tiền phòng: <b>{{ number_format($invoice->contract->room->price ?? 0) }} VNĐ</b>
                                    </div>
                                    @foreach($invoice->invoiceDetails as $detail)
                                        <div style="font-size: 0.9rem; margin-bottom: 5px;">
                                            {{ $detail->service->name }}: <b>{{ number_format($detail->amount) }} VNĐ</b>
                                            @if($detail->new_index > 0 || $detail->old_index > 0)
                                                ({{ $detail->old_index }} - {{ $detail->new_index }})
                                            @endif
                                        </div>
                                    @endforeach
                                @else
                                    <div style="font-size: 0.9rem; margin-bottom: 5px;">
                                        Tiền phòng: <b>{{ number_format($invoice->contract->room->price ?? 0) }} VNĐ</b>
                                    </div>
                                    <div style="font-size: 0.9rem; color: #666;">
                                        Chưa có dữ liệu trong invoice_details, đang hiển thị theo invoice.
                                    </div>
                                @endif
                            </td>
                            <td style="color: #A04A41; font-weight: bold;">
                                {{ number_format($invoice->total_amount) }} VNĐ
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p>Chưa có hóa đơn nào tháng này.</p>
            @endif
        </div>
    @else
        <!-- Hiển thị cho khách chưa đăng nhập -->
        <div class="hero">
            <h1>Chào mừng đến với 7 Trọ!</h1>
        </div>
        <div class="section-title">Danh sách phòng trống</div>
        <div class="room-grid">
            @foreach($rooms as $room)
                <div class="room-item">
                    <div class="room-number">Phòng {{ $room->number }}</div>
                    <p>Giá: {{ number_format($room->price) }} VNĐ</p>
                    <a href="{{ route('register') }}" class="btn-auth" style="margin-left: 0; display: inline-block;">Đăng ký thuê</a>
                </div>
            @endforeach
        </div>
    @endif
</div>

</body>
</html>

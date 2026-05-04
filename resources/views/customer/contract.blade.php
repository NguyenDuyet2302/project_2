<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Hợp đồng của tôi - 7 TRỌ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --bg-main: #F4EFEA; --color-primary: #9C7A63; --accent: #E8D8C4; }
        body { background-color: var(--bg-main); font-family: sans-serif; margin: 0; }
        .container { max-width: 900px; margin: 40px auto; padding: 0 20px; }
        .card { background: white; border-radius: 15px; padding: 35px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .section-title { border-left: 4px solid var(--color-primary); padding-left: 15px; margin-bottom: 25px; font-size: 22px; font-weight: bold; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; border-top: 1px solid #eee; padding-top: 20px; }
        .info-item { margin-bottom: 15px; }
        .label { font-weight: bold; color: var(--color-primary); display: block; margin-bottom: 5px; }
        .value { font-size: 1.1rem; color: #2D231E; }
        .back-btn { display: inline-block; margin-bottom: 20px; color: var(--color-primary); text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
<div class="container">
    <a href="{{ route('home') }}" class="back-btn"><i class="fa fa-arrow-left"></i> Quay lại trang chủ</a>
    <div class="card">
        <div class="section-title">Chi Tiết Hợp Đồng Thuê Phòng</div>
        @if($contract)
            <div class="info-grid">
                <div class="info-item"><span class="label">Số phòng:</span><span class="value">Phòng {{ $contract->room->number }}</span></div>
                <div class="info-item"><span class="label">Giá thuê:</span><span class="value">{{ number_format($contract->room->price) }} VNĐ/tháng</span></div>
                <div class="info-item"><span class="label">Diện tích:</span><span class="value">{{ $contract->room->area }} m²</span></div>
                <div class="info-item"><span class="label">Ngày bắt đầu:</span><span class="value">{{ date('d/m/Y', strtotime($contract->start_date)) }}</span></div>
                <div class="info-item"><span class="label">Người thuê:</span><span class="value">{{ $customer->fullname }}</span></div>
                <div class="info-item"><span class="label">Trạng thái:</span><span class="value" style="color: #70794C; font-weight: bold;">Đang hiệu lực</span></div>
            </div>
            <div style="margin-top: 30px; padding: 20px; background: #f9f6f0; border-radius: 8px; font-style: italic; color: #666;">
                * Lưu ý: Mọi thay đổi về hợp đồng vui lòng liên hệ trực tiếp với chủ trọ.
            </div>
        @else
            <p style="text-align: center;">Bạn chưa có hợp đồng nào.</p>
        @endif
    </div>
</div>
</body>
</html>

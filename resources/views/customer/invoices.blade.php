<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Hóa đơn thanh toán - 7 TRỌ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --bg-main: #F4EFEA; --color-primary: #9C7A63; --accent: #E8D8C4; }
        body { background-color: var(--bg-main); font-family: sans-serif; margin: 0; }
        .container { max-width: 1000px; margin: 40px auto; padding: 0 20px; }
        .card { background: white; border-radius: 12px; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); margin-bottom: 30px; }
        .invoice-table { width: 100%; border-collapse: collapse; }
        .invoice-table th { background: var(--accent); padding: 12px; text-align: left; }
        .invoice-table td { padding: 15px; border-bottom: 1px solid #eee; vertical-align: top; }
        .detail-list { list-style: none; padding: 0; margin: 0; font-size: 0.9rem; }
        .detail-item { display: flex; justify-content: space-between; margin-bottom: 5px; border-bottom: 1px dashed #ddd; padding-bottom: 3px; }
        .total-price { font-weight: bold; color: #A04A41; font-size: 1.1rem; }
    </style>
</head>
<body>
<div class="container">
    <a href="{{ route('home') }}" style="color: var(--color-primary); text-decoration: none; font-weight: bold; display: block; margin-bottom: 20px;"><i class="fa fa-arrow-left"></i> Quay lại</a>
    <div class="card">
        <h2 style="border-left: 4px solid var(--color-primary); padding-left: 15px; margin-bottom: 25px;">Lịch Sử Hóa Đơn</h2>
        @if($invoices->isNotEmpty())
            <table class="invoice-table">
                <thead>
                <tr>
                    <th>Tháng/Năm</th>
                    <th>Chi Tiết Dịch Vụ (Chỉ số & Giá)</th>
                    <th>Tổng Tiền</th>
                </tr>
                </thead>
                <tbody>
                @foreach($invoices as $invoice)
                    <tr>
                        <td><b>Tháng {{ $invoice->created_at->format('m/Y') }}</b></td>
                        <td>
                            <div class="detail-list">
                                <div class="detail-item"><span>Tiền phòng:</span><b>{{ number_format($invoice->contract->room->price ?? 0) }} VNĐ</b></div>
                                @foreach($invoice->invoiceDetails as $detail)
                                    <div class="detail-item">
                                        <span>
                                            {{ $detail->service->name }}
                                            @if($detail->new_index > 0 || $detail->old_index > 0)
                                                ({{ $detail->old_index }} -> {{ $detail->new_index }})
                                            @endif
                                            :
                                        </span>
                                        <b>{{ number_format($detail->amount) }} VNĐ</b>
                                    </div>
                                @endforeach
                            </div>
                        </td>
                        <td class="total-price">{{ number_format($invoice->total_amount) }} VNĐ</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>Hiện tại chưa có hóa đơn nào </p>
        @endif
    </div>
</div>
</body>
</html>

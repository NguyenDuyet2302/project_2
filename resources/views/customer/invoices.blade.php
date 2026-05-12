<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lịch sử hóa đơn - 7 TRỌ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --bg-main: #F4EFEA;
            --color-primary: #9C7A63;
            --accent: #E8D8C4;
        }

        body {
            margin: 0;
            font-family: sans-serif;
            background-color: var(--bg-main);
        }

        .navbar {
            background-color: #fff;
            padding: 15px 10%;
            display: flex;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .invoice-table th {
            background: var(--accent);
            padding: 12px;
            text-align: left;
        }

        .invoice-table td {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        .btn-pay {
            display: inline-block;
            padding: 8px 15px;
            background: #28a745;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
<nav class="navbar">
    <div style="font-size: 24px; font-weight: bold; color: var(--color-primary);">7 TRỌ</div>
    <div>
        <a href="{{ route('customer.home') }}" style="margin-left: 20px; text-decoration: none; color: #333;">Phòng của tôi</a>
        <a href="{{ route('customer.invoices') }}" style="margin-left: 20px; text-decoration: none; color: #333;">Lịch sử hóa đơn</a>
    </div>
</nav>

<div class="container">
    <div class="card">
        <h2 style="border-left: 4px solid var(--color-primary); padding-left: 15px;">Lịch Sử Hóa Đơn</h2>
        <table class="invoice-table">
            <thead>
            <tr>
                <th>Kỳ hóa đơn</th>
                <th>Chi tiết dịch vụ</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
            </thead>
            <tbody>
            @foreach($invoices as $invoice)
                <tr>
                    <td><b>{{ $invoice->month }}</b></td>
                    <td>
                        @foreach($invoice->invoiceDetails as $detail)
                            @php $name = mb_strtolower($detail->service->name); @endphp
                            <div style="font-size: 0.9rem; margin-bottom: 3px;">
                                {{ $detail->service->name }}: {{ number_format($detail->amount) }}đ
                                @if(in_array($name, ['điện', 'nước']))
                                    <small style="color: #888;">({{ number_format($detail->old_index, 0) }} - {{ number_format($detail->new_index, 0) }})</small>
                                @endif
                            </div>
                        @endforeach
                    </td>
                    <td style="color: #A04A41; font-weight: bold;">{{ number_format($invoice->total_amount) }}đ</td>
                    <td>
                        <span style="font-weight: 500; color: {{ $invoice->status == 1 ? '#28a745' : '#dc3545' }}">
                            {{ $invoice->status == 1 ? 'Đã thanh toán' : 'Chưa thanh toán' }}
                        </span>
                    </td>
                    <td>
                        @if($invoice->status == 0)
                            <a href="#" class="btn-pay">Thanh toán ngay</a>
                        @else
                            <span style="color: #888;">Hoàn tất</span>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
</body>
</html>

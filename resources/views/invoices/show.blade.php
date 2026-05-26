@extends('layouts.master')
@section('title', 'Chi tiết hóa đơn #' . $invoice->id)
@section('content')
    <div style="margin-bottom: 20px;">
        <a href="{{ route('invoices.index') }}" style="text-decoration: none; color: #7C6F66; font-weight: bold; font-size: 0.95rem;">
            <i class="fa-solid fa-arrow-left"></i> Quay lại danh sách
        </a>
    </div>

    <div style="background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); padding: 35px; border-top: 5px solid #9C7A63;">

        <div style="text-align: center; margin-bottom: 30px;">
            <h1 style="margin: 0; font-size: 1.8rem; color: #2D231E; letter-spacing: 1px;">HÓA ĐƠN THANH TOÁN TIỀN PHÒNG</h1>
            <p style="margin: 5px 0 0 0; color: #7C6F66; font-style: italic;">Kỳ hóa đơn: Tháng {{ $invoice->month }}</p>
            <p style="margin: 2px 0 0 0; font-size: 0.9rem; color: #A04A41;">Mã hóa đơn: #HD-{{ str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}</p>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; background: #faf8f5; padding: 20px; border-radius: 8px; margin-bottom: 30px; border: 1px dashed #E8D8C4;">
            <div>
                <p style="margin: 5px 0;"><b>Khách thuê:</b> {{ $invoice->contract->user->fullname ?? 'N/A' }}</p>
                <p style="margin: 5px 0;"><b>Số điện thoại:</b> {{ $invoice->contract->user->phone ?? 'N/A' }}</p>
                <p style="margin: 5px 0;"><b>Mã hợp đồng:</b> HĐ-{{ $invoice->contract_id }}</p>
            </div>
            <div style="text-align: right;">
                <p style="margin: 5px 0;"><b>Số phòng:</b> Phòng {{ $invoice->contract->room->number ?? 'N/A' }}</p>
                <p style="margin: 5px 0;"><b>Giá phòng cơ bản:</b> {{ number_format($invoice->contract->room->price ?? 0, 0, ',', '.') }} đ/tháng</p>
                <p style="margin: 5px 0;"><b>Trạng thái:</b>
                    @if($invoice->status == 1)
                        <span style="color: green; font-weight: bold;"><i class="fa-solid fa-circle-check"></i> Đã thanh toán</span>
                    @else
                        <span style="color: #dc3545; font-weight: bold;"><i class="fa-solid fa-clock"></i> Chưa thanh toán</span>
                    @endif
                </p>
            </div>
        </div>

        <h3 style="font-size: 1.1rem; color: #2D231E; margin-bottom: 12px; border-left: 4px solid #9C7A63; padding-left: 10px;">
            Chi tiết các khoản mục thanh toán
        </h3>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px; font-size: 0.95rem;">
            <thead>
            <tr style="background: #E8D8C4; color: #2D231E; border-bottom: 2px solid #ddd; text-align: left;">
                <th style="padding: 12px; border: 1px solid #ddd;">STT</th>
                <th style="padding: 12px; border: 1px solid #ddd;">Tên dịch vụ/Khoản thu</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: center;">Chỉ số cũ</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: center;">Chỉ số mới</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: center;">Số lượng sử dụng</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: right;">Đơn giá</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: right;">Thành tiền</th>
            </tr>
            </thead>
            <tbody>
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 12px; border: 1px solid #ddd; text-align: center;">1</td>
                <td style="padding: 12px; border: 1px solid #ddd;"><b>Tiền thuê phòng</b></td>
                <td style="padding: 12px; border: 1px solid #ddd; text-align: center; color: #aaa;">-</td>
                <td style="padding: 12px; border: 1px solid #ddd; text-align: center; color: #aaa;">-</td>
                <td style="padding: 12px; border: 1px solid #ddd; text-align: center;">1 tháng</td>
                <td style="padding: 12px; border: 1px solid #ddd; text-align: right;">{{ number_format($invoice->contract->room->price ?? 0, 0, ',', '.') }} đ</td>
                <td style="padding: 12px; border: 1px solid #ddd; text-align: right; font-weight: bold;">{{ number_format($invoice->contract->room->price ?? 0, 0, ',', '.') }} đ</td>
            </tr>

            @php $stt = 2; @endphp
            @forelse($invoice->invoiceDetails as $detail)
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 12px; border: 1px solid #ddd; text-align: center;">{{ $stt++ }}</td>
                    <td style="padding: 12px; border: 1px solid #ddd;">{{ $detail->service->name ?? 'Dịch vụ đã xóa' }}</td>

                    @if($detail->old_index !== null && $detail->new_index > 0)
                        <td style="padding: 12px; border: 1px solid #ddd; text-align: center;">{{ number_format($detail->old_index, 0) }}</td>
                        <td style="padding: 12px; border: 1px solid #ddd; text-align: center;">{{ number_format($detail->new_index, 0) }}</td>
                        <td style="padding: 12px; border: 1px solid #ddd; text-align: center;">{{ number_format($detail->quantity, 0) }} {{ $detail->service->unit_name ?? 'số' }}</td>
                    @else
                        <td style="padding: 12px; border: 1px solid #ddd; text-align: center; color: #aaa;">-</td>
                        <td style="padding: 12px; border: 1px solid #ddd; text-align: center; color: #aaa;">-</td>
                        <td style="padding: 12px; border: 1px solid #ddd; text-align: center;">1</td>
                    @endif

                    <td style="padding: 12px; border: 1px solid #ddd; text-align: right;">{{ number_format($detail->price, 0, ',', '.') }} đ</td>
                    <td style="padding: 12px; border: 1px solid #ddd; text-align: right; font-weight: bold;">{{ number_format($detail->amount, 0, ',', '.') }} đ</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="padding: 15px; text-align: center; color: #888;">Không có chi tiết dịch vụ đi kèm.</td>
                </tr>
            @endforelse

            <tr style="background: #faf8f5; font-size: 1.1rem;">
                <td colspan="6" style="padding: 15px; border: 1px solid #ddd; text-align: right; font-weight: bold; color: #2D231E;">TỔNG SỐ TIỀN CẦN THANH TOÁN:</td>
                <td style="padding: 15px; border: 1px solid #ddd; text-align: right; font-weight: bold; color: #A04A41; font-size: 1.2rem;">
                    {{ number_format($invoice->total_amount, 0, ',', '.') }} VNĐ
                </td>
            </tr>
            </tbody>
        </table>

        <div style="display: flex; justify-content: space-between; margin-top: 40px; padding: 0 20px; font-size: 0.95rem;">
            <div style="text-align: center; width: 200px;">
                <p style="margin-bottom: 60px;"><b>Người thuê phòng</b><br><small>(Ký và ghi rõ họ tên)</small></p>
                <p style="color: #aaa; font-style: italic;">{{ $invoice->contract->user->fullname ?? '' }}</p>
            </div>
            <div style="text-align: center; width: 200px;">
                <p style="margin-bottom: 60px;"><b>Người lập hóa đơn</b><br><small>(Ký và ghi rõ họ tên)</small></p>
                <p style="font-weight: bold; color: #9C7A63;">Chủ nhà trọ</p>
            </div>
        </div>
    </div>
@endsection

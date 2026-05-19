@extends('layouts.master')
@section('title', 'Bước 2: Nhập chỉ số dịch vụ')
@section('content')
    <div style="max-width: 950px; margin: 20px auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <h2 style="border-left: 4px solid #9C7A63; padding-left: 10px; color: #2D231E;">BƯỚC 2: NHẬP CHỈ SỐ TIÊU THỤ</h2>
        <p style="color: #7C6F66;"><b>Đang tính tiền cho:</b> Phòng {{ $contract->room->number }} | <b>Tháng:</b> {{ $month }}</p>

        <form action="{{ route('invoices.store') }}" method="POST">
            @csrf
            <input type="hidden" name="contract_id" value="{{ $contract->id }}">
            <input type="hidden" name="month" value="{{ $month }}">
            <input type="hidden" name="status" value="{{ $status }}">

            <table style="width: 100%; border-collapse: collapse; margin-top: 20px; text-align: left;">
                <thead style="background: #E8D8C4;">
                <tr>
                    <th style="padding: 12px; border: 1px solid #E7DDD3;">Dịch vụ</th>
                    <th style="padding: 12px; border: 1px solid #E7DDD3; width: 140px;">Số mới</th>
                    <th style="padding: 12px; border: 1px solid #E7DDD3; width: 140px;">Số cũ</th>
                    <th style="padding: 12px; border: 1px solid #E7DDD3; width: 140px;">Giá / Số</th>
                    <th style="padding: 12px; border: 1px solid #E7DDD3; width: 180px;">Thành tiền</th>
                </tr>
                </thead>
                <tbody>
                <tr style="background: #fdfaf7;">
                    <td style="padding: 12px; border: 1px solid #E7DDD3;"><b>Tiền phòng</b></td>
                    <td style="padding: 12px; border: 1px solid #E7DDD3; color:#888;">---</td>
                    <td style="padding: 12px; border: 1px solid #E7DDD3; color:#888;">---</td>
                    <td style="padding: 12px; border: 1px solid #E7DDD3;">{{ number_format($contract->room->price, 0, ',', '.') }} đ</td>
                    <td style="padding: 12px; border: 1px solid #E7DDD3; font-weight: bold;">
                        <span class="row-amount" data-value="{{ $contract->room->price }}">{{ number_format($contract->room->price, 0, ',', '.') }}</span> VNĐ
                    </td>
                </tr>

                @foreach($serviceDetails as $item)
                    @php
                        $name = mb_strtolower($item->service->name, 'UTF-8');
                        $isVolumetric = str_contains($name, 'điện') || str_contains($name, 'dien') || str_contains($name, 'nước') || str_contains($name, 'nuoc');
                    @endphp
                    <tr>
                        <td style="padding: 12px; border: 1px solid #E7DDD3;"><b>{{ $item->service->name }}</b></td>
                        @if($isVolumetric)
                            <td style="padding: 12px; border: 1px solid #E7DDD3;">
                                <input type="number" name="services[{{ $item->service_id }}][new_index]" value="{{ $item->new_index }}" class="input-new form-control" data-price="{{ $item->service->unit_price }}" data-old="{{ $item->old_index }}" style="width: 110px; padding: 6px;" required>
                            </td>
                            <td style="padding: 12px; border: 1px solid #E7DDD3;">
                                <input type="number" name="services[{{ $item->service_id }}][old_index]" value="{{ $item->old_index }}" style="width: 110px; padding: 6px; background: #f0f0f0; border: 1px solid #ccc;" readonly>
                            </td>
                        @else
                            <td style="padding: 12px; border: 1px solid #E7DDD3; color:#888;">---</td>
                            <td style="padding: 12px; border: 1px solid #E7DDD3; color:#888;">---</td>
                        @endif
                        <td style="padding: 12px; border: 1px solid #E7DDD3;">{{ number_format($item->service->unit_price, 0, ',', '.') }} đ</td>
                        <td style="padding: 12px; border: 1px solid #E7DDD3; font-weight: bold;">
                            @if($isVolumetric)
                                <span class="service-amount row-amount" data-value="0">0</span> VNĐ
                            @else
                                <span class="row-amount" data-value="{{ $item->service->unit_price }}">{{ number_format($item->service->unit_price, 0, ',', '.') }}</span> VNĐ
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div style="margin-top: 25px; text-align: right; font-size: 1.4rem; font-weight: bold;">
                Tổng tiền hóa đơn: <span id="label_total_amount" style="color: #A04A41;">0</span> VNĐ
            </div>

            <div style="margin-top: 20px; display: flex; gap: 15px; justify-content: flex-end;">
                <a href="{{ route('invoices.create') }}" style="background: #7C6F66; color: white; text-decoration: none; padding: 12px 25px; border-radius: 4px; font-weight: bold;">Quay lại</a>
                <button type="submit" style="background: #9C7A63; color: white; border: none; padding: 12px 30px; font-weight: bold; border-radius: 4px; cursor: pointer;">
                    <i class="fa-solid fa-file-invoice-dollar"></i> Xác nhận & Xuất hóa đơn
                </button>
            </div>
        </form>
    </div>

    <script>
        // Logic tính tiền trực quan tại chỗ bằng JS cơ bản (Thầy cô hỏi bảo tính toán giao diện cho khách dễ nhìn)
        document.querySelectorAll('.input-new').forEach(input => {
            input.addEventListener('input', function() {
                const price = parseFloat(this.getAttribute('data-price')) || 0;
                const oldIdx = parseFloat(this.getAttribute('data-old')) || 0;
                const newIdx = parseFloat(this.value) || 0;

                let qty = newIdx - oldIdx;
                if(qty < 0) qty = 0; // Tránh số âm nếu nhập sai

                const amount = qty * price;
                const spanAmount = this.closest('tr').querySelector('.service-amount');
                spanAmount.setAttribute('data-value', amount);
                spanAmount.innerText = amount.toLocaleString('vi-VN');

                calculateTotal();
            });
            // Chạy kích hoạt lần đầu để hiển thị số tiền mặc định khi load trang
            input.dispatchEvent(new Event('input'));
        });

        function calculateTotal() {
            let total = 0;
            document.querySelectorAll('.row-amount').forEach(span => {
                total += parseFloat(span.getAttribute('data-value')) || 0;
            });
            document.getElementById('label_total_amount').innerText = total.toLocaleString('vi-VN');
        }
    </script>
@endsection

@extends('layouts.master')

@section('title', 'Cập nhật hóa đơn')

@section('content')
    <style>
        .page-title { font-size: 1.8rem; font-weight: normal; margin-bottom: 20px; color: #333; }
        .form-container {
            background: #fff; padding: 40px; border-radius: 15px; border: 1px solid #ddd;
            max-width: 900px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }
        .form-subtitle {
            font-size: 1.1rem; color: #666; margin-bottom: 30px; border-bottom: 2px solid #00ff9d; padding-bottom: 10px; display: inline-block;
        }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 25px; }
        .form-group { display: flex; flex-direction: column; }
        .form-group label { font-weight: bold; margin-bottom: 10px; color: #000; }
        .form-control { padding: 15px; border-radius: 10px; border: 1px solid #ccc; font-size: 1rem; outline: none; transition: 0.2s; }
        .form-control:focus { border-color: #00ff9d; box-shadow: 0 0 0 3px rgba(0, 255, 157, 0.1); }

        .form-actions { display: flex; gap: 20px; margin-top: 40px; justify-content: flex-end; }
        .btn-update { background-color: #00ff9d; color: #000; border: 1px solid #555; padding: 12px 50px; border-radius: 25px; font-weight: bold; font-size: 1.1rem; cursor: pointer; transition: 0.3s; }
        .btn-update:hover { background-color: #00e68e; transform: translateY(-2px); }
        .btn-cancel { background-color: #ff4444; color: #fff; border: 1px solid #555; padding: 12px 50px; border-radius: 25px; font-weight: bold; font-size: 1.1rem; text-decoration: none; text-align: center; }
    </style>

    <div class="page-title">
        Quản Lý Hóa Đơn / <strong>Cập nhật hóa đơn #{{ $invoice->id }}</strong>
    </div>

    <div class="form-container">
        <div class="form-subtitle">CHỈNH SỬA THÔNG TIN CHI TIẾT</div>

        <form method="post" action="{{ route('invoices.update', $invoice->id) }}">
            @csrf
            @method('PUT')

            <div class="form-grid">
                {{-- 1. Chọn Hợp đồng (Pre-selected) --}}
                <div class="form-group" style="grid-column: span 2;">
                    <label>Hợp đồng (Phòng - Khách thuê):</label>
                    <select name="contract_id" class="form-control" required>
                        @foreach($contracts as $contract)
                            <option value="{{ $contract->id }}" {{ $invoice->contract_id == $contract->id ? 'selected' : '' }}>
                                Phòng: {{ $contract->room->number }} - Khách: {{ $contract->user->fullname }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- 2. Tháng hóa đơn --}}
                <div class="form-group">
                    <label>Hóa đơn tháng:</label>
                    <input type="month" name="month" class="form-control" value="{{ $invoice->month }}" required>
                </div>

                {{-- 3. Chỉ số điện --}}
                <div class="form-group">
                    <label>Số điện tiêu thụ (kWh):</label>
                    <input type="number" name="electricity_index" class="form-control" value="{{ $invoice->electricity_index }}" required>
                </div>

                {{-- 4. Chỉ số nước --}}
                <div class="form-group">
                    <label>Số nước tiêu thụ (m3):</label>
                    <input type="number" name="water_index" class="form-control" value="{{ $invoice->water_index }}" required>
                </div>

                {{-- 5. Phí dịch vụ --}}
                <div class="form-group">
                    <label>Phí dịch vụ (VNĐ):</label>
                    <input type="number" name="service_fee" class="form-control" value="{{ $invoice->service_fee }}">
                </div>

                {{-- 6. Trạng thái thanh toán --}}
                <div class="form-group" style="grid-column: span 2;">
                    <label>Trạng thái thanh toán:</label>
                    <select name="status" class="form-control">
                        <option value="0" {{ $invoice->status == 0 ? 'selected' : '' }}>Chưa thanh toán</option>
                        <option value="1" {{ $invoice->status == 1 ? 'selected' : '' }}>Đã thanh toán</option>
                    </select>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('invoices.index') }}" class="btn-cancel">Hủy bỏ</a>
                <button type="submit" class="btn-update">Cập nhật hóa đơn</button>
            </div>
        </form>
    </div>
@endsection

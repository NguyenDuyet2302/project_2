@extends('layouts.master')
@section('title', 'Tạo hóa đơn mới')
@section('content')
    <div class="page-title">
        Quản Lý Hóa Đơn / <strong>Thêm hóa đơn mới</strong>
    </div>

    <div class="form-container">
        <div class="form-subtitle">NHẬP CHỈ SỐ ĐIỆN NƯỚC THÁNG {{ date('m/Y') }}</div>

        <form method="post" action="{{ route('invoices.store') }}">
            @csrf

            <div class="form-grid">
                <div class="form-group" style="grid-column: span 2;">
                    <label>Chọn Hợp đồng (Phòng - Khách thuê):</label>
                    <select name="contract_id" class="form-control" required>
                        <option value="">-- Chọn hợp đồng để xuất hóa đơn --</option>
                        @foreach($contracts as $contract)
                            <option value="{{ $contract->id }}">
                                Phòng: {{ $contract->room->number }} - Khách: {{ $contract->user->fullname }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Hóa đơn tháng:</label>
                    <input type="month" name="month" class="form-control" value="{{ date('Y-m') }}" required>
                </div>

                <div class="form-group">
                    <label>Số điện tiêu thụ (kWh):</label>
                    <input type="number" name="electricity_index" class="form-control" placeholder="Ví dụ: 50" required>
                </div>

                <div class="form-group">
                    <label>Số nước tiêu thụ (m3):</label>
                    <input type="number" name="water_index" class="form-control" placeholder="Ví dụ: 5" required>
                </div>

                <div class="form-group">
                    <label>Phí dịch vụ (Rác, Wifi...):</label>
                    <input type="number" name="service_fee" class="form-control" value="50000">
                </div>

                <div class="form-group" style="grid-column: span 2;">
                    <label>Trạng thái thanh toán:</label>
                    <select name="status" class="form-control">
                        <option value="0">Chưa thanh toán</option>
                        <option value="1">Đã thanh toán</option>
                    </select>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('invoices.index') }}" class="btn-cancel">Hủy bỏ</a>
                <button type="submit" class="btn-save">Xuất hóa đơn</button>
            </div>
        </form>
    </div>
@endsection

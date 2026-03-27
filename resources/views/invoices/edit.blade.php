@extends('layouts.master')
@section('title', 'Cập nhật hóa đơn')
@section('content')
    <div class="page-title">
        Quản Lý Hóa Đơn / <strong>Cập nhật hóa đơn #{{ $invoice->id }}</strong>
    </div>

    <div class="form-container">
        <div class="form-subtitle">CHỈNH SỬA THÔNG TIN CHI TIẾT</div>

        <form method="post" action="{{ route('invoices.update', $invoice->id) }}">
            @csrf
            @method('PUT')

            <div class="form-grid">
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

                <div class="form-group">
                    <label>Hóa đơn tháng:</label>
                    <input type="month" name="month" class="form-control" value="{{ $invoice->month }}" required>
                </div>

                <div class="form-group">
                    <label>Số điện tiêu thụ (kWh):</label>
                    <input type="number" name="electricity_index" class="form-control" value="{{ $invoice->electricity_index }}" required>
                </div>

                <div class="form-group">
                    <label>Số nước tiêu thụ (m3):</label>
                    <input type="number" name="water_index" class="form-control" value="{{ $invoice->water_index }}" required>
                </div>

                <div class="form-group">
                    <label>Phí dịch vụ (VNĐ):</label>
                    <input type="number" name="service_fee" class="form-control" value="{{ $invoice->service_fee }}">
                </div>

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

@extends('layouts.master')
@section('title', 'Tạo hợp đồng mới')
@section('content')
    <div class="page-title">
        Quản Lý Hợp Đồng / <strong>Tạo hợp đồng mới</strong>
    </div>

    <div class="form-container">
        <div class="form-subtitle">CHI TIẾT THỎA THUẬN THUÊ PHÒNG</div>

        @if ($errors->any())
            <div style="background: #ffe6e6; color: red; padding: 15px; border-radius: 10px; margin-bottom: 20px; border: 1px solid red;">
                <b>Vui lòng kiểm tra lại:</b>
                <ul style="margin: 5px 0 0 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="post" action="{{ route('contracts.store') }}">
            @csrf

            <div class="form-grid">
                <div class="form-group">
                    <label>Khách thuê phòng:</label>
                    <select name="user_id" class="form-control" required>
                        <option value="">-- Chọn khách thuê --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->fullname }} - {{ $user->phone }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Phòng thuê:</label>
                    <select name="room_id" class="form-control" required>
                        <option value="">-- Chọn số phòng --</option>
                        @forelse($rooms as $room)
                            <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                Phòng: {{ $room->number }} (Giá: {{ number_format($room->price, 0, ',', '.') }}đ)
                            </option>
                        @empty
                            <option value="" disabled>--- Không có phòng nào đang trống ---</option>
                        @endforelse
                    </select>
                </div>

                <div class="form-group">
                    <label>Ngày bắt đầu hợp đồng:</label>
                    <input type="date" name="start_date" class="form-control" value="{{ old('start_date', date('Y-m-d')) }}" required>
                </div>

                <div class="form-group">
                    <label>Ngày kết thúc (Dự kiến):</label>
                    <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}">
                </div>

                <div class="form-group">
                    <label>Số tiền đặt cọc (VNĐ):</label>
                    <input type="number" name="deposit" class="form-control" value="{{ old('deposit') }}" placeholder="Ví dụ: 2000000" required>
                </div>

                <div class="form-group">
                    <label>Trạng thái hợp đồng:</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Đang hiệu lực (Mới)</option>
                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Đã kết thúc</option>
                    </select>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('contracts.index') }}" class="btn-cancel">Hủy bỏ</a>
                <button type="submit" class="btn-save">Lập hợp đồng</button>
            </div>
        </form>
    </div>
@endsection

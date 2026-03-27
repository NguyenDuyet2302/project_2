@extends('layouts.master')
@section('title', 'Cập nhật hợp đồng')
@section('content')
    <div class="page-title">
        Quản Lý Hợp Đồng / <strong>Cập nhật hợp đồng #{{ $contract->id }}</strong>
    </div>

    <div class="form-container">
        <div class="form-subtitle">CHỈNH SỬA CHI TIẾT THỎA THUẬN</div>

        <form method="post" action="{{ route('contracts.update', $contract->id) }}">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="form-group">
                    <label>Khách thuê phòng:</label>
                    <select name="user_id" class="form-control" required>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $contract->user_id == $user->id ? 'selected' : '' }}>
                                {{ $user->fullname }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Phòng thuê:</label>
                    <select name="room_id" class="form-control" required>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}" {{ $contract->room_id == $room->id ? 'selected' : '' }}>
                                Phòng: {{ $room->number }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Ngày bắt đầu:</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $contract->start_date }}" required>
                </div>

                <div class="form-group">
                    <label>Ngày kết thúc (Dự kiến):</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $contract->end_date }}">
                </div>

                <div class="form-group">
                    <label>Tiền đặt cọc (VNĐ):</label>
                    <input type="number" name="deposit" class="form-control" value="{{ $contract->deposit }}" required>
                </div>

                <div class="form-group">
                    <label>Trạng thái hợp đồng:</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ $contract->status == 1 ? 'selected' : '' }}>Đang hiệu lực</option>
                        <option value="0" {{ $contract->status == 0 ? 'selected' : '' }}>Đã kết thúc</option>
                    </select>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('contracts.index') }}" class="btn-cancel">Hủy bỏ</a>
                <button type="submit" class="btn-update">Cập nhật hợp đồng</button>
            </div>
        </form>
    </div>
@endsection

@extends('layouts.master')

@section('title', 'Cập nhật hồ sơ khách trọ')

@section('content')
    <div class="page-title">
        Quản Lý Khách / <strong>Cập nhật hồ sơ khách: {{ $user->fullname }}</strong>
    </div>

    <div class="form-container">
        <div class="form-subtitle">CHỈNH SỬA THÔNG TIN HỒ SƠ CỦA KHÁCH </div>

        <form method="post" action="{{ route('users.update', $user->id) }}">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="form-group">
                    <label>Họ tên khách trọ (Tên): </label>
                    <input type="text" name="fullname" class="form-control" value="{{ $user->fullname }}" required>
                </div>

                <div class="form-group">
                    <label>Số điện thoại (SĐT): </label>
                    <input type="text" name="phone" class="form-control" value="{{ $user->phone }}" required>
                </div>

                <div class="form-group">
                    <label>Số CMND / CCCD: </label>
                    <input type="text" name="id_card" class="form-control" value="{{ $user->id_card }}" required>
                </div>

                <div class="form-group">
                    <label>Ngày bắt đầu ở (Ngày vào): </label>
                    <input type="date" name="start_date" class="form-control" value="{{ $user->start_date ?? date('Y-m-d') }}" required>
                </div>

                <div class="form-group full-width">
                    <label>Địa chỉ thường trú (Địa chỉ): </label>
                    <input type="text" name="address" class="form-control" value="{{ $user->address }}" required>
                </div>

                <div class="form-group">
                    <label>Vai trò hệ thống: </label>
                    <input type="text" class="form-control" value="Khách thuê" disabled>
                    <input type="hidden" name="role" value="0">
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Trạng thái tài khoản</label>
                    <select name="status" style="width: 100%; padding: 10px; border: 1px solid #C4B7AB;">
                        <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Đang hoạt động</option>
                        <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Khóa tài khoản</option>
                    </select>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('users.index') }}" class="btn-cancel">Hủy bỏ</a>
                <button type="submit" class="btn-update">Cập nhật hồ sơ</button>
            </div>
        </form>
    </div>
@endsection

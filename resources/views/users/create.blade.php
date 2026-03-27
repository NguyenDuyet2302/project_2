@extends('layouts.master')
@section('title', 'Lập hồ sơ khách trọ mới')
@section('content')
    <div class="page-title">
        Quản Lý Khách / <strong>Lập hồ sơ khách mới</strong>
    </div>

    <div class="form-container">
        <div class="form-subtitle">THÔNG TIN HỒ SƠ CƠ BẢN (DÀNH CHO CHỦ TRỌ)</div>

        <form method="post" action="{{ route('users.store') }}">
            @csrf

            <div class="form-grid">
                <div class="form-group">
                    <label>Họ tên khách trọ (Tên):</label>
                    <input type="text" name="fullname" class="form-control" placeholder="Nhập đầy đủ họ tên khách..." required>
                </div>

                <div class="form-group">
                    <label>Số điện thoại (SĐT):</label>
                    <input type="text" name="phone" class="form-control" placeholder="Ví dụ: 0912345678" required>
                </div>

                <div class="form-group">
                    <label>Số CMND / CCCD:</label>
                    <input type="text" name="id_card" class="form-control" placeholder="Nhập số CCCD..." required>
                </div>

                <div class="form-group">
                    <label>Ngày bắt đầu vào ở (Ngày vào):</label>
                    <input type="date" name="start_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>

                <div class="form-group full-width">
                    <label>Địa chỉ thường trú (Địa chỉ):</label>
                    <input type="text" name="address" class="form-control" placeholder="Nhập địa chỉ quê quán/thường trú..." required>
                </div>

                <div class="form-group">
                    <label>Vai trò hệ thống:</label>
                    <input type="text" class="form-control" value="Khách thuê" disabled>
                    <input type="hidden" name="role" value="0">
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('users.index') }}" class="btn-cancel">Hủy bỏ</a>
                <button type="submit" class="btn-save">Lập hồ sơ</button>
            </div>
        </form>
    </div>
@endsection

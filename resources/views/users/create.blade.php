@extends('layouts.master')
@section('title', 'Lap ho so khach tro moi')
@section('content')
    <div class="page-title">
        Quan Ly Khach / <strong>Lap ho so khach moi</strong>
    </div>

    <div class="form-container">
        <div class="form-subtitle">THONG TIN HO SO CO BAN (DANH CHO CHU TRO)</div>

        <form method="post" action="{{ route('users.store') }}">
            @csrf

            <div class="form-grid">
                <div class="form-group">
                    <label>Ho ten khach tro (Ten):</label>
                    <input type="text" name="fullname" class="form-control" placeholder="Nhap day du ho ten khach..." value="{{ old('fullname') }}" required>
                </div>

                <div class="form-group">
                    <label>So dien thoai (SDT):</label>
                    <input type="text" name="phone" class="form-control" placeholder="Vi du: 0912345678" value="{{ old('phone') }}" required>
                </div>

                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="email" class="form-control" placeholder="Vi du: khachhang@email.com" value="{{ old('email') }}" required>
                </div>

                <div class="form-group">
                    <label>So CMND / CCCD:</label>
                    <input type="text" name="id_card" class="form-control" placeholder="Nhap so CCCD..." value="{{ old('id_card') }}" required>
                </div>

                <div class="form-group">
                    <label>Ngay bat dau vao o (Ngay vao):</label>
                    <input type="date" name="start_date" class="form-control" value="{{ old('start_date', date('Y-m-d')) }}" required>
                </div>

                <div class="form-group full-width">
                    <label>Dia chi thuong tru (Dia chi):</label>
                    <input type="text" name="address" class="form-control" placeholder="Nhap dia chi que quan/thuong tru..." value="{{ old('address') }}" required>
                </div>

                <div class="form-group">
                    <label>Vai tro he thong:</label>
                    <input type="text" class="form-control" value="Khach thue" disabled>
                    <input type="hidden" name="role" value="0">
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('users.index') }}" class="btn-cancel">Huy bo</a>
                <button type="submit" class="btn-save">Lap ho so</button>
            </div>
        </form>
    </div>
@endsection

@extends('layouts.master')

@section('title', 'Lập hồ sơ khách trọ mới')

@section('content')
    <style>
        .page-title { font-size: 1.8rem; font-weight: normal; margin-bottom: 20px; color: #333; }

        /* Khung chứa Form chuyên nghiệp */
        .form-container {
            background: #fff;
            padding: 40px;
            border-radius: 15px;
            border: 1px solid #ddd;
            max-width: 900px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .form-subtitle {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 30px;
            border-bottom: 2px solid #00ff9d;
            padding-bottom: 10px;
            display: inline-block;
        }

        /* Layout chia 2 cột cho form gọn gàng */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            grid-column: span 2;
        }

        .form-group label {
            font-weight: bold;
            margin-bottom: 10px;
            color: #000;
        }

        .form-control {
            padding: 15px;
            border-radius: 10px;
            border: 1px solid #ccc;
            font-size: 1rem;
            outline: none;
            transition: 0.2s;
        }

        .form-control:focus {
            border-color: #00ff9d;
            box-shadow: 0 0 0 3px rgba(0, 255, 157, 0.1);
        }

        /* Style riêng cho ô input bị khóa */
        .form-control:disabled {
            background-color: #eee;
            color: #555;
            cursor: not-allowed;
            border-color: #ddd;
        }

        /* Khu vực nút bấm */
        .form-actions {
            display: flex;
            gap: 20px;
            margin-top: 40px;
            justify-content: flex-end; /* Đẩy nút sang phải */
        }

        .btn-save {
            background-color: #00ff9d;
            color: #000;
            border: 1px solid #555;
            padding: 12px 50px;
            border-radius: 25px;
            font-weight: bold;
            font-size: 1.1rem;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn-save:hover { background-color: #00e68e; transform: translateY(-2px); }

        .btn-cancel {
            background-color: #ff4444;
            color: #fff;
            border: 1px solid #555;
            padding: 12px 50px;
            border-radius: 25px;
            font-weight: bold;
            font-size: 1.1rem;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: 0.3s;
        }
        .btn-cancel:hover { background-color: #cc0000; transform: translateY(-2px); }
    </style>

    <div class="page-title">
        Quản Lý Khách / <strong>Lập hồ sơ khách mới</strong>
    </div>

    <div class="form-container">
        <div class="form-subtitle">THÔNG TIN HỒ SƠ CƠ BẢN (DÀNH CHO CHỦ TRỌ)</div>

        {{-- Form gửi đến route store --}}
        <form method="post" action="{{ route('users.store') }}">
            @csrf

            <div class="form-grid">
                {{-- 1. Họ tên --}}
                <div class="form-group">
                    <label>Họ tên khách trọ (Tên):</label>
                    <input type="text" name="fullname" class="form-control" placeholder="Nhập đầy đủ họ tên khách..." required>
                </div>

                {{-- 2. Số điện thoại --}}
                <div class="form-group">
                    <label>Số điện thoại (SĐT):</label>
                    <input type="text" name="phone" class="form-control" placeholder="Ví dụ: 0912345678" required>
                </div>

                {{-- 3. CCCD --}}
                <div class="form-group">
                    <label>Số CMND / CCCD:</label>
                    <input type="text" name="id_card" class="form-control" placeholder="Nhập số CCCD..." required>
                </div>

                {{-- 4. Ngày vào --}}
                <div class="form-group">
                    <label>Ngày bắt đầu vào ở (Ngày vào):</label>
                    <input type="date" name="start_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>

                {{-- 5. Địa chỉ (Full width) --}}
                <div class="form-group full-width">
                    <label>Địa chỉ thường trú (Địa chỉ):</label>
                    <input type="text" name="address" class="form-control" placeholder="Nhập địa chỉ quê quán/thường trú..." required>
                </div>

                {{-- 6. Vai trò (MẶC ĐỊNH LÀ KHÁCH - KHÔNG CHO SỬA) --}}
                <div class="form-group">
                    <label>Vai trò hệ thống:</label>
                    <input type="text" class="form-control" value="Khách thuê" disabled>
                    {{-- Đổi giá trị sang số 0 để khớp kiểu dữ liệu INT trong database --}}
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

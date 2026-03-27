@extends('layouts.master')

@section('title', 'Tổng quan hệ thống')

@section('content')
    <style>
        .title-group h1 {
            margin: 0;
            font-size: 1.6rem;
            font-weight: bold;
        }

        .title-group p {
            margin: 5px 0 35px 0;
            color: #fff;
            font-size: 0.9rem;
            font-weight: 500;
            text-transform: uppercase;
        }

        .stats-container {
            display: flex;
            gap: 30px;
        }

        .stat-box {
            background-color: #80ffc0; /* Màu xanh ngọc của các thẻ card */
            flex: 1;
            padding: 40px 25px;
            border-radius: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 250px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .stat-box h3 {
            margin: 0;
            font-size: 1.2rem;
            color: #000;
            font-weight: 600;
            width: 80%;
        }

        .stat-box .number {
            font-size: 4rem;
            font-weight: bold;
            color: #fff;
            margin-top: auto;
        }
    </style>

    <div class="title-group">
        <h1>TỔNG QUAN</h1>
        <p>THỐNG KÊ TÌNH TRẠNG NHÀ TRỌ</p>
    </div>

    <div class="stats-container">
        <div class="stat-box">
            <h3>TỔNG SỐ PHÒNG</h3>
            {{-- Đã thay bằng biến tổng số phòng --}}
            <div class="number">{{ $totalRooms ?? 0 }}</div>
        </div>
        <div class="stat-box">
            <h3>ĐANG THUÊ</h3>
            {{-- Đã thay bằng biến số phòng đang thuê --}}
            <div class="number">{{ $rentedRooms ?? 0 }}</div>
        </div>
        <div class="stat-box">
            <h3>CÒN TRỐNG</h3>
            {{-- Đã thay bằng biến số phòng còn trống --}}
            <div class="number">{{ $availableRooms ?? 0 }}</div>
        </div>
        <div class="stat-box">
            <h3>DOANH THU THÁNG</h3>
            {{-- Phần này tạm thời để cứng, sau này tính toán Hóa đơn xong sẽ thay thế sau --}}
            <div class="number">Chưa có</div>
        </div>
    </div>
@endsection

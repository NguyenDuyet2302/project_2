@extends('layouts.master')
@section('title', 'Tổng quan hệ thống')
@section('content')
    <div class="title-group">
        <h1>TỔNG QUAN</h1>
        <p>THỐNG KÊ TÌNH TRẠNG NHÀ TRỌ</p>
    </div>

    <div class="stats-container">
        <div class="stat-box">
            <h3>TỔNG SỐ PHÒNG</h3>
            <div class="number">{{ $totalRooms ?? 0 }}</div>
        </div>
        <div class="stat-box">
            <h3>ĐANG THUÊ</h3>
            <div class="number">{{ $rentedRooms ?? 0 }}</div>
        </div>
        <div class="stat-box">
            <h3>CÒN TRỐNG</h3>
            <div class="number">{{ $availableRooms ?? 0 }}</div>
        </div>
        <div class="stat-box">
            <h3>DOANH THU THÁNG</h3>
            <div class="number">1VND</div>
        </div>
    </div>
@endsection

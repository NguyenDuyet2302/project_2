@extends('layouts.master')
@section('title', 'Tổng quan hệ thống')
@section('content')
    <div class="title-group">
        <h1>TỔNG QUAN</h1>
        <p>THỐNG KÊ TÌNH TRẠNG NHÀ TRỌ & DOANH THU</p>
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
        <div class="stat-box" style="background-color: #E8D8C4;">
            <h3>DOANH THU THÁNG NÀY</h3>
            <div class="number" style="color: #A04A41;">{{ number_format($currentMonthRevenue ?? 0) }} VNĐ</div>
        </div>
    </div>

    <div class="card" style="background: #ffffff; padding: 20px; border-radius: 8px; margin-top: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <h2 style="font-size: 1.2rem; color: #2D231E; margin-bottom: 20px; border-left: 4px solid #9C7A63; padding-left: 10px;">
            Biểu đồ doanh thu thực tế năm {{ date('Y') }}
        </h2>
        <div style="position: relative; height: 350px; width: 100%;">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const chartLabels = {!! json_encode($chartLabels) !!};
        const revenueData = {!! json_encode($monthlyRevenueData) !!};

        new Chart(document.getElementById('revenueChart'), {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Doanh thu (VNĐ)',
                    data: revenueData,
                    backgroundColor: '#9C7A63', // Màu đồng bộ với hệ thống 7 Trọ
                    borderColor: '#7C6F66',
                    borderWidth: 1,
                    borderRadius: 4,
                    maxBarThickness: 45
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString('vi-VN') + ' đ';
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Doanh thu: ' + context.raw.toLocaleString('vi-VN') + ' VNĐ';
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection

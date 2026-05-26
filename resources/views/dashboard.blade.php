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
            <div class="number" style="color: #A04A41;">{{ number_format($currentMonthRevenue ?? 0, 0, ',', '.') }} VNĐ</div>
        </div>
    </div>

    <div class="card" style="background: #ffffff; padding: 20px; border-radius: 8px; margin-top: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <h2 style="font-size: 1.2rem; color: #2D231E; margin-bottom: 5px; border-left: 4px solid #9C7A63; padding-left: 10px;">
            Biểu đồ doanh thu thực tế năm {{ date('Y') }}
        </h2>
        <p style="font-size: 0.85rem; color: #7c6f66; padding-left: 14px; margin-bottom: 15px;">💡 <i>Mẹo: Bấm vào một cột tháng bất kỳ trên biểu đồ để xem chi tiết danh sách các hóa đơn thu tiền của tháng đó.</i></p>
        <div style="position: relative; height: 320px; width: 100%;">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    @if($selectedMonthName)
        <div class="card" id="detail_invoice_section" style="background: #ffffff; padding: 20px; border-radius: 8px; margin-top: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-top: 3px solid #9C7A63;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <h2 style="font-size: 1.2rem; color: #2D231E; margin: 0;">
                    Danh sách hóa đơn đã thu tiền trong: <span style="color: #A04A41;">{{ $selectedMonthName }}</span>
                </h2>
                <a href="{{ route('dashboard') }}" style="font-size: 0.9rem; text-decoration: none; color: #7C6F66; font-weight: bold;"><i class="fa-solid fa-xmark"></i> Đóng xem chi tiết</a>
            </div>

            @if($detailedInvoices->isEmpty())
                <p style="text-align: center; color: #888; padding: 20px;">Không có hóa đơn nào đã thanh toán trong tháng này.</p>
            @else
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.95rem;">
                    <thead>
                    <tr style="background: #E8D8C4; color: #2D231E;">
                        <th style="padding: 10px; border: 1px solid #ddd;">Kỳ hóa đơn</th>
                        <th style="padding: 10px; border: 1px solid #ddd;">Phòng</th>
                        <th style="padding: 10px; border: 1px solid #ddd;">Khách hàng</th>
                        <th style="padding: 10px; border: 1px solid #ddd;">Tổng tiền</th>
                        <th style="padding: 10px; border: 1px solid #ddd;">Trạng thái</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($detailedInvoices as $invoice)
                        <tr>
                            <td style="padding: 10px; border: 1px solid #ddd;"><b>{{ $invoice->month }}</b></td>
                            <td style="padding: 10px; border: 1px solid #ddd;">Phòng {{ $invoice->contract->room->number ?? 'N/A' }}</td>
                            <td style="padding: 10px; border: 1px solid #ddd;">{{ $invoice->contract->user->fullname ?? 'N/A' }}</td>
                            <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold; color: #A04A41;">{{ number_format($invoice->total_amount, 0, ',', '.') }} đ</td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><span style="color: green; font-weight: bold;"><i class="fa-solid fa-circle-check"></i> Đã thanh toán</span></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <script>
            window.onload = function() {
                document.getElementById('detail_invoice_section').scrollIntoView({ behavior: 'smooth' });
            };
        </script>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const chartLabels = {!! json_encode($chartLabels) !!};
        const revenueData = {!! json_encode($monthlyRevenueData) !!};

        const ctx = document.getElementById('revenueChart');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Doanh thu (VNĐ)',
                    data: revenueData,
                    backgroundColor: '#9C7A63',
                    borderColor: '#7C6F66',
                    borderWidth: 1,
                    borderRadius: 4,
                    maxBarThickness: 45
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                // LẮNG NGHE SỰ KIỆN CLICK VÀO CỘT DOANH THU
                onClick: (event, elements, chart) => {
                    if (elements.length > 0) {
                        // Lấy ra vị trí index của cột vừa click (Tháng 1 là 0, Tháng 2 là 1,...)
                        const clickedElementIndex = elements[0].index;

                        // Chuyển hướng URL trang dashboard đính kèm tham số selected_month
                        window.location.href = `{{ route('dashboard') }}?selected_month=${clickedElementIndex}`;
                    }
                },
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

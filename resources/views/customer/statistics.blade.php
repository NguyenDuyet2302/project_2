<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thống kê tiêu thụ - 7 TRỌ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --bg-main: #F4EFEA;
            --color-main: #ffffff;
            --color-primary: #9C7A63;
            --accent: #E8D8C4;
            --text-dark: #2D231E;
            --muted: #7C6F66;
            --border: #E7DDD3;
        }

        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: sans-serif;
            background: var(--bg-main);
            color: var(--text-dark);
        }

        .navbar {
            background: var(--color-main);
            padding: 15px 10%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .brand {
            font-size: 24px;
            font-weight: 700;
            color: var(--color-primary);
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text-dark);
            margin-left: 25px;
            font-weight: 500;
        }

        .logout-btn {
            color: #B85C47;
            cursor: pointer;
            border: none;
            background: none;
            font-weight: 700;
            margin-left: 20px;
        }

        .container {
            max-width: 1180px;
            margin: 36px auto 48px;
            padding: 0 20px;
        }

        .hero {
            background: var(--color-primary);
            color: #fff;
            border-radius: 14px;
            padding: 28px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }

        .hero h1 {
            margin: 0;
            font-size: 30px;
        }

        .hero p {
            margin: 10px 0 0;
            opacity: 0.92;
        }

        .meta-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 28px;
        }

        .card {
            background: #fff;
            border-radius: 12px;
            padding: 22px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        }

        .meta-label {
            font-size: 13px;
            color: var(--muted);
            margin-bottom: 8px;
        }

        .meta-value {
            font-size: 24px;
            font-weight: 700;
            color: var(--color-primary);
        }

        .chart-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
            margin-bottom: 28px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 700;
            margin: 0 0 18px;
            padding-left: 14px;
            border-left: 4px solid var(--color-primary);
        }

        .chart-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 16px;
        }

        .chart-note {
            color: var(--muted);
            font-size: 14px;
            line-height: 1.5;
        }

        .chart-wrap {
            position: relative;
            height: 320px;
        }

        .service-table {
            width: 100%;
            border-collapse: collapse;
        }

        .service-table th,
        .service-table td {
            padding: 14px 16px;
            border-bottom: 1px solid #F0E7DF;
            text-align: left;
        }

        .service-table thead th {
            background: var(--accent);
            font-size: 14px;
        }

        .money {
            font-weight: 700;
            color: #A04A41;
        }

        .empty-state {
            color: var(--muted);
            padding: 12px 0 4px;
        }

        @media (max-width: 900px) {
            .meta-grid,
            .chart-grid {
                grid-template-columns: 1fr;
            }

            .hero {
                padding: 24px;
                align-items: flex-start;
            }

            .hero i {
                display: none;
            }
        }
    </style>
</head>
<body>
<nav class="navbar">
    <div class="brand">7 TRỌ</div>
    <div class="nav-links">
        <a href="{{ route('customer.home') }}">Phòng của tôi</a>
        <a href="{{ route('customer.statistics') }}" style="color: var(--color-primary);">Thống kê tiêu thụ</a>
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="logout-btn">Thoát</button>
        </form>
    </div>
</nav>

<div class="container">
    @if($contract)
        <div class="hero">
            <div>
                <h1>Thống kê điện, nước theo tháng</h1>
                <p>Dữ liệu được cập nhật dựa trên chỉ số nhập hàng tháng.</p>
            </div>
            <i class="fa-solid fa-chart-column fa-3x" style="opacity: 0.25;"></i>
        </div>

        <div class="chart-grid">
            <div class="card">
                <div class="chart-card-header">
                    <h2 class="section-title">Biểu đồ điện</h2>
                </div>
                <div class="chart-wrap">
                    <canvas id="electricityChart"></canvas>
                </div>
            </div>

            <div class="card">
                <div class="chart-card-header">
                    <h2 class="section-title">Biểu đồ nước</h2>
                </div>
                <div class="chart-wrap">
                    <canvas id="waterChart"></canvas>
                </div>
            </div>
        </div>

        <div class="card">
            <h2 class="section-title">Bảng dịch vụ cố định</h2>
        </div>
    @endif
</div>

@if($contract)
    <script>
        const chartLabels = @json($chartLabels);
        const electricityUsage = @json($electricityUsage);
        const waterUsage = @json($waterUsage);

        const baseOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    },
                    grid: {
                        color: '#EEE5DC'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        };

        new Chart(document.getElementById('electricityChart'), {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Điện',
                    data: electricityUsage,
                    backgroundColor: '#C9825D',
                    borderRadius: 6,
                    maxBarThickness: 34
                }]
            },
            options: baseOptions
        });

        new Chart(document.getElementById('waterChart'), {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Nước',
                    data: waterUsage,
                    borderColor: '#4F8A8B',
                    backgroundColor: 'rgba(79, 138, 139, 0.18)',
                    fill: true,
                    tension: 0.3,
                    pointRadius: 4,
                    pointHoverRadius: 5
                }]
            },
            options: baseOptions
        });
    </script>
@endif
</body>
</html>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thông tin cá nhân - 7 TRỌ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --bg-main: #F4EFEA;
            --color-primary: #9C7A63;
            --text-dark: #2D231E;
            --accent: #E8D8C4;
        }

        body {
            margin: 0;
            font-family: sans-serif;
            background-color: var(--bg-main);
            color: var(--text-dark);
        }

        .navbar {
            background-color: #ffffff;
            padding: 15px 10%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .brand { font-size: 24px; font-weight: bold; color: var(--color-primary); }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 0 20px;
        }

        .profile-card {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            position: relative;
        }

        .back-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            color: var(--text-dark);
            text-decoration: none;
            font-size: 20px;
        }

        .profile-header {
            text-align: center;
            border-bottom: 2px solid var(--accent);
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .info-row {
            display: flex;
            margin-bottom: 20px;
            align-items: center;
            gap: 15px;
        }

        .info-label {
            flex: 0 0 160px;
            background: var(--accent);
            padding: 12px;
            border-radius: 8px;
            font-weight: bold;
            text-align: center;
        }

        .info-value {
            flex: 1;
            background: #fdfcfb;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #E0D7CD;
        }

        .btn-submit {
            display: block;
            width: 200px;
            margin: 30px auto 0;
            background-color: #55efc4;
            color: #2d3436;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="brand">7 TRỌ</div>
    <div class="nav-links">
        <a href="{{ route('home') }}" style="text-decoration: none; color: var(--text-dark);">Trang chủ</a>
    </div>
</nav>

<div class="container">
    <div class="profile-card">
        <a href="{{ route('home') }}" class="back-btn"><i class="fa fa-arrow-left"></i></a>
        <div class="profile-header">
            <h2 style="margin: 0;">Thông Tin Của Bạn</h2>
        </div>

        <form action="{{ route('customer.profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="info-row">
                <label class="info-label">Họ tên</label>
                <input type="text" name="fullname" class="info-value" value="{{ Auth::user()->fullname }}" required>
            </div>

            <div class="info-row">
                <label class="info-label">Số điện thoại</label>
                <input type="text" name="phone" class="info-value" value="{{ Auth::user()->phone }}" required>
            </div>

            <div class="info-row">
                <label class="info-label">Email</label>
                <input type="email" class="info-value" value="{{ Auth::user()->email }}" disabled style="background: #eee;">
            </div>

            <div class="info-row">
                <label class="info-label">Mật khẩu</label>
                <div style="flex: 1; display: flex; gap: 10px;">
                    <input type="text" class="info-value" value="********" readonly style="flex: 1;">
                    <button type="button" onclick="showPass()" style="background: var(--color-primary); color: white; border: none; padding: 10px; border-radius: 8px; cursor: pointer; font-weight: bold;">Thay đổi</button>
                </div>
            </div>

            <div id="pass_box" style="display: none; background: #fff5f0; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
                <div class="info-row">
                    <label class="info-label">Mật khẩu mới</label>
                    <input type="password" name="new_password" class="info-value">
                </div>
                <div class="info-row" style="margin-bottom: 0;">
                    <label class="info-label">Nhập lại</label>
                    <input type="password" name="new_password_confirmation" class="info-value">
                </div>
            </div>

            <div class="info-row">
                <label class="info-label">Địa chỉ</label>
                <input type="text" name="address" class="info-value" value="{{ Auth::user()->address }}">
            </div>

            <div class="info-row">
                <label class="info-label">CCCD</label>
                <input type="text" class="info-value" value="{{ Auth::user()->id_card }}" readonly style="background: #eee;">
            </div>

            <button type="submit" class="btn-submit" style="background: var(--color-primary); color: white; width: 100%;">
                Lưu Thay Đổi
            </button>
        </form>
    </div>

    <script>
        function showPass() {
            var x = document.getElementById("pass_box");
            x.style.display = (x.style.display === "none") ? "block" : "none";
        }
    </script>

</body>
</html>

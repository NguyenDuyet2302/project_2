<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng ký khách thuê - Hệ thống 7 trọ</title>

    <style>
        :root {
            --color-main: #ffffff;
            --bg-main: #F4EFEA;
            --color-primary: #9C7A63;
            --text-dark: #2D231E;
            --text-light: #F9F6F0;
            --danger-color: #B85C47;
            --success-hover: #7A5C4A;
        }

        body.register-page {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: var(--bg-main);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px 0;
        }

        .register-form {
            display: flex;
            flex-direction: column;
            gap: 12px;
            width: 380px;
        }

        .login-input {
            padding: 12px;
            border: none;
            background-color: var(--color-main);
            font-size: 15px;
            outline: none;
            color: var(--text-dark);
        }

        .login-btn {
            padding: 15px;
            border: none;
            background-color: var(--color-primary);
            font-size: 18px;
            font-weight: bold;
            color: var(--text-light);
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }

        .login-btn:hover { background-color: var(--success-hover); }
        .login-error { color: var(--danger-color); text-align: center; font-weight: bold; margin-top: 10px; }
        .title { text-align: center; color: var(--color-primary); margin-bottom: 10px; font-weight: bold; }
    </style>
</head>
<body class="register-page">

<form class="register-form" method="POST" action="{{ route('register.post') }}">
    @csrf
    <h2 class="title">ĐĂNG KÝ KHÁCH THUÊ</h2>

    <input class="login-input" type="text" name="fullname" placeholder="họ và tên" required>
    <input class="login-input" type="email" name="email" placeholder="email đăng nhập" required>
    <input class="login-input" type="text" name="phone" placeholder="số điện thoại">
    <input class="login-input" type="text" name="id_card" placeholder="số căn cước công dân">
    <input class="login-input" type="text" name="address" placeholder="địa chỉ thường trú">
    <input class="login-input" type="password" name="password" placeholder="mật khẩu" required>

    <button class="login-btn" type="submit">XÁC NHẬN ĐĂNG KÝ</button>

    <div style="text-align: center; margin-top: 10px;">
        <a href="{{ route('login') }}" style="color: var(--text-dark); font-size: 14px; text-decoration: none;">
            Quay lại Đăng nhập
        </a>
    </div>

    @if ($errors->any())
        <div class="login-error">{{ $errors->first() }}</div>
    @endif
</form>

</body>
</html>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hệ thống 7 trọ - Đăng nhập</title>

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

        * { box-sizing: border-box; }

        body.login-page {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: var(--bg-main);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            width: 340px;
        }

        .login-input {
            padding: 15px;
            border: none;
            background-color: var(--color-main);
            font-size: 16px;
            outline: none;
            color: var(--text-dark);
        }

        .login-input::placeholder { color: #8C7D73; }

        .login-btn {
            padding: 15px;
            border: none;
            background-color: var(--color-primary);
            font-size: 20px;
            font-weight: bold;
            color: var(--text-light);
            cursor: pointer;
            transition: 0.3s;
        }

        .login-btn:hover { background-color: var(--success-hover); }

        .login-error {
            color: var(--danger-color);
            text-align: center;
            font-weight: bold;
            margin-top: 10px;
        }

        .register-link {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
            color: var(--text-dark);
        }

        .register-link a {
            color: var(--color-primary);
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body class="login-page">

<form class="login-form" method="POST" action="{{ route('admin.login.post') }}">
    @csrf

    <h2 style="text-align: center; color: var(--color-primary); margin-bottom: 10px;">ĐĂNG NHẬP</h2>

    <input class="login-input" type="email" name="email" placeholder="Email đăng nhập" required>

    <input class="login-input" type="password" name="password" placeholder="Mật khẩu" required>

    <button class="login-btn" type="submit">LOGIN</button>
    @if ($errors->any())
        <div class="login-error">{{ $errors->first() }}</div>
    @endif

    @if(session('success'))
        <div style="color: #28a745; text-align: center; font-weight: bold; margin-top: 10px;">
            {{ session('success') }}
        </div>
    @endif
</form>

</body>
</html>

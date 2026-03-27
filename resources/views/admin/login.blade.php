<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hệ thống 7 trọ</title>

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
        .login-box { display: flex; align-items: center; gap: 30px; }
        .logo-svg { width: 140px; height: 140px; }
        .login-form { display: flex; flex-direction: column; gap: 15px; width: 340px; }
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
        .login-error { color: var(--danger-color); text-align: center; font-weight: bold; }
    </style>
</head>
<body class="login-page">

    <form class="login-form" method="POST" action="{{ route('admin.login.post') }}">
        @csrf
        <input class="login-input" type="email" name="email" placeholder="email" required>
        <input class="login-input" type="password" name="password" placeholder="mật khẩu" required>
        <button class="login-btn" type="submit">LOGIN</button>

        @if ($errors->any())
            <div class="login-error">{{ $errors->first() }}</div>
        @endif
    </form>
</div>

</body>
</html>

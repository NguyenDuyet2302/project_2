<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login - Hệ thống trọ</title>
    <style>
        :root {
            --color-main: #95FF80;
            --color-sub: #FFE980;
            --bg-web: #c9ffce;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: var(--bg-web);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-box {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .logo-svg {
            width: 140px;
            height: 140px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            width: 340px;
        }

        input {
            padding: 15px;
            border: none;
            border-radius: 8px;
            background-color: var(--color-main);
            font-size: 16px;
            outline: none;
            color: #000;
        }

        input::placeholder {
            color: #555;
        }

        button {
            padding: 15px;
            border: none;
            border-radius: 8px;
            background-color: var(--color-sub);
            font-size: 20px;
            font-weight: bold;
            color: #000;
            cursor: pointer;
        }

        button:hover {
            background-color: var(--color-main);
        }

        .error {
            color: red;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="login-box">
    <svg class="logo-svg" viewBox="0 0 100 100">
        <polygon points="10,50 50,15 90,50" fill="#ff0000" />
        <path d="M 10 50 L 50 15 L 90 50" stroke="#ff0000" stroke-width="4" stroke-linejoin="round"/>
        <rect x="18" y="50" width="64" height="38" fill="#b3e5fc" stroke="#81d4fa" stroke-width="1"/>
        <circle cx="50" cy="60" r="7" fill="#0000ff" />
        <path d="M 40 88 L 40 76 A 10 10 0 0 1 60 76 L 60 88 Z" fill="#ff0000" />
        <circle cx="56" cy="80" r="1.5" fill="#800000" />
    </svg>

    <form method="POST" action="{{ route('admin.login.post') }}">
        @csrf

        <input type="email" name="email" placeholder="Tên tài khoản" required>
        <input type="password" name="password" placeholder="mật khẩu" required>
        <button type="submit">LOGIN</button>

        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif
    </form>
</div>

</body>
</html>

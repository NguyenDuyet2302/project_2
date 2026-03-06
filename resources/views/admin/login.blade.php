<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login - Hệ thống trọ</title>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #a7ffd3; /* Màu nền xanh mint nhạt chuẩn Figma */
            display: flex;
            justify-content: center; /* Căn giữa ngang cho body */
            align-items: center; /* Căn giữa dọc cho body */
            min-height: 100vh;
        }

        /* Container chính chứa Logo và Form */
        .login-container {
            display: flex;
            gap: 20px; /* Khoảng cách ngang giữa Logo và Khối Form */
            align-items: center; /* Căn giữa dọc cho 2 khối Logo và Form */
        }

        /* Khối chứa Logo SVG */
        .logo-section {
            flex: 0 0 auto; /* Giữ nguyên kích thước logo */
        }

        .admin-logo {
            width: 140px; /* Kích thước logo chuẩn */
            height: 140px;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));
        }

        /* Khối chứa Form - CỰC KỲ QUAN TRỌNG ĐỂ SỬA LỖI */
        .form-section-wrapper {
            flex: 1 1 auto; /* Cho phép form co giãn */
        }

        .form-section {
            display: flex;
            flex-direction: column; /* Xếp các phần tử trong form CỐ ĐỊNH theo chiều dọc */
            gap: 8px; /* Khoảng cách dọc rất sát nhau giữa các nút */
            width: 360px; /* Chiều rộng chuẩn của khối form */
        }

        /* Ô nhập liệu */
        .input-field {
            width: 100%; /* Chiếm hết chiều rộng của .form-section */
            padding: 14px 20px;
            border: none;
            border-radius: 8px; /* Bo góc sắc nét hơn */
            background-color: #bbf781; /* Màu xanh lá mạ của ô input */
            font-size: 1.3rem; /* Font size lớn dễ đọc */
            color: #555;
            box-sizing: border-box; /* Cần thiết để padding không làm tăng width */
            outline: none;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .input-field::placeholder {
            color: #7a9c59; /* Placeholder màu xanh đậm, viết thường */
        }

        /* Nút LOGIN */
        .login-button {
            width: 100%; /* Chiếm hết chiều rộng của .form-section */
            padding: 14px;
            border: none;
            border-radius: 8px; /* Bo góc sắc nét hơn */
            background-color: #bbf781;
            font-size: 1.5rem;
            font-weight: bold;
            color: #000;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            transition: 0.2s;
            text-align: center; /* Đảm bảo chữ LOGIN ở giữa nút */
        }

        .login-button:hover {
            background-color: #a8e66f;
        }

        .error-msg {
            color: red;
            text-align: center;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="login-container">

    <div class="logo-section">
        <svg class="admin-logo" viewBox="0 0 100 100">
            <polygon points="10,50 50,15 90,50" fill="#ff0000" />
            <path d="M 10 50 L 50 15 L 90 50" stroke="#ff0000" stroke-width="4" stroke-linejoin="round"/>
            <rect x="18" y="50" width="64" height="38" fill="#b3e5fc" stroke="#81d4fa" stroke-width="1"/>
            <circle cx="50" cy="60" r="7" fill="#0000ff" />
            <path d="M 40 88 L 40 76 A 10 10 0 0 1 60 76 L 60 88 Z" fill="#ff0000" />
            <circle cx="56" cy="80" r="1.5" fill="#800000" />
        </svg>
    </div>

    <div class="form-section-wrapper">
        <form method="POST" action="{{ route('admin.login.post') }}" class="form-section">
            @csrf

            <input type="email" name="email" class="input-field" placeholder="Tên tài khoản" required>
            <input type="password" name="password" class="input-field" placeholder="mật khẩu" required>
            <button type="submit" class="login-button">LOGIN</button>

            @if ($errors->any())
                <div class="error-msg">{{ $errors->first() }}</div>
            @endif
        </form>
    </div>

</div>

</body>
</html>

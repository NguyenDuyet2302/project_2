<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hệ thống trọ')</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<div class="master-container">
    @include('layouts.sidebar')

    <div class="main-wrapper">
        @include('layouts.header')

        <main class="content-area">
            @yield('content')
        </main>
    </div>
</div>

</body>
</html>

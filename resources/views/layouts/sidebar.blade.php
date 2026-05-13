<aside class="sidebar">
    <div class="logo">
        <span style="font-size: 1.5rem;"></span>
        <h2>Hệ thống trọ</h2>
    </div>
    <nav class="menu">
        <ul>
            <li><a href="{{ url('/dashboard') }}">Tổng quan</a></li>
            <li><a href="{{ url('/rooms') }}">Quản lý phòng</a></li>
            <li><a href="{{ url('/users') }}">Quản lý khách</a></li>
            <li><a href="{{ url('/contracts') }}">Quản lý hợp đồng</a></li>
            <li><a href="{{ url('/invoices') }}">Quản lý hóa đơn</a></li>
            <li><a href="{{ url('/services') }}">Quản lý dịch vụ</a></li>
            <li><a href="{{ url('/serviceDetails') }}">Chi tiết dịch vụ</a></li>
        </ul>
    </nav>
    <div class="logout">
        <a href="{{ route('admin.login') }}">
        <button>Đăng xuất</button>
        </a>
    </div>
</aside>

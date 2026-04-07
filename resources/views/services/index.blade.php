@extends('layouts.master')
@section('title', 'Danh mục dịch vụ gốc')

@section('content')
    <div class="page-header">
        <h2 class="page-title" style="margin-bottom: 0;">Danh Mục Dịch Vụ (Gốc)</h2>
        <a href="{{ route('services.create') }}" class="btn-add">+ Thêm dịch vụ mới</a>
    </div>

    <div class="card-box">
        <table class="table-custom">
            <thead>
            <tr>
                <th>ID</th>
                <th>Tên dịch vụ</th>
                <th>Giá đơn vị</th>
                <th>Tên đơn vị</th>
                <th>Thao tác</th>
            </tr>
            </thead>
            <tbody>
            @foreach($services as $service)
                <tr>
                    <td>{{ $service->id }}</td>
                    <td><strong>{{ $service->name }}</strong></td>
                    <td><span style="background: #e8f5e9; color: #2e7d32; padding: 5px 10px; border-radius: 4px; font-weight: bold;">{{ number_format($service->unit_price, 0, ',', '.') }}đ</span></td>
                    <td>{{ $service->unit_name }}</td>
                    <td class="action-links">
                        <a href="{{ route('services.edit', $service->id) }}" class="edit">Sửa</a> |
                        <form method="post" action="{{ route('services.destroy', $service->id) }}" style="display:inline;" onsubmit="return confirm('Bạn có chắc muốn xóa dịch vụ này?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

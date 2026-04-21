@extends('layouts.master')
@section('title', 'Quản lý dịch vụ')

@section('content')
    <div class="page-header">
        <h2 class="page-title" style="margin-bottom: 0;">Quản lý dịch vụ</h2>
        <a href="{{ route('serviceDetails.create') }}" class="btn-add">+ Thêm dịch vụ</a>
    </div>

    <div class="card-box">
        <table class="table-custom">
            <thead>
            <tr>
                <th>Service</th>
                <th>Room</th>
                <th>Old index</th>
                <th>New index</th>
                <th>Thao tác</th>
            </tr>
            </thead>
            <tbody>
            @foreach($serviceDetails as $serviceDetail)
                <tr>
                    <td>{{ $serviceDetail->service->name }}</td>
                    <td>{{ $serviceDetail->room->number }}</td>
                    <td>{{ $serviceDetail->old_index }}</td>
                    <td>{{ $serviceDetail->new_index }}</td>
                    <td class="action-links">
                        <a href="{{ route('serviceDetails.edit', ['service_id' => $serviceDetail->service_id, 'room_id' => $serviceDetail->room_id]) }}" class="edit">Sửa</a> |
                        <form method="post" action="{{ route('serviceDetails.destroy', ['service_id' => $serviceDetail->service_id, 'room_id' => $serviceDetail->room_id]) }}" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
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

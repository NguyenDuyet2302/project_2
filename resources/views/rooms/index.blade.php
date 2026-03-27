@extends('layouts.master')
@section('title', 'Quản lý phòng')
@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h2 style="margin: 0;">Hệ Thống Quản Lý Phòng</h2>
        <a href="{{ route('rooms.create') }}" style="background: var(--btn-save-bg, #70794C); color: white; padding: 10px 20px; text-decoration: none; font-weight: bold; transition: 0.3s;">+ Thêm Phòng Mới</a>
    </div>

    <div style="background: white; border: 1px solid #E0D7CD; box-shadow: 0 4px 15px rgba(0,0,0,0.02); overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: var(--bg-main, #F4EFEA); border-bottom: 2px solid #C4B7AB;">
            <tr>
                <th style="padding: 15px; text-align: center;">ID</th>
                <th style="text-align: center;">Hình ảnh</th>
                <th style="text-align: center;">Tên Phòng</th>
                <th style="text-align: center;">Giá thuê</th>
                <th style="text-align: center;">Trạng thái</th>
                <th style="text-align: center;">Thao tác</th>
            </tr>
            </thead>
            <tbody style="text-align: center;">
            @forelse($rooms as $room)
                <tr style="border-bottom: 1px solid #EBE4DD;">
                    <td style="padding: 15px;">{{ $room->id }}</td>
                    <td>
                        <img src="{{ $room->image ?: 'https://via.placeholder.com/80' }}" width="80" height="60" style="object-fit: cover; border: 1px solid #C4B7AB;">
                    </td>
                    <td><strong>{{ $room->number }}</strong></td>
                    <td>{{ number_format($room->price) }}đ</td>
                    <td>
                        <span style="background: {{ $room->status == 1 ? '#70794C' : '#A04A41' }}; color: white; padding: 5px 10px; font-size: 0.8rem; font-weight: bold;">
                            {{ $room->status == 1 ? 'Còn trống' : 'Hết phòng' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('rooms.edit', $room->id) }}" style="color: #B88645; text-decoration: none; font-weight: bold; margin-right: 10px;">Sửa</a>

                        <form action="/rooms/{{ $room->id }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa phòng {{ $room->number }} này?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; border: none; padding: 0; color: #A04A41; font-weight: bold; cursor: pointer; font-family: inherit; font-size: inherit;">Xóa</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="padding: 50px; color: #8C7D73; font-weight: bold;">Chưa có dữ liệu phòng.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 30px; display: flex; justify-content: center; gap: 15px; align-items: center;">
        @if ($rooms->onFirstPage())
            <span style="padding: 10px 25px; background: #EBE4DD; color: #8C7D73; font-weight: bold; cursor: not-allowed;">Trước</span>
        @else
            <a href="{{ $rooms->previousPageUrl() }}" style="padding: 10px 25px; background: var(--color-primary, #9C7A63); color: white; text-decoration: none; font-weight: bold;">Trước</a>
        @endif

        @if ($rooms->hasMorePages())
            <a href="{{ $rooms->nextPageUrl() }}" style="padding: 10px 25px; background: var(--color-primary, #9C7A63); color: white; text-decoration: none; font-weight: bold;">Sau</a>
        @else
            <span style="padding: 10px 25px; background: #EBE4DD; color: #8C7D73; font-weight: bold; cursor: not-allowed;">Sau</span>
        @endif
    </div>
@endsection

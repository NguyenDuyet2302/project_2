@extends('layouts.master')

@section('title', 'Quản lý phòng')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h2 style="margin: 0;">Hệ Thống Quản Lý Phòng</h2>
        <a href="{{ route('rooms.create') }}" style="background: #00ff9d; color: black; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: bold;">+ Thêm Phòng Mới</a>
    </div>

    <div style="background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: #f8f9fa; border-bottom: 2px solid #eee;">
            <tr>
                <th style="padding: 15px;">ID</th>
                <th>Hình ảnh</th>
                <th>Tên Phòng</th>
                <th>Giá thuê</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
            </thead>
            <tbody style="text-align: center;">
            @forelse($rooms as $room)
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 15px;">{{ $room->id }}</td>
                    <td><img src="{{ asset('storage/'.$room->image) }}" width="80" style="border-radius: 5px;"></td>
                    <td><strong>{{ $room->number }}</strong></td>
                    <td>{{ number_format($room->price) }}đ</td>
                    <td>
                        <span style="background: {{ $room->status == 1 ? '#00ff9d' : '#ffcc00' }}; padding: 5px 10px; border-radius: 5px; font-size: 0.8rem;">
                            {{ $room->status == 1 ? 'Còn trống' : 'Hết phòng' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('rooms.edit', $room->id) }}" style="color: blue; text-decoration: none;">Sửa</a> |
                        <a href="javascript:void(0)" onclick="showModal('{{ $room->id }}', '{{ $room->number }}')" style="color: red; text-decoration: none;">Xóa</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="padding: 50px; color: #888;">Chưa có dữ liệu phòng.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px; display: flex; justify-content: center; gap: 10px; align-items: center;">
        @if ($rooms->onFirstPage())
            <span style="padding: 8px 15px; background: #eee; color: #aaa; border-radius: 5px; cursor: not-allowed;">&laquo; Trang trước</span>
        @else
            <a href="{{ $rooms->previousPageUrl() }}" style="padding: 8px 15px; background: #00ff9d; color: black; border-radius: 5px; text-decoration: none; font-weight: bold;">&laquo; Trang trước</a>
        @endif

        <span style="font-weight: bold;">Trang {{ $rooms->currentPage() }} / {{ $rooms->lastPage() }}</span>

        @if ($rooms->hasMorePages())
            <a href="{{ $rooms->nextPageUrl() }}" style="padding: 8px 15px; background: #00ff9d; color: black; border-radius: 5px; text-decoration: none; font-weight: bold;">Trang sau &raquo;</a>
        @else
            <span style="padding: 8px 15px; background: #eee; color: #aaa; border-radius: 5px; cursor: not-allowed;">Trang sau &raquo;</span>
        @endif
    </div>
@endsection

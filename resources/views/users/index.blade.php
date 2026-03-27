@extends('layouts.master')
@section('title', 'Quản lý khách thuê')
@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h2 style="margin: 0;">Hệ Thống Quản Lý Khách Thuê</h2>
        <a href="{{ route('users.create') }}" style="background: #00ff9d; color: black; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: bold; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">+ Thêm Khách Thuê</a>
    </div>
    <div style="background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: #f8f9fa; border-bottom: 2px solid #eee;">
            <tr>
                <th style="padding: 15px; width: 50px;">STT</th>
                <th>Họ tên</th>
                <th>Số điện thoại</th>
                <th>CMND/CCCD</th>
                <th>Địa chỉ</th>
                <th>Vai trò</th>
                <th style="width: 150px;">Thao tác</th>
            </tr>
            </thead>
            <tbody style="text-align: center;">
            @forelse($users as $user)
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 15px;"><strong>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</strong></td>
                    <td style="text-align: left; padding-left: 20px;">{{ $user->fullname }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->id_card }}</td>
                    <td>{{ $user->address }}</td>
                    <td>
                        <span style="background: {{ $user->role == 0 ? '#eee' : '#00ff9d' }}; padding: 4px 10px; border-radius: 5px; font-size: 0.8rem;">
                            {{ $user->role == 0 ? 'Khách thuê' : 'Admin' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('users.edit', $user->id) }}" style="color: blue; text-decoration: none;">Sửa</a>
                        <span style="color: #ccc;"> | </span>

                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa hồ sơ khách này?')"
                                    style="background: none; border: none; color: red; cursor: pointer; padding: 0; font-family: inherit; font-size: inherit;">
                                Xóa
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="padding: 50px; color: #888;">Chưa có dữ liệu khách thuê.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top: 25px; display: flex; justify-content: center; gap: 15px; align-items: center;">
        @if (!$users->onFirstPage())
            <a href="{{ $users->previousPageUrl() }}"
               style="padding: 8px 18px; background: #00ff9d; color: black; border-radius: 5px; text-decoration: none; font-weight: bold; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                &laquo; Trang trước
            </a>
        @endif
        @if($users->total() > 0)
            <span style="font-weight: bold; background: white; padding: 8px 20px; border-radius: 5px; border: 1px solid #eee;">
                Trang {{ $users->currentPage() }} / {{ $users->lastPage() }}
            </span>
        @endif
        @if ($users->hasMorePages())
            <a href="{{ $users->nextPageUrl() }}"
               style="padding: 8px 18px; background: #00ff9d; color: black; border-radius: 5px; text-decoration: none; font-weight: bold; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                Trang sau &raquo;
            </a>
        @endif

    </div>
@endsection

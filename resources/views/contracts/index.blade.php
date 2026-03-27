@extends('layouts.master')
@section('title', 'Danh sách hợp đồng')
@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h2 style="margin: 0;">Quản Lý Hợp Đồng Thuê Phòng</h2>
        <a href="{{ route('contracts.create') }}" style="background: #00ff9d; color: black; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: bold; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">+ Thêm Hợp Đồng</a>
    </div>

    <div style="background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: #f8f9fa; border-bottom: 2px solid #eee;">
            <tr>
                <th style="padding: 15px; width: 50px;">STT</th>
                <th>Khách thuê</th>
                <th>Phòng</th>
                <th>Ngày bắt đầu</th>
                <th>Ngày kết thúc</th>
                <th>Tiền cọc</th>
                <th>Trạng thái</th>
                <th style="width: 150px;">Thao tác</th>
            </tr>
            </thead>
            <tbody style="text-align: center;">
            @forelse($contracts as $contract)
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 15px;"><strong>{{ ($contracts->currentPage() - 1) * $contracts->perPage() + $loop->iteration }}</strong></td>

                    <td style="text-align: left; padding-left: 20px;">{{ $contract->user->fullname ?? 'N/A' }}</td>

                    <td><strong>{{ $contract->room->number ?? 'N/A' }}</strong></td>

                    <td>{{ \Carbon\Carbon::parse($contract->start_date)->format('d/m/Y') }}</td>
                    <td>{{ $contract->end_date ? \Carbon\Carbon::parse($contract->end_date)->format('d/m/Y') : 'Không thời hạn' }}</td>

                    <td><span style="color: #28a745; font-weight: bold;">{{ number_format($contract->deposit) }}đ</span></td>

                    <td>
                        <span style="background: {{ $contract->status == 1 ? '#00ff9d' : '#eee' }}; color: black; padding: 5px 12px; border-radius: 5px; font-size: 0.8rem; font-weight: bold;">
                            {{ $contract->status == 1 ? 'Đang hiệu lực' : 'Đã thanh lý' }}
                        </span>
                    </td>

                    <td>
                        <a href="{{ route('contracts.edit', $contract->id) }}" style="color: blue; text-decoration: none;">Sửa</a>
                        <span style="color: #ccc;"> | </span>

                        <form action="{{ route('contracts.destroy', $contract->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Xóa hợp đồng này chứ?')"
                                    style="background: none; border: none; color: red; cursor: pointer; padding: 0; font-family: inherit; font-size: inherit;">
                                Xóa
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="padding: 50px; color: #888;">Chưa có dữ liệu hợp đồng.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 25px; display: flex; justify-content: center; gap: 15px; align-items: center;">
        @if (!$contracts->onFirstPage())
            <a href="{{ $contracts->previousPageUrl() }}"
               style="padding: 8px 18px; background: #00ff9d; color: black; border-radius: 5px; text-decoration: none; font-weight: bold; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                &laquo; Trang trước
            </a>
        @endif

        @if($contracts->total() > 0)
            <span style="font-weight: bold; background: white; padding: 8px 20px; border-radius: 5px; border: 1px solid #eee;">
                Trang {{ $contracts->currentPage() }} / {{ $contracts->lastPage() }}
            </span>
        @endif

        @if ($contracts->hasMorePages())
            <a href="{{ $contracts->nextPageUrl() }}"
               style="padding: 8px 18px; background: #00ff9d; color: black; border-radius: 5px; text-decoration: none; font-weight: bold; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                Trang sau &raquo;
            </a>
        @endif
    </div>
@endsection

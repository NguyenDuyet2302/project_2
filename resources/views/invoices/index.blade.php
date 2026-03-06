@extends('layouts.master')

@section('title', 'Quản lý hóa đơn')

@section('content')
    {{-- Header đồng bộ hệ thống --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h2 style="margin: 0;">Hệ Thống Quản Lý Hóa Đơn</h2>
        <a href="{{ route('invoices.create') }}" style="background: #00ff9d; color: black; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: bold; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">+ Thêm Hóa Đơn</a>
    </div>

    {{-- Bảng dữ liệu - Phong cách hiện đại giống Room/User --}}
    <div style="background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: #f8f9fa; border-bottom: 2px solid #eee;">
            <tr>
                <th style="padding: 15px; width: 50px;">STT</th>
                <th>Tháng</th>
                <th>Phòng</th>
                <th>Khách thuê</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th style="width: 150px;">Thao tác</th>
            </tr>
            </thead>
            <tbody style="text-align: center;">
            @forelse($invoices as $invoice)
                <tr style="border-bottom: 1px solid #eee;">
                    {{-- STT tự nhảy theo trang --}}
                    <td style="padding: 15px;"><strong>{{ ($invoices->currentPage() - 1) * $invoices->perPage() + $loop->iteration }}</strong></td>

                    <td>{{ $invoice->month }}</td>

                    <td><strong>{{ $invoice->contract->room->number ?? 'N/A' }}</strong></td>

                    <td style="text-align: left; padding-left: 20px;">{{ $invoice->contract->user->fullname ?? 'N/A' }}</td>

                    <td><span style="color: #28a745; font-weight: bold;">{{ number_format($invoice->total_amount) }}đ</span></td>

                    <td>
                        <span style="background: {{ $invoice->status == 1 ? '#00ff9d' : '#ffcc00' }}; color: black; padding: 5px 12px; border-radius: 5px; font-size: 0.8rem; font-weight: bold;">
                            {{ $invoice->status == 1 ? 'Đã thanh toán' : 'Chưa thanh toán' }}
                        </span>
                    </td>

                    <td>
                        <a href="{{ route('invoices.edit', $invoice->id) }}" style="color: blue; text-decoration: none;">Sửa</a>
                        <span style="color: #ccc;"> | </span>

                        <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Xóa hóa đơn này chứ?')"
                                    style="background: none; border: none; color: red; cursor: pointer; padding: 0; font-family: inherit; font-size: inherit;">
                                Xóa
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="padding: 50px; color: #888;">Chưa có dữ liệu hóa đơn.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{-- PHẦN PHÂN TRANG (PAGINATION) - Đã xử lý ẩn nút thông minh --}}
    <div style="margin-top: 25px; display: flex; justify-content: center; gap: 15px; align-items: center;">

        {{-- Nút Trang trước --}}
        @if (!$invoices->onFirstPage())
            <a href="{{ $invoices->previousPageUrl() }}"
               style="padding: 8px 18px; background: #00ff9d; color: black; border-radius: 5px; text-decoration: none; font-weight: bold; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                &laquo; Trang trước
            </a>
        @endif

        {{-- Số trang hiện tại --}}
        @if($invoices->total() > 0)
            <span style="font-weight: bold; background: white; padding: 8px 20px; border-radius: 5px; border: 1px solid #eee;">
                Trang {{ $invoices->currentPage() }} / {{ $invoices->lastPage() }}
            </span>
        @endif

        {{-- Nút Trang sau --}}
        @if ($invoices->hasMorePages())
            <a href="{{ $invoices->nextPageUrl() }}"
               style="padding: 8px 18px; background: #00ff9d; color: black; border-radius: 5px; text-decoration: none; font-weight: bold; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                Trang sau &raquo;
            </a>
        @endif

    </div>
@endsection

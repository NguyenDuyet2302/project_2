@extends('layouts.master')
@section('title', 'Quản lý chi tiết dịch vụ')
@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h2 style="margin: 0; color: #2D231E;">Quản lý chi tiết dịch vụ</h2>
        <a href="{{ route('serviceDetails.create') }}" style="background: #00ff9d; color: black; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: bold; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">+ Thêm dịch vụ</a>
    </div>

    @forelse($groupedServiceDetails as $roomNumber => $details)
        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 25px; border: 1px solid #E8D8C4; overflow: hidden;">

            <div style="background: #9C7A63; color: white; padding: 12px 20px; font-weight: bold; font-size: 1.05rem; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-door-open"></i> PHÒNG SỐ: {{ $roomNumber }}
            </div>

            <div style="padding: 10px 20px;">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.95rem;">
                    <thead>
                    <tr style="border-bottom: 2px solid #E8D8C4; color: #7C6F66; font-weight: bold;">
                        <th style="padding: 12px; width: 30%;">Service (Dịch vụ)</th>
                        <th style="padding: 12px; width: 25%;">Old index (Số cũ)</th>
                        <th style="padding: 12px; width: 25%;">New index (Số mới)</th>
                        <th style="padding: 12px; text-align: center; width: 20%;">Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($details as $detail)
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 12px;">
                                <span style="color: #2563eb; font-weight: 500;">{{ $detail->service->name ?? 'N/A' }}</span>
                                @if($detail->service->unit_name)
                                    <small style="color: #888;">({{ $detail->service->unit_name }})</small>
                                @endif
                            </td>
                            <td style="padding: 12px; color: #555;">{{ number_format($detail->old_index, 2) }}</td>
                            <td style="padding: 12px; color: #2D231E; font-weight: bold;">{{ number_format($detail->new_index, 2) }}</td>
                            <td style="padding: 12px; text-align: center;">
                                <a href="{{ route('serviceDetails.edit', [$detail->room_id, $detail->service_id]) }}" style="color: #2563eb; text-decoration: none; font-weight: 500; margin-right: 10px;">Sửa</a>
                                <span style="color: #ccc;">|</span>
                                <form action="{{ route('serviceDetails.destroy', [$detail->room_id, $detail->service_id]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Xóa dịch vụ này khỏi phòng?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: none; border: none; color: #dc3545; cursor: pointer; padding: 0; font-family: inherit; font-size: inherit; font-weight: 500;">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div style="background: white; border-radius: 8px; padding: 40px; text-align: center; color: #888; border: 1px solid #E8D8C4;">
            Chưa có cấu hình chi tiết dịch vụ nào cho các phòng.
        </div>
    @endforelse
@endsection

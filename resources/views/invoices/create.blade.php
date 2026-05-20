@extends('layouts.master')
@section('title', 'Bước 1: Chọn phòng tính tiền')
@section('content')
    <div style="max-width: 550px; margin: 40px auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <h3 style="border-left: 4px solid #9C7A63; padding-left: 10px; color: #2D231E;">BƯỚC 1: CHỌN PHÒNG & THÁNG TÍNH TIỀN</h3>

        @if ($errors->any())
            <div style="background: #fff5f5; color: #dc3545; padding: 10px; border-radius: 4px; margin-bottom: 15px;">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('invoices.createStep2') }}" method="POST">
            @csrf
            <div style="margin-bottom: 18px;">
                <label><b>Chọn Phòng thuê:</b></label>
                <select name="contract_id" class="form-control" required style="width: 100%; padding: 10px; margin-top: 5px;">
                    @foreach($contracts as $contract)
                        <option value="{{ $contract->id }}">Phòng {{ $contract->room->number }} - Khách: {{ $contract->user->fullname }}</option>
                    @endforeach
                </select>
            </div>
            <div style="margin-bottom: 18px;">
                <label><b>Hóa đơn cho tháng (Cố định tháng hiện tại):</b></label>
                <input type="month" name="month" value="{{ date('Y-m') }}" class="form-control" readonly style="width: 100%; padding: 10px; margin-top: 5px; background: #e9ecef; cursor: not-allowed;">
            </div>
            <div style="margin-bottom: 25px;">
                <label><b>Trạng thái thu tiền:</b></label>
                <select name="status" class="form-control" style="width: 100%; padding: 10px; margin-top: 5px;">
                    <option value="0">Chưa thanh toán</option>
                    <option value="1">Đã thanh toán</option>
                </select>
            </div>
            <button type="submit" style="background: #9C7A63; color: white; padding: 12px 20px; border: none; font-weight: bold; border-radius: 4px; cursor: pointer; width: 100%;">
                Kế tiếp: Nhập số điện nước <i class="fa-solid fa-arrow-right"></i>
            </button>
        </form>
    </div>
@endsection

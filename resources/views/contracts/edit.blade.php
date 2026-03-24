@extends('layouts.master')

@section('title', 'Cập nhật hợp đồng')

@section('content')
    <style>
        .page-title { font-size: 1.8rem; font-weight: normal; margin-bottom: 20px; color: #333; }
        .form-container {
            background: #fff;
            padding: 40px;
            border-radius: 15px;
            border: 1px solid #ddd;
            max-width: 900px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }
        .form-subtitle {
            font-size: 1.1rem; color: #666; margin-bottom: 30px; border-bottom: 2px solid #00ff9d; padding-bottom: 10px; display: inline-block;
        }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 25px; }
        .form-group { display: flex; flex-direction: column; }
        .form-group.full-width { grid-column: span 2; }
        .form-group label { font-weight: bold; margin-bottom: 10px; color: #000; }
        .form-control { padding: 15px; border-radius: 10px; border: 1px solid #ccc; font-size: 1rem; outline: none; transition: 0.2s; }
        .form-control:focus { border-color: #00ff9d; box-shadow: 0 0 0 3px rgba(0, 255, 157, 0.1); }

        .form-actions { display: flex; gap: 20px; margin-top: 40px; justify-content: flex-end; }
        .btn-update { background-color: #00ff9d; color: #000; border: 1px solid #555; padding: 12px 50px; border-radius: 25px; font-weight: bold; font-size: 1.1rem; cursor: pointer; transition: 0.3s; }
        .btn-update:hover { background-color: #00e68e; transform: translateY(-2px); }
        .btn-cancel { background-color: #ff4444; color: #fff; border: 1px solid #555; padding: 12px 50px; border-radius: 25px; font-weight: bold; font-size: 1.1rem; text-decoration: none; text-align: center; transition: 0.3s; }
        .btn-cancel:hover { background-color: #cc0000; transform: translateY(-2px); }
    </style>

    <div class="page-title">
        Quản Lý Hợp Đồng / <strong>Cập nhật hợp đồng #{{ $contract->id }}</strong>
    </div>

    <div class="form-container">
        <div class="form-subtitle">CHỈNH SỬA CHI TIẾT THỎA THUẬN</div>

        <form method="post" action="{{ route('contracts.update', $contract->id) }}">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="form-group">
                    <label>Khách thuê phòng:</label>
                    <select name="user_id" class="form-control" required>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $contract->user_id == $user->id ? 'selected' : '' }}>
                                {{ $user->fullname }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Phòng thuê:</label>
                    <select name="room_id" class="form-control" required>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}" {{ $contract->room_id == $room->id ? 'selected' : '' }}>
                                Phòng: {{ $room->number }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Ngày bắt đầu:</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $contract->start_date }}" required>
                </div>

                <div class="form-group">
                    <label>Ngày kết thúc (Dự kiến):</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $contract->end_date }}">
                </div>

                <div class="form-group">
                    <label>Tiền đặt cọc (VNĐ):</label>
                    <input type="number" name="deposit" class="form-control" value="{{ $contract->deposit }}" required>
                </div>

                <div class="form-group">
                    <label>Trạng thái hợp đồng:</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ $contract->status == 1 ? 'selected' : '' }}>Đang hiệu lực</option>
                        <option value="0" {{ $contract->status == 0 ? 'selected' : '' }}>Đã kết thúc</option>
                    </select>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('contracts.index') }}" class="btn-cancel">Hủy bỏ</a>
                <button type="submit" class="btn-update">Cập nhật hợp đồng</button>
            </div>
        </form>
    </div>
@endsection

@extends('layouts.master')
@section('title', 'Cập nhật hợp đồng')
@section('content')
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
                    <input type="date" id="start_date" name="start_date" class="form-control" value="{{ $contract->start_date }}" required>
                </div>

                <div class="form-group">
                    <label>Chỉnh thời hạn (Số tháng):</label>
                    <input type="number" id="duration_months" class="form-control" placeholder="Nhập để tự đổi ngày kết thúc" min="1">
                </div>

                <div class="form-group">
                    <label>Ngày kết thúc (Dự kiến):</label>
                    <input type="date" id="end_date" name="end_date" class="form-control" value="{{ $contract->end_date }}" readonly style="background-color: #e9ecef;">
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

    <script>
        document.getElementById('duration_months').addEventListener('input', calculateEndDate);
        document.getElementById('start_date').addEventListener('change', calculateEndDate);

        // Lưu lại ngày kết thúc ban đầu để phục hồi nếu người dùng xóa ô Số tháng
        const originalEndDate = "{{ $contract->end_date }}";

        function calculateEndDate() {
            let startDateVal = document.getElementById('start_date').value;
            let durationMonths = parseInt(document.getElementById('duration_months').value);

            if (startDateVal && durationMonths > 0) {
                let date = new Date(startDateVal);

                // Cộng số tháng
                date.setMonth(date.getMonth() + durationMonths);

                // Định dạng xuất ra form
                let year = date.getFullYear();
                let month = String(date.getMonth() + 1).padStart(2, '0');
                let day = String(date.getDate()).padStart(2, '0');

                document.getElementById('end_date').value = `${year}-${month}-${day}`;
            } else {
                // Phục hồi lại ngày cũ nếu không nhập số tháng
                document.getElementById('end_date').value = originalEndDate;
            }
        }
    </script>
@endsection

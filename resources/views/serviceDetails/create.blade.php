@extends('layouts.master')
@section('title', 'Thêm chi tiết dịch vụ')

@section('content')
    <div class="breadcrumb">Quản lý dịch vụ / <b>chi tiết dịch vụ</b></div>

    <div class="card-box" style="max-width: 850px;">
        <div class="form-header-line">Dịch vụ</div>

        <form method="post" action="{{ route('serviceDetails.store') }}">
            @csrf

            <div class="form-grid" style="margin-bottom: 20px;">
                <div class="form-group">
                    <label>Chọn phòng :</label>
                    <select name="room_id" id="room_select" class="form-control" required>
                        <option value="">Chọn Phòng</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}" data-month="{{ $room->current_month ?? date('Y-m') }}">
                                {{ $room->name ?? $room->number }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Tháng :</label>
                    <input type="month" name="month" id="month_input" class="form-control" readonly style="background-color: #e9ecef;">
                </div>
            </div>

            <div id="services-container">
                <div class="service-row" style="display: flex; gap: 15px; align-items: flex-end; margin-bottom: 15px;">
                    <div class="form-group" style="flex: 2;">
                        <label class="service-label">Dịch vụ 1 :</label>
                        <select name="service_id[]" class="form-control" required>
                            <option value="">Chọn dịch vụ</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label>Số :</label>
                        <input type="number" name="new_index[]" class="form-control" placeholder="Nhập số" required>
                    </div>
                    <div class="form-group" style="flex: 1; display: flex; gap: 5px;">
                        <button type="button" class="btn-mini-add btn-duplicate" style="background-color: #a47c64; color: white; border: none; padding: 10px; border-radius: 4px; cursor: pointer; flex: 1;">Thêm</button>
                        <button type="button" class="btn-remove" style="background-color: #A04A41; color: white; border: none; padding: 10px; border-radius: 4px; cursor: pointer; flex: 1;">Xóa</button>
                    </div>
                </div>
            </div>

            <div class="form-actions" style="margin-top: 30px; display: flex; justify-content: flex-end; gap: 10px;">
                <a href="{{ route('serviceDetails.index') }}" class="btn-cancel" style="padding: 12px 30px;">Hủy bỏ</a>
                <button type="submit" class="btn-save" style="padding: 12px 30px;">Thêm</button>
            </div>
        </form>
    </div>

    <script>
        const roomSelect = document.getElementById('room_select');
        const monthInput = document.getElementById('month_input');

        roomSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const month = selectedOption.getAttribute('data-month');
            monthInput.value = month || '';
        });

        const container = document.getElementById('services-container');
        function updateServiceNumbers() {
            const rows = container.querySelectorAll('.service-row');
            rows.forEach(function(row, index) {
                row.querySelector('.service-label').textContent = 'Dịch vụ ' + (index + 1) + ' :';
            });
        }

        container.addEventListener('click', function(e) {
            if (e.target.classList.contains('btn-duplicate')) {
                const rows = container.querySelectorAll('.service-row');
                const firstRow = rows[0];
                const newRow = firstRow.cloneNode(true);

                newRow.querySelector('select').value = '';
                newRow.querySelector('input').value = '';

                container.appendChild(newRow);
                updateServiceNumbers();
            }

            if (e.target.classList.contains('btn-remove')) {
                const rows = container.querySelectorAll('.service-row');
                if (rows.length > 1) {
                    e.target.closest('.service-row').remove();
                    updateServiceNumbers();
                } else {
                    alert('khong the xoa duco cai nay');
                }
            }
        });
    </script>
@endsection

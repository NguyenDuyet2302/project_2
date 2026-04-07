@extends('layouts.master')
@section('title', 'Thêm chi tiết dịch vụ')

@section('content')
    <div class="breadcrumb">Quản lý dịch vụ / <b>chi tiết dịch vụ</b></div>

    <div class="card-box" style="max-width: 800px;">
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
                <div class="service-row">
                    <div class="form-group col-service">
                        <label>Dịch vụ 1 :</label>
                        <select name="service_id[]" class="form-control" required>
                            <option value="">Chọn dịch vụ</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-number">
                        <label>Số :</label>
                        <input type="number" name="new_index[]" class="form-control" placeholder="Nhập số" required>
                    </div>
                    <div class="form-group col-btn">
                        <button type="button" class="btn-mini-add btn-duplicate-row">Thêm</button>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('serviceDetails.index') }}" class="btn-cancel">Hủy bỏ</a>
                <button type="submit" class="btn-save">Thêm</button>
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

        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('btn-duplicate-row')) {
                let container = document.getElementById('services-container');
                let rows = container.getElementsByClassName('service-row');
                let newRowNumber = rows.length + 1;

                let firstRow = rows[0];
                let newRow = firstRow.cloneNode(true);

                newRow.querySelector('.col-service label').textContent = 'Dịch vụ ' + newRowNumber + ' :';
                newRow.querySelector('.col-number input').value = '';

                container.appendChild(newRow);
            }
        });
    </script>
@endsection

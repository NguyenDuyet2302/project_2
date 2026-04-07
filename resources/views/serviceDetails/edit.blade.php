@extends('layouts.master')
@section('title', 'Sửa dịch vụ')

@section('content')
    <div class="breadcrumb">Quản lý dịch vụ / <b>sửa dịch vụ #{{ $serviceDetail->service_id }}</b></div>

    <div class="card-box" style="max-width: 800px;">
        <div class="form-header-line">Dịch vụ</div>

        <form method="post" action="{{ route('serviceDetails.update', ['service_id' => $serviceDetail->service_id, 'room_id' => $serviceDetail->room_id]) }}">
            @csrf
            @method('PUT')

            <div class="form-grid" style="margin-bottom: 20px;">
                <div class="form-group">
                    <label>Chọn phòng :</label>
                    <select name="room_id" id="room_select" class="form-control" required>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}" data-month="{{ $room->current_month ?? date('Y-m') }}" @selected($serviceDetail->room_id == $room->id)>
                                {{ $room->name ?? $room->number }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Tháng :</label>
                    <input type="month" name="month" id="month_input" class="form-control" value="{{ $serviceDetail->month ?? date('Y-m') }}" readonly style="background-color: #e9ecef;">
                </div>
            </div>

            <div id="services-container">
                <div class="service-row">
                    <div class="form-group col-service">
                        <label>Dịch vụ 1 :</label>
                        <select name="service_id[]" class="form-control" required>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" @selected($serviceDetail->service_id == $service->id)>
                                    {{ $service->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-number">
                        <label>Số :</label>
                        <input type="number" name="new_index[]" value="{{ $serviceDetail->new_index }}" class="form-control" required>
                    </div>
                    <div class="form-group col-btn">
                        <button type="button" class="btn-mini-add btn-duplicate-row">Thêm</button>
                        <button type="button" class="btn-mini-delete btn-remove-row">Xóa</button>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('serviceDetails.index') }}" class="btn-cancel">Hủy bỏ</a>
                <button type="submit" class="btn-update">Cập nhật</button>
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

            if (e.target && e.target.classList.contains('btn-remove-row')) {
                let container = document.getElementById('services-container');
                let rows = container.getElementsByClassName('service-row');
                if(rows.length > 1) {
                    e.target.closest('.service-row').remove();
                    let remainingRows = container.getElementsByClassName('service-row');
                    for(let i = 0; i < remainingRows.length; i++) {
                        remainingRows[i].querySelector('.col-service label').textContent = 'Dịch vụ ' + (i + 1) + ' :';
                    }
                }
            }
        });
    </script>
@endsection

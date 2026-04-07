@extends('layouts.master')
@section('title', 'Cập nhật dịch vụ gốc')

@section('content')
    <div class="breadcrumb">Danh mục dịch vụ / <b>Cập nhật #{{ $service->id }}</b></div>

    <div class="card-box" style="max-width: 600px;">
        <form method="post" action="{{ route('services.update', $service->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group" style="margin-bottom: 15px;">
                <label>Tên dịch vụ :</label>
                <input type="text" name="name" value="{{ $service->name }}" class="form-control" required>
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label>Giá đơn vị :</label>
                <input type="number" name="unit_price" value="{{ $service->unit_price }}" class="form-control" required>
            </div>

            <div class="form-group" style="margin-bottom: 25px;">
                <label>Tên đơn vị :</label>
                <input type="text" name="unit_name" value="{{ $service->unit_name }}" class="form-control" required>
            </div>

            <div class="form-actions">
                <a href="{{ route('services.index') }}" class="btn-cancel">Hủy</a>
                <button type="submit" class="btn-update">Cập nhật</button>
            </div>
        </form>
    </div>
@endsection

@extends('layouts.master')
@section('title', 'Thêm dịch vụ gốc')

@section('content')
    <div class="breadcrumb">Danh mục dịch vụ / <b>Thêm mới</b></div>

    <div class="card-box" style="max-width: 600px;">
        <form method="post" action="{{ route('services.store') }}">
            @csrf
            <div class="form-group" style="margin-bottom: 15px;">
                <label>Tên dịch vụ :</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label>Giá đơn vị :</label>
                <input type="number" name="unit_price" class="form-control" required>
            </div>

            <div class="form-group" style="margin-bottom: 25px;">
                <label>Tên đơn vị :</label>
                <input type="text" name="unit_name" class="form-control" required>
            </div>

            <div class="form-actions">
                <a href="{{ route('services.index') }}" class="btn-cancel">Hủy</a>
                <button type="submit" class="btn-save">Lưu dịch vụ</button>
            </div>
        </form>
    </div>
@endsection

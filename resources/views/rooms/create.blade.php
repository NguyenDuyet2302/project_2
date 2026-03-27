@extends('layouts.master')
@section('title', 'Thêm phòng mới')
@section('content')
    <div class="page-title">
        Quản Lý Phòng / <strong>Thêm phòng mới</strong>
    </div>

    <div class="form-container">
        <div class="form-subtitle">THÔNG TIN CẤU HÌNH PHÒNG TRỌ</div>

        <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-grid">
                <div class="form-group">
                    <label>Số phòng (Ví dụ: 001, 101):</label>
                    <input type="text" name="number" class="form-control" placeholder="Nhập số phòng..." required>
                </div>

                <div class="form-group">
                    <label>Diện tích (m²):</label>
                    <input type="text" name="area" class="form-control" placeholder="Ví dụ: 25.5">
                </div>

                <div class="form-group">
                    <label>Giá thuê (VNĐ/Tháng):</label>
                    <input type="number" name="price" class="form-control" placeholder="Ví dụ: 3000000" required>
                </div>

                <div class="form-group">
                    <label>Trạng thái hiện tại:</label>
                    <select name="status" class="form-control">
                        <option value="1">Còn Trống (Sẵn sàng cho thuê)</option>
                        <option value="2">Hết (Đang có khách ở)</option>
                    </select>
                </div>

                <div class="form-group" style="grid-column: span 2;">
                    <label>Hình ảnh phòng thực tế:</label>
                    <input type="file" name="image" id="file-upload" hidden accept="image/*" onchange="previewImage(this)">

                    <div class="upload-zone" onclick="document.getElementById('file-upload').click()">
                        <div id="upload-label">
                            <i class="fa-solid fa-camera" style="font-size: 2.5rem; color: #00ff9d; margin-bottom: 10px;"></i>
                            <p style="margin: 0; color: #666;">Nhấp vào đây để chọn hoặc chụp ảnh phòng</p>
                        </div>
                        <img id="img-preview" class="img-preview">
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('rooms.index') }}" class="btn-cancel">Hủy bỏ</a>
                <button type="submit" class="btn-save">+ Thêm Phòng</button>
            </div>
        </form>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('upload-label').style.display = 'none';
                    let imgPreview = document.getElementById('img-preview');
                    imgPreview.src = e.target.result;
                    imgPreview.style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection

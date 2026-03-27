@extends('layouts.master')

@section('title', 'Thêm phòng mới')

@section('content')
    <style>
        .page-title { font-size: 1.8rem; font-weight: normal; margin-bottom: 20px; color: #333; }
        .form-container { background: #fff; padding: 40px; border-radius: 15px; border: 1px solid #ddd; max-width: 900px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); }
        .form-subtitle { font-size: 1.1rem; color: #666; margin-bottom: 30px; border-bottom: 2px solid #00ff9d; padding-bottom: 10px; display: inline-block; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 25px; }
        .form-group { display: flex; flex-direction: column; }
        .form-group label { font-weight: bold; margin-bottom: 10px; color: #000; }
        .form-control { padding: 15px; border-radius: 10px; border: 1px solid #ccc; font-size: 1rem; outline: none; transition: 0.2s; }
        .form-control:focus { border-color: #00ff9d; box-shadow: 0 0 0 3px rgba(0, 255, 157, 0.1); }
        .upload-zone { border: 2px dashed #ccc; border-radius: 12px; padding: 30px; text-align: center; cursor: pointer; transition: 0.3s; background: #fafafa; }
        .upload-zone:hover { border-color: #00ff9d; background: #f0fff9; }
        .img-preview { max-width: 100%; max-height: 250px; border-radius: 10px; display: none; margin: 10px auto; border: 1px solid #ddd; object-fit: cover; }
        .form-actions { display: flex; gap: 20px; margin-top: 40px; justify-content: flex-end; }
        .btn-save { background-color: #00ff9d; color: #000; border: 1px solid #555; padding: 12px 50px; border-radius: 25px; font-weight: bold; font-size: 1.1rem; cursor: pointer; transition: 0.3s; }
        .btn-save:hover { background-color: #00e68e; transform: translateY(-2px); }
        .btn-cancel { background-color: #ff4444; color: #fff; border: 1px solid #555; padding: 12px 50px; border-radius: 25px; font-weight: bold; font-size: 1.1rem; text-decoration: none; text-align: center; }
    </style>

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

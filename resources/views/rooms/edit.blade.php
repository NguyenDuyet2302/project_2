@extends('layouts.master')

@section('title', 'Cập nhật phòng')

@section('content')
    <style>
        .page-title { font-size: 1.8rem; font-weight: normal; margin-bottom: 20px; color: #333; }
        .form-container { background: #fff; padding: 40px; border-radius: 15px; border: 1px solid #555; max-width: 900px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); }
        .form-subtitle { font-size: 1.1rem; color: #666; margin-bottom: 30px; border-bottom: 2px solid #00ff9d; padding-bottom: 10px; display: inline-block; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 25px; }
        .form-group { display: flex; flex-direction: column; }
        .form-group label { font-weight: bold; margin-bottom: 10px; color: #000; }
        .form-control { padding: 15px; border-radius: 10px; border: 1px solid #ccc; font-size: 1rem; outline: none; transition: 0.2s; }
        .form-control:focus { border-color: #00ff9d; box-shadow: 0 0 0 3px rgba(0, 255, 157, 0.1); }
        .image-section { display: flex; gap: 20px; align-items: flex-start; margin-top: 10px; }
        .current-image-box { text-align: center; flex: 1; }
        .current-image-box img { width: 100%; max-height: 200px; border-radius: 10px; border: 1px solid #ddd; object-fit: cover; }
        .upload-zone { flex: 1; border: 2px dashed #ccc; border-radius: 12px; padding: 20px; text-align: center; cursor: pointer; transition: 0.3s; background: #fafafa; min-height: 180px; display: flex; flex-direction: column; justify-content: center; align-items: center; }
        .upload-zone:hover { border-color: #00ff9d; background: #f0fff9; }
        .img-preview { max-width: 100%; max-height: 180px; border-radius: 8px; display: none; object-fit: cover; }
        .form-actions { display: flex; gap: 20px; margin-top: 40px; justify-content: flex-end; }
        .btn-update { background-color: #00ff9d; color: #000; border: 1px solid #555; padding: 12px 50px; border-radius: 25px; font-weight: bold; font-size: 1.1rem; cursor: pointer; transition: 0.3s; }
        .btn-update:hover { background-color: #00e68e; transform: translateY(-2px); }
        .btn-cancel { background-color: #ff4444; color: #fff; border: 1px solid #555; padding: 12px 50px; border-radius: 25px; font-weight: bold; font-size: 1.1rem; text-decoration: none; text-align: center; }
    </style>

    <div class="page-title">
        Quản Lý Phòng / <strong>Chỉnh sửa phòng #{{ $room->id }}</strong>
    </div>

    <div class="form-container">
        <div class="form-subtitle">CẬP NHẬT THÔNG TIN PHÒNG</div>

        <form action="{{ route('rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="form-group">
                    <label>Số phòng:</label>
                    <input type="text" name="number" class="form-control" value="{{ $room->number }}" required>
                </div>

                <div class="form-group">
                    <label>Diện tích (m²):</label>
                    <input type="text" name="area" class="form-control" value="{{ $room->area }}">
                </div>

                <div class="form-group">
                    <label>Giá thuê (VNĐ):</label>
                    <input type="number" name="price" class="form-control" value="{{ $room->price }}" required>
                </div>

                <div class="form-group">
                    <label>Trạng thái:</label>
                    <select name="status" class="form-control">
                        <option value="1" @selected($room->status == 1)>Còn Trống</option>
                        <option value="2" @selected($room->status == 2)>Hết / Đã thuê</option>
                    </select>
                </div>

                <div class="form-group" style="grid-column: span 2;">
                    <label>Hình ảnh phòng:</label>
                    <div class="image-section">
                        <div class="current-image-box">
                            <p style="font-size: 0.8rem; color: #888;">Ảnh hiện tại</p>
                            <img src="{{ $room->image ? asset('storage/'.$room->image) : 'https://via.placeholder.com/200x150' }}" alt="Room Image">
                        </div>

                        <input type="file" name="image" id="file-edit" hidden accept="image/*" onchange="previewImageEdit(this)">
                        <div class="upload-zone" onclick="document.getElementById('file-edit').click()">
                            <div id="edit-label">
                                <i class="fa-solid fa-upload" style="font-size: 2rem; color: #00ff9d; margin-bottom: 10px;"></i>
                                <p style="margin: 0; color: #666; font-size: 0.9rem;">Nhấn để thay đổi ảnh mới</p>
                            </div>
                            <img id="edit-img-preview" class="img-preview">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('rooms.index') }}" class="btn-cancel">Hủy bỏ</a>
                <button type="submit" class="btn-update">Cập nhật ngay</button>
            </div>
        </form>
    </div>

    <script>
        function previewImageEdit(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('edit-label').style.display = 'none';
                    let imgPreview = document.getElementById('edit-img-preview');
                    imgPreview.src = e.target.result;
                    imgPreview.style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection

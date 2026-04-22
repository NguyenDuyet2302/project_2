@extends('layouts.master')
@section('title', 'Cập nhật phòng')
@section('content')
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
                            <img src="{{ $room->image_url ?: 'https://via.placeholder.com/200x150' }}" alt="Room Image">
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

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Document</title>
</head>
<body>
<h3>Update a cate</h3>
<form method="post" action="{{ route('rooms.update', $room->id) }}">
    @csrf
    @method('PUT')
    Number: <input type="text" name="number" value="{{ $room ->  number}}"><br>
    Price: <input type="number" name="price" value="{{ $room ->  price}}"><br>
    <label>Room status:</label>
    <label>Trạng thái phòng:</label>
    <select name="status" class="form-control" required>
        <option value="0" @selected(old('status', $room->status) == 0)>
            Phòng trống
        </option>
        <option value="1" @selected(old('status', $room->status) == 1)>
            Đã có khách thuê
        </option>
        <option value="2" @selected(old('status', $room->status) == 2)>
            Đang sửa chữa / Bảo trì
        </option>
    </select><br>
    Description: <input type="text" name="description" value="{{ $room ->  description}}"><br>
    Max people: <input type="number" name="max_people" value="{{ $room ->  max_people}}"><br>
    <button>Update</button>
</form>
</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Document</title>
</head>
<body>
<h3>Add a room</h3>
<form method="post" action="{{ route('rooms.store') }}">
    @csrf
    Number: <input type="text" name="number"><br>
    Price: <input type="number" name="price"><br>
    <label>Trạng thái phòng:</label>
    <select name="status" class="form-control" required>
        <option value="0">Phòng trống</option>
        <option value="1">Đã có khách thuê</option>
        <option value="2">Đang sửa chữa / Bảo trì</option>
    </select><br>
    Description: <input type="text" name="description"><br>
    Max people: <input type="number" name="max_people"><br>
    <button>Add</button>
</form>
</body>
</html>

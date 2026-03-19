<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Document</title>
</head>
<body>
<h3>Add a contract</h3>
<form method="post" action="{{ route('contracts.store') }}">
    @csrf
    User: <select name="user_id">
        @foreach($users as $user)
            <option value="{{ $user->id }}">
                {{ $user->fullname }}
            </option>
        @endforeach
    </select><br>
    Room: <select name="room_id">
        @foreach($rooms as $room)
            <option value="{{ $room->id }}">
                {{ $room->name }}
            </option>
        @endforeach
    </select><br>
    Start date: <input type="date" name="start_date"><br>
    End Date: <input type="date" name="end_date"><br>
    Deposit: <input type="text" name="deposit"><br>
    Status: <select name="status">
        <option value="0">Chờ duyệt</option>
        <option value="1">Đang có hiệu lực</option>
        <option value="2">Đã thanh lý / Kết thúc</option>
    </select><br>
    <button>Add</button>
</form>
</body>
</html>

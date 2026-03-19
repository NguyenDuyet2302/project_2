<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Document</title>
</head>
<body>
<h3>Update a cate</h3>
<form method="post" action="{{ route('contracts.update', $contract->id) }}">
    @csrf
    @method('PUT')
    <label>Khách thuê:</label>
    <select name="user_id" class="form-control">
        @foreach($users as $user)
            <option value="{{ $user->id }}" @selected(old('user_id', $contract->user_id) == $user->id)>
                {{ $user->fullname }} </option>
        @endforeach
    </select><br>
    <label>Phòng:</label>
    <select name="room_id" class="form-control">
        @foreach($rooms as $room)
            <option value="{{ $room->id }}" @selected(old('room_id', $contract->room_id) == $room->id)>
                {{ $room->name }} </option>
        @endforeach
    </select><br>
    Start date: <input type="date" name="start_date" value="{{$contract->start_date}}"><br>
    End Date: <input type="date" name="end_date" value="{{$contract->end_date}}"><br>
    Deposit: <input type="text" name="deposit" value="{{$contract->deposit}}"><br>
    Status: <select name="status">
        <option value="0" @selected(old('status', $contract->status) == 0)>
            Chờ duyệt
        </option>
        <option value="1" @selected(old('status', $contract->status) == 1)>
            Đang có hiệu lực
        </option>
        <option value="2" @selected(old('status', $contract->status) == 2)>
            Đã thanh lý / Kết thúc
        </option>
    </select><br>
    <button type="submit">Update</button>
</form>
</body>
</html>

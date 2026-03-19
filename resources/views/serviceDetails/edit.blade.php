<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Document</title>
</head>
<body>
<h3>Update a cate</h3>
<form method="post" action="{{ route('serviceDetails.update', ['service_id' => $serviceDetail->service_id, 'room_id' => $serviceDetail->room_id]) }}">
    @csrf
    @method('PUT')
    <label>Service:</label>
    <select name="service_id" class="form-control">
        @foreach($services as $service)
            <option value="{{ $service->id }}" @selected(old('service_id', $serviceDetail->service_id) == $service->id)>
                {{ $service->name }} </option>
        @endforeach
    </select><br>
    <label>Room:</label>
    <select name="room_id" class="form-control">
        @foreach($rooms as $room)
            <option value="{{ $room->id }}" @selected(old('room_id', $serviceDetail->room_id) == $room->id)>
                {{ $room->name }} </option>
        @endforeach
    </select><br>
    Old Index: <input type="number" name="old_index" value="{{$serviceDetail->old_index}}"><br>
    New Index: <input type="number" name="new_index" value="{{$serviceDetail->new_index}}"><br>
    <button type="submit">Update</button>
</form>
</body>
</html>

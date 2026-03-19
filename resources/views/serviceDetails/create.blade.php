<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Document</title>
</head>
<body>
<h3>Add a serviceDetail</h3>
<form method="post" action="{{ route('serviceDetails.store') }}">
    @csrf
    Service: <select name="service_id">
        @foreach($services as $service)
            <option value="{{ $service->id }}">
                {{ $service->name }}
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
    Old Index: <input type="number" name="old_index"><br>
    New Index: <input type="number" name="new_index"><br>
    <button>Add</button>
</form>
</body>
</html>

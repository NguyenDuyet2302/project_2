<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Document</title>
</head>
<body>
<h3>Update a service</h3>
<form method="post" action="{{ route('services.update', $service->id) }}">
    @csrf
    @method('PUT')
    Name: <input type="text" name="name" value="{{ $service ->  name}}"><br>
    Unit Price: <input type="text" name="unit_price" value="{{ $service ->  unit_price}}"><br>
    Unit Name: <input type="text" name="unit_name" value="{{ $service ->  unit_name}}"><br>
    <button>Update</button>
</form>
</body>
</html>

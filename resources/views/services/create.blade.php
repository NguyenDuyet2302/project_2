<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Document</title>
</head>
<body>
<h3>Add a service</h3>
<form method="post" action="{{ route('services.store') }}">
    @csrf
    Name: <input type="text" name="name"><br>
    Unit price: <input type="text" name="unit_price"><br>
    Unit name: <input type="text" name="unit_name"><br>
    <button>Add</button>
</form>
</body>
</html>

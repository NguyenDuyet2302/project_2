<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Document</title>
</head>
<body>
<h3>Update a cate</h3>
<form method="post" action="{{ route('payment_methods.update', $paymentMethod->id) }}">
    @csrf
    @method('PUT')
    Name: <input type="text" name="name" value="{{ $paymentMethod ->  name}}"><br>
    Code: <input type="text" name="code" value="{{ $paymentMethod ->  code}}"><br>
    Description: <input type="text" name="description" value="{{ $paymentMethod ->  description}}"><br>
    <button>Update</button>
</form>
</body>
</html>

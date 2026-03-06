<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Document</title>
</head>
<body>
<h3>Update a cate</h3>
<form method="post" action="{{ route('users.update', $user->id) }}">
    @csrf
    @method('PUT')
    Fullname: <input type="text" name="fullname" value="{{ $user ->  fullname}}"><br>
    Email: <input type="text" name="email" value="{{ $user ->  email}}"><br>
    Password: <input type="password" name="password" value="{{ $user ->  password}}"><br>
    Phone: <input type="text" name="phone" value="{{ $user ->  phone}}"><br>
    ID Card: <input type="text" name="id_card" value="{{ $user ->  id_card}}"><br>
    Address: <input type="text" name="address" value="{{ $user ->  address}}"><br>
    Role: <input type="text" name="role" value="{{ $user ->  role}}"><br>
    <button>Update</button>
</form>
</body>
</html>

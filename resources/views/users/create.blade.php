<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Document</title>
</head>
<body>
<h3>Add a user</h3>
<form method="post" action="{{ route('users.store') }}">
    @csrf
    Fullname: <input type="text" name="fullname"><br>
    Email: <input type="text" name="email"><br>
    Password: <input type="password" name="password"><br>
    Phone: <input type="text" name="phone"><br>
    ID Card: <input type="text" name="id_card"><br>
    Address: <input type="text" name="address"><br>
    Role: <input type="text" name="role"><br>
    <button>Add</button>
</form>
</body>
</html>

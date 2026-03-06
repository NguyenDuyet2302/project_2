<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Document</title>
</head>
<body>
<h3>Users List</h3>
<a href="{{ route('users.create')}}">Add a user</a>
<table border="1px" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th>ID</th>
        <th>FullName</th>
        <th>Email</th>
        <th>Password</th>
        <th>Phone</th>
        <th>Id Card</th>
        <th>Address</th>
        <th>Role</th>
        <th></th>
        <th></th>
    </tr>
    @foreach($users as $user)
        <tr>
            <td>
                {{ $user->id }}
            </td>
            <td>
                {{ $user->fullname }}
            </td>
            <td>
                {{ $user->email }}
            </td>
            <td>
                {{ $user->password }}
            </td>
            <td>
                {{ $user->phone }}
            </td>
            <td>
                {{ $user->id_card }}
            </td>
            <td>
                {{ $user->address }}
            </td>
            <td>
                {{ $user->role }}
            </td>
            <td>
                <a href="{{ route('users.edit', $user->id) }}">Edit</a>
            </td>
            <td>
                <form method="post" action="{{ route('users.destroy', $user->id) }}">
                    @csrf
                    @method('DELETE')
                    <button>Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>
</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Document</title>
</head>
<body>
<h3>Contract List</h3>
<a href="{{ route('contracts.create')}}">Add a contract</a>
<table border="1px" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th>ID</th>
        <th>User Name</th>
        <th>Room Number</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Deposit</th>
        <th>Status</th>
        <th></th>
        <th></th>
    </tr>
    @foreach($contracts as $contract)
        <tr>
            <td>
                {{ $contract->id }}
            </td>
            <td>
                {{ $contract->user->fullname }}
            </td>
            <td>
                {{ $contract->room->number }}
            </td>
            <td>
                {{ $contract->start_date }}
            </td>
            <td>
                {{ $contract->end_date }}
            </td>
            <td>
                {{ $contract->deposit }}
            </td>
            <td>
                {{ $contract->status }}
            </td>
            <td>
                <a href="{{ route('contracts.edit', $contract->id) }}">Edit</a>
            </td>
            <td>
                <form method="post" action="{{ route('contracts.destroy', $contract->id) }}">
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

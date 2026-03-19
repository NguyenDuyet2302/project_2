<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Document</title>
</head>
<body>
<h3>Contract List</h3>
<a href="{{ route('serviceDetails.create')}}">Add a serviceDetail</a>
<table border="1px" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th>Service</th>
        <th>Room</th>
        <th>Old index</th>
        <th>New index</th>
        <th>Created at</th>
        <th>Updated at</th>
        <th></th>
        <th></th>
    </tr>
    @foreach($serviceDetails as $serviceDetail)
        <tr>
            <td>
                {{ $serviceDetail->service->name }}
            </td>
            <td>
                {{ $serviceDetail->room->number }}
            </td>
            <td>
                {{ $serviceDetail->old_index }}
            </td>
            <td>
                {{ $serviceDetail->new_index }}
            </td>
            <td>
                {{ $serviceDetail->created_at }}
            </td>
            <td>
                {{ $serviceDetail->updated_at }}
            </td>
            <td>
                <a href="{{ route('serviceDetails.edit', ['service_id' => $serviceDetail->service_id, 'room_id' => $serviceDetail->room_id]) }}">Edit</a>
            </td>
            <td>
                <form method="post" action="{{ route('serviceDetails.destroy', ['service_id' => $serviceDetail->service_id, 'room_id' => $serviceDetail->room_id]) }}">
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

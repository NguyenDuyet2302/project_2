<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Document</title>
</head>
<body>
<h3>Services List</h3>
<a href="{{ route('services.create')}}">Add a service</a>
<table border="1px" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Unit Price</th>
        <th>Unit Name</th>
        <th></th>
        <th></th>
    </tr>
    @foreach($services as $service)
        <tr>
            <td>
                {{ $service->id }}
            </td>
            <td>
                {{ $service->name }}
            </td>
            <td>
                {{ $service->unit_price }}
            </td>
            <td>
                {{ $service->unit_name }}
            </td>
            <td>
                <a href="{{ route('services.edit', $service->id) }}">Edit</a>
            </td>
            <td>
                <form method="post" action="{{ route('services.destroy', $service->id) }}">
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

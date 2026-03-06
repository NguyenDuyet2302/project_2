<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Document</title>
</head>
<body>
<h3>Payment method List</h3>
<a href="{{ route('payment_methods.create')}}">Add a payment methods</a>
<table border="1px" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Code</th>
        <th>Desc</th>
        <th></th>
        <th></th>
    </tr>
    @foreach($paymentMethods as $payment_method)
        <tr>
            <td>
                {{ $payment_method->id }}
            </td>
            <td>
                {{ $payment_method->name }}
            </td>
            <td>
                {{ $payment_method->code }}
            </td>
            <td>
                {{ $payment_method->description }}
            </td>
            <td>
                <a href="{{ route('payment_methods.edit', $payment_method->id) }}">Edit</a>
            </td>
            <td>
                <form method="post" action="{{ route('payment_methods.destroy', $payment_method->id) }}">
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

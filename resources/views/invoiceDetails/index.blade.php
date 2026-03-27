<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
</head>
<body>
<h3>Invoice Detail List</h3>
<a href="{{ route('invoiceDetails.create')}}">Add a invoiceDetail</a>

<table border="1px" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th>Service</th>
        <th>Invoice</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Old index</th>
        <th>New index</th>
        <th>Amount</th>
        <th></th>
        <th></th>
    </tr>
    @foreach($invoiceDetails as $invoiceDetail)
        <tr>
            <td>{{ $invoiceDetail->service->name }}</td>
            <td>{{ $invoiceDetail->invoice->id }}</td>
            <td>{{ $invoiceDetail->quantity }}</td>
            <td>{{ $invoiceDetail->price }}</td>
            <td>{{ $invoiceDetail->old_index }}</td>
            <td>{{ $invoiceDetail->new_index }}</td>
            <td>{{ $invoiceDetail->amount }}</td>
            <td>
                <a href="{{ route('invoiceDetails.edit', ['service_id' => $invoiceDetail->service_id, 'invoice_id' => $invoiceDetail->invoice_id]) }}">Edit</a>
            </td>
            <td>
                <form method="post" action="{{ route('invoiceDetails.destroy', ['service_id' => $invoiceDetail->service_id, 'invoice_id' => $invoiceDetail->invoice_id]) }}">
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

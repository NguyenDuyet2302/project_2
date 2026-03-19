<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Document</title>
</head>
<body>
<h3>Invoice List</h3>
<a href="{{ route('invoices.create')}}">Add a invoice</a>
<table border="1px" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th>ID</th>
        <th>Fullname</th>
        <th>Billing Date</th>
        <th>Total amount</th>
        <th>Status</th>
        <th></th>
        <th></th>
    </tr>
    @foreach($invoices as $invoice)
        <tr>
            <td>
                {{ $invoice->id }}
            </td>
            <td>
                {{ $invoice->contract->user->fullname }}
            </td>
            <td>
                {{ $invoice->billing_date }}
            </td>
            <td>
                {{ $invoice->total_amount }}
            </td>
            <td>
                @if($invoice->status == 0)
                    <span style="color: red; font-weight: bold;">Chưa nộp</span>
                @else
                    <span style="color: green; font-weight: bold;">Đã nộp</span>
                @endif
            </td>
            <td>
                <a href="{{ route('invoices.edit', $invoice->id) }}">Edit</a>
            </td>
            <td>
                <form method="post" action="{{ route('invoices.destroy', $invoice->id) }}">
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

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
</head>
<body>
<h3>Add a invoiceDetail</h3>
<form method="post" action="{{ route('invoiceDetails.store') }}">
    @csrf
    Service:
    <select name="service_id">
        @foreach($services as $service)
            <option value="{{ $service->id }}">
                {{ $service->name }}
            </option>
        @endforeach
    </select><br>

    Invoice:
    <select name="invoice_id">
        @foreach($invoices as $invoice)
            <option value="{{ $invoice->id }}">
                {{ $invoice->id }}
            </option>
        @endforeach
    </select><br>

    Quantity: <input type="number" name="quantity"><br>
    Price: <input type="number" name="price"><br>
    Old Index: <input type="number" name="old_index"><br>
    New Index: <input type="number" name="new_index"><br>
    Amount: <input type="number" name="amount"><br>
    <button>Add</button>
</form>
</body>
</html>

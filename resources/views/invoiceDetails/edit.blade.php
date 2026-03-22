<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Document</title>
</head>
<body>
<h3>Update a Invoice Detail</h3>
<form method="post" action="{{ route('invoiceDetails.update', ['service_id' => $invoiceDetail->service_id, 'invoice_id' => $invoiceDetail->invoice_id]) }}">
    @csrf
    @method('PUT')
    <label>Service:</label>
    <select name="service_id" class="form-control">
        @foreach($services as $service)
            <option value="{{ $service->id }}" @selected(old('service_id', $invoiceDetail->service_id) == $service->id)>
                {{ $service->name }} </option>
        @endforeach
    </select><br>
    <label>Invoice:</label>
    <select name="invoice_id" class="form-control">
        @foreach($invoices as $invoice)
            <option value="{{ $invoice->id }}" @selected(old('invoice_id', $invoiceDetail->invoice_id) == $invoice->id)>
                {{ $invoice->id }} </option>
        @endforeach
    </select><br>
    Quantity: <input type="number" name="quantity" value="{{$invoiceDetail->quantity}}"><br>
    Price: <input type="number" name="price" value="{{$invoiceDetail->price}}"><br>
    Old Index: <input type="number" name="old_index" value="{{$invoiceDetail->old_index}}"><br>
    New Index: <input type="number" name="new_index" value="{{$invoiceDetail->new_index}}"><br>
    Amount: <input type="number" name="amount" value="{{$invoiceDetail->amount}}"><br>
    <button type="submit">Update</button>
</form>
</body>
</html>

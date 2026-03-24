<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Document</title>
</head>
<body>
<h3>Add a payment</h3>
<form method="post" action="{{ route('payments.store') }}">
    @csrf
    <label>Hợp đồng (Khách thuê):</label>
    <select name="invoice_id" class="form-control">
        <option value="">-- Choose invoice --</option>
        @foreach($invoices as $invoice)
            <option value="{{ $invoice->id }}">
                Invoice: {{ $invoice->id }} - Khách: {{ $invoice->contract?->user?->fullname ?? 'Trống' }}
            </option>
        @endforeach
    </select><br>
    <label>Payment Method:</label>
    <select name="payment_method_id" class="form-control">
        <option value="">-- Choose method --</option>
        @foreach($paymentMethods as $paymentMethod)
            <option value="{{ $paymentMethod->id }}">
                {{ $paymentMethod->name ?? 'Method ' . $paymentMethod->id }}
            </option>
        @endforeach
    </select><br>
    Amount: <input type="number" name="amount"><br>
    <button>Add</button>
</form>
</body>
</html>

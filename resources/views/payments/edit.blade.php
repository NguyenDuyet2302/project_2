<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Document</title>
</head>
<body>
<h3>Update a payment</h3>
<form method="post" action="{{ route('payments.update', $payment->id) }}">
    @csrf
    @method('PUT')
    <label>Invoice:</label>
    <select name="invoice_id" class="form-control">
        @foreach($invoices as $invoice)
            <option value="{{ $invoice->id }}" @selected(old('invoice_id', $payment->invoice_id) == $invoice->id)>
                Invoice id {{ $invoice->id }} - User: {{ $invoice->contract?->user?->fullname ?? 'Trống' }}
            </option>
        @endforeach
    </select><br>


    <label>Payment Method:</label>
    <select name="payment_method_id" class="form-control">
        <option value="">-- Choose method --</option>
        @foreach($paymentMethods as $paymentMethod)
            <option value="{{ $paymentMethod->id }}" $paymentMethod>
                {{ $paymentMethod->name ?? 'Method ' . $paymentMethod->id }}
            </option>
        @endforeach
    </select><br>
    Amount: <input type="number" name="amount" value="{{ $payment->amount }}" ><br>
    <button type="submit">Update</button>
</form>
</body>
</html>

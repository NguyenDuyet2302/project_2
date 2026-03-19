<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Document</title>
</head>
<body>
<h3>Update a invoice</h3>
<form method="post" action="{{ route('invoices.update', $invoice->id) }}">
    @csrf
    @method('PUT')
    <label>Hợp đồng (Khách thuê):</label>
    <select name="contract_id" class="form-control">
        @foreach($contracts as $contract)
            <option value="{{ $contract->id }}" @selected(old('contract_id', $invoice->contract_id) == $contract->id)>
                Hợp đồng số {{ $contract->id }} - Khách: {{ $contract->user?->fullname ?? 'Trống' }}
            </option>
        @endforeach
    </select><br>
    Billing Date: <input type="date" name="billing_date" value="{{ $invoice->billing_date }}"><br>
    Total Amount: <input type="number" name="total_amount" value="{{ $invoice->total_amount }}"><br>
    <label>Trạng thái thanh toán:</label>
    <select name="status" class="form-control">
        <option value="0" @selected(old('status', $invoice->status) == 0)>Chưa nộp</option>
        <option value="1" @selected(old('status', $invoice->status) == 1)>Đã nộp</option>
    </select><br>
    <button type="submit">Update</button>
</form>
</body>
</html>

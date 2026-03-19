<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Document</title>
</head>
<body>
<h3>Add a invoice</h3>
<form method="post" action="{{ route('invoices.store') }}">
    @csrf
    <label>Hợp đồng (Khách thuê):</label>
    <select name="contract_id" class="form-control">
        <option value="">-- Chọn hợp đồng --</option>
        @foreach($contracts as $contract)
            <option value="{{ $contract->id }}">
                Hợp đồng số {{ $contract->id }} - Khách: {{ $contract->user?->fullname ?? 'Trống' }}
            </option>
        @endforeach
    </select><br>
    Billing Date: <input type="date" name="billing_date"><br>
    Total Amount: <input type="number" name="total_amount"><br>
    <label>Trạng thái thanh toán:</label>
    <select name="status" class="form-control">
        <option value="0" selected>Chưa nộp</option>
        <option value="1">Đã nộp</option>
    </select><br>
    <button>Add</button>
</form>
</body>
</html>

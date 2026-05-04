@extends('layouts.master')
@php
    $monthValue = old('month', $invoice->month);
    if (is_string($monthValue) && str_contains($monthValue, '/')) {
        [$m, $y] = explode('/', $monthValue);
        $monthValue = $y . '-' . str_pad($m, 2, '0', STR_PAD_LEFT);
    }
@endphp
@section('title', 'Cap nhat hoa don')
@section('content')
    <div class="page-title">
        Quan Ly Hoa Don / <strong>Cap nhat hoa don #{{ $invoice->id }}</strong>
    </div>

    <div class="form-container">
        <div class="form-subtitle">CAP NHAT HOA DON TU DU LIEU DICH VU CUA PHONG</div>

        <form method="post" action="{{ route('invoices.update', $invoice->id) }}">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="form-group" style="grid-column: span 2;">
                    <label>Hop dong (Phong - Khach thue):</label>
                    <select name="contract_id" class="form-control" required>
                        @foreach($contracts as $contract)
                            <option value="{{ $contract->id }}" {{ old('contract_id', $invoice->contract_id) == $contract->id ? 'selected' : '' }}>
                                Phong: {{ $contract->room->number }} - Khach: {{ $contract->user->fullname }}
                            </option>
                        @endforeach
                    </select>
                    @error('contract_id')
                        <div style="color: red; margin-top: 6px;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Hoa don thang:</label>
                    <input type="month" name="month" class="form-control" value="{{ $monthValue }}" required>
                    @error('month')
                        <div style="color: red; margin-top: 6px;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Trang thai thanh toan:</label>
                    <select name="status" class="form-control">
                        <option value="0" {{ old('status', (string) $invoice->status) == '0' ? 'selected' : '' }}>Chua thanh toan</option>
                        <option value="1" {{ old('status', (string) $invoice->status) == '1' ? 'selected' : '' }}>Da thanh toan</option>
                    </select>
                    @error('status')
                        <div style="color: red; margin-top: 6px;">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('invoices.index') }}" class="btn-cancel">Huy bo</a>
                <button type="submit" class="btn-update">Cap nhat hoa don</button>
            </div>
        </form>
    </div>
@endsection

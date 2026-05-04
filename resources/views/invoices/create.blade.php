@extends('layouts.master')
@section('title', 'Tao hoa don moi')
@section('content')
    <div class="page-title">
        Quan Ly Hoa Don / <strong>Them hoa don moi</strong>
    </div>

    <div class="form-container">
        <div class="form-subtitle">TAO HOA DON TU DU LIEU DICH VU CUA PHONG</div>

        <form method="post" action="{{ route('invoices.store') }}">
            @csrf

            <div class="form-grid">
                <div class="form-group" style="grid-column: span 2;">
                    <label>Chon hop dong (Phong - Khach thue):</label>
                    <select name="contract_id" class="form-control" required>
                        <option value="">-- Chon hop dong de xuat hoa don --</option>
                        @foreach($contracts as $contract)
                            <option value="{{ $contract->id }}" {{ old('contract_id') == $contract->id ? 'selected' : '' }}>
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
                    <input type="month" name="month" class="form-control" value="{{ old('month', date('Y-m')) }}" required>
                    @error('month')
                        <div style="color: red; margin-top: 6px;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Trang thai thanh toan:</label>
                    <select name="status" class="form-control">
                        <option value="0" {{ old('status', '0') == '0' ? 'selected' : '' }}>Chua thanh toan</option>
                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Da thanh toan</option>
                    </select>
                    @error('status')
                        <div style="color: red; margin-top: 6px;">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('invoices.index') }}" class="btn-cancel">Huy bo</a>
                <button type="submit" class="btn-save">Xuat hoa don</button>
            </div>
        </form>
    </div>
@endsection

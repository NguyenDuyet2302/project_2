<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with(['contract.user', 'contract.room'])
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $contracts = Contract::with(['user', 'room'])->where('status', 1)->get();
        return view('invoices.create', compact('contracts'));
    }

    public function store(Request $request)
    {
        $contract = Contract::with('room')->find($request->contract_id);
        $roomPrice = $contract->room->price ?? 0;

        // Đơn giá điện nước
        $donGiaDien = 3500;
        $donGiaNuoc = 15000;

        $total = $roomPrice + ($request->electricity_index * $donGiaDien)
            + ($request->water_index * $donGiaNuoc)
            + ($request->service_fee ?? 0);

        $data = $request->all();
        $data['total_amount'] = $total;

        Invoice::create($data);

        return Redirect::route('invoices.index')->with('success', 'Đã xuất hóa đơn thành công!');
    }

    public function edit(Invoice $invoice)
    {
        $contracts = Contract::with(['user', 'room'])->get();
        return view('invoices.edit', compact('invoice', 'contracts'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $contract = Contract::with('room')->find($request->contract_id);
        $roomPrice = $contract->room->price ?? 0;

        $total = $roomPrice + ($request->electricity_index * 3500)
            + ($request->water_index * 15000)
            + ($request->service_fee ?? 0);

        $data = $request->all();
        $data['total_amount'] = $total;

        $invoice->update($data);
        return Redirect::route('invoices.index');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        if (Invoice::count() == 0) {
            DB::statement('ALTER TABLE invoices AUTO_INCREMENT = 1');
        }

        return Redirect::route('invoices.index');
    }
}

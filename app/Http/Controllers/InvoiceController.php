<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * SỬA LỖI: Thay get() bằng paginate(10)
     */
    public function index()
    {
        // Lấy hóa đơn kèm thông tin Hợp đồng, sắp xếp mới nhất lên đầu
        $invoices = Invoice::with(['contract.user', 'contract.room'])
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('invoices.index', compact('invoices'));
    }

    /**
     * Form tạo hóa đơn: Chỉ lấy hợp đồng đang hiệu lực
     */
    public function create()
    {
        $contracts = Contract::with(['user', 'room'])->where('status', 1)->get();
        return view('invoices.create', compact('contracts'));
    }

    /**
     * Lưu hóa đơn: Tự động tính Tổng tiền
     */
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

    /**
     * Cập nhật hóa đơn
     */
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

    /**
     * Xóa và Reset ID
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        if (Invoice::count() == 0) {
            DB::statement('ALTER TABLE invoices AUTO_INCREMENT = 1');
        }

        return Redirect::route('invoices.index');
    }
}

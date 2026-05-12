<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Service;
use App\Models\ServiceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class InvoiceController extends Controller
{
    public function index() {
        $invoices = Invoice::with(['contract.user', 'contract.room'])->orderBy('id', 'desc')->paginate(10);
        return view('invoices.index', compact('invoices'));
    }

    public function create() {
        $contracts = Contract::with(['user', 'room'])->where('status', 1)->get();
        return view('invoices.create', compact('contracts'));
    }

    public function store(Request $request) {
        $data = $request->validate([
            'contract_id' => 'required|exists:contracts,id',
            'month' => 'required|date_format:Y-m',
            'status' => 'required|in:0,1',
        ]);

        $exists = Invoice::where('contract_id', $data['contract_id'])->where('month', $data['month'])->exists();
        if ($exists) {
            return Redirect::back()->withInput()->withErrors(['month' => 'Hợp đồng này đã có hóa đơn trong tháng này.']);
        }

        $contract = Contract::with('room')->findOrFail($data['contract_id']);
        $invoiceData = $this->buildInvoiceData($contract);

        DB::transaction(function () use ($data, $invoiceData) {
            $invoice = Invoice::create([
                'contract_id' => $data['contract_id'],
                'month' => $data['month'],
                'electricity_index' => $invoiceData['electricity_quantity'],
                'water_index' => $invoiceData['water_quantity'],
                'service_fee' => $invoiceData['fixed_service_total'],
                'total_amount' => $invoiceData['total_amount'],
                'status' => $data['status'],
            ]);

            foreach ($invoiceData['details'] as $detail) {
                InvoiceDetail::create([
                    'invoice_id' => $invoice->id,
                    'service_id' => $detail['service_id'],
                    'quantity' => $detail['quantity'],
                    'price' => $detail['price'],
                    'old_index' => $detail['old_index'],
                    'new_index' => $detail['new_index'],
                    'amount' => $detail['amount'],
                ]);
            }
        });

        return Redirect::route('invoices.index')->with('success', 'Đã xuất hóa đơn thành công!');
    }

    // FIX LỖI SQL 1451: Xóa chi tiết trước khi xóa hóa đơn tổng
    public function destroy(Invoice $invoice) {
        InvoiceDetail::where('invoice_id', $invoice->id)->delete();
        $invoice->delete();
        if (Invoice::count() == 0) {
            DB::statement('ALTER TABLE invoices AUTO_INCREMENT = 1');
        }
        return Redirect::route('invoices.index')->with('success', 'Đã xóa hóa đơn thành công!');
    }

    private function buildInvoiceData(Contract $contract): array {
        $serviceDetails = ServiceDetail::with('service')->where('room_id', $contract->room_id)->get();
        $roomPrice = (float) ($contract->room->price ?? 0);
        $deposit = 100; // Tiền cọc mặc định theo yêu cầu

        $details = [];
        $electricityQuantity = 0; $waterQuantity = 0; $fixedServiceTotal = 0;

        foreach ($serviceDetails as $serviceDetail) {
            $service = $serviceDetail->service;
            if (!$service) continue;

            $price = (float) $service->unit_price;
            $oldIndex = (float) $serviceDetail->old_index;
            $newIndex = (float) $serviceDetail->new_index;

            if ($this->isElectricityService($service)) {
                $quantity = ($newIndex > $oldIndex) ? ($newIndex - $oldIndex) : 0;
                $amount = $quantity * $price;
                $electricityQuantity = $quantity;
            } elseif ($this->isWaterService($service)) {
                $quantity = ($newIndex > $oldIndex) ? ($newIndex - $oldIndex) : 0;
                $amount = $quantity * $price;
                $waterQuantity = $quantity;
            } else {
                $quantity = 1;
                $amount = $price;
                $fixedServiceTotal += $amount;
            }

            $details[] = [
                'service_id' => $service->id,
                'quantity' => $quantity,
                'price' => $price,
                'old_index' => $oldIndex,
                'new_index' => $newIndex,
                'amount' => $amount,
            ];
        }

        $totalAmount = $roomPrice + $deposit + collect($details)->sum('amount');

        return [
            'electricity_quantity' => $electricityQuantity,
            'water_quantity' => $waterQuantity,
            'fixed_service_total' => $fixedServiceTotal,
            'total_amount' => $totalAmount,
            'details' => $details,
        ];
    }

    private function isElectricityService($service): bool {
        $name = mb_strtolower($service->name, 'UTF-8');
        return str_contains($name, 'điện') || str_contains($name, 'dien') || str_contains(mb_strtolower($service->unit_name), 'kwh');
    }

    private function isWaterService($service): bool {
        $name = mb_strtolower($service->name, 'UTF-8');
        return str_contains($name, 'nước') || str_contains($name, 'nuoc') || str_contains(mb_strtolower($service->unit_name), 'm3');
    }
}

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
    public function index()
    {
        $invoices = Invoice::with(['contract.user', 'contract.room'])
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $contracts = Contract::with(['user', 'room'])
            ->where('status', 1)
            ->get();

        return view('invoices.create', compact('contracts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'contract_id' => 'required|exists:contracts,id',
            'month' => 'required|date_format:Y-m',
            'status' => 'required|in:0,1',
        ]);

        $exists = Invoice::where('contract_id', $data['contract_id'])
            ->where('month', $data['month'])
            ->exists();

        if ($exists) {
            return Redirect::back()
                ->withInput()
                ->withErrors(['month' => 'Hop dong nay da co hoa don trong thang duoc chon.']);
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

        return Redirect::route('invoices.index')->with('success', 'Da xuat hoa don thanh cong!');
    }

    public function edit(Invoice $invoice)
    {
        $contracts = Contract::with(['user', 'room'])->get();

        return view('invoices.edit', compact('invoice', 'contracts'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $data = $request->validate([
            'contract_id' => 'required|exists:contracts,id',
            'month' => 'required|date_format:Y-m',
            'status' => 'required|in:0,1',
        ]);

        $exists = Invoice::where('contract_id', $data['contract_id'])
            ->where('month', $data['month'])
            ->where('id', '!=', $invoice->id)
            ->exists();

        if ($exists) {
            return Redirect::back()
                ->withInput()
                ->withErrors(['month' => 'Hop dong nay da co hoa don trong thang duoc chon.']);
        }

        $contract = Contract::with('room')->findOrFail($data['contract_id']);
        $invoiceData = $this->buildInvoiceData($contract);

        DB::transaction(function () use ($data, $invoice, $invoiceData) {
            $invoice->update([
                'contract_id' => $data['contract_id'],
                'month' => $data['month'],
                'electricity_index' => $invoiceData['electricity_quantity'],
                'water_index' => $invoiceData['water_quantity'],
                'service_fee' => $invoiceData['fixed_service_total'],
                'total_amount' => $invoiceData['total_amount'],
                'status' => $data['status'],
            ]);

            InvoiceDetail::where('invoice_id', $invoice->id)->delete();

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

        return Redirect::route('invoices.index')->with('success', 'Da cap nhat hoa don!');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        if (Invoice::count() == 0) {
            DB::statement('ALTER TABLE invoices AUTO_INCREMENT = 1');
        }

        return Redirect::route('invoices.index');
    }

    private function buildInvoiceData(Contract $contract): array
    {
        $serviceDetails = ServiceDetail::with('service')
            ->where('room_id', $contract->room_id)
            ->get();

        $roomPrice = (float) ($contract->room->price ?? 0);
        $details = [];
        $electricityQuantity = 0;
        $waterQuantity = 0;
        $fixedServiceTotal = 0;

        foreach ($serviceDetails as $serviceDetail) {
            $service = $serviceDetail->service;

            if (!$service) {
                continue;
            }

            $price = (float) $service->unit_price;
            $oldIndex = (float) $serviceDetail->old_index;
            $newIndex = (float) $serviceDetail->new_index;

            if ($this->isElectricityService($service)) {
                $quantity = max($newIndex - $oldIndex, 0);
                $amount = $quantity * $price;
                $electricityQuantity = $quantity;
            } elseif ($this->isWaterService($service)) {
                $quantity = max($newIndex - $oldIndex, 0);
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

        return [
            'electricity_quantity' => $electricityQuantity,
            'water_quantity' => $waterQuantity,
            'fixed_service_total' => $fixedServiceTotal,
            'total_amount' => $roomPrice + $this->sumDetailAmounts($details),
            'details' => $details,
        ];
    }

    private function sumDetailAmounts(array $details): float
    {
        return collect($details)->sum('amount');
    }

    private function isElectricityService(Service $service): bool
    {
        $name = $this->normalizeText($service->name);
        $unit = $this->normalizeText($service->unit_name);

        return str_contains($name, 'dien') || str_contains($unit, 'kwh');
    }

    private function isWaterService(Service $service): bool
    {
        $name = $this->normalizeText($service->name);
        $unit = $this->normalizeText($service->unit_name);

        return str_contains($name, 'nuoc') || str_contains($unit, 'm3');
    }

    private function normalizeText(?string $value): string
    {
        $value = strtolower((string) $value);
        $ascii = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value);

        return $ascii !== false ? strtolower($ascii) : $value;
    }
}

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

    public function createStep2(\Illuminate\Http\Request $request) {
        $request->validate([
            'contract_id' => 'required|exists:contracts,id',
            'month' => 'required|date_format:Y-m',
            'status' => 'required|in:0,1',
        ]);

        $contract = Contract::with('room')->findOrFail($request->contract_id);

        // Kiểm tra xem tháng này phòng đã có hóa đơn chưa
        $exists = Invoice::where('contract_id', $request->contract_id)->where('month', $request->month)->exists();
        if ($exists) {
            return redirect()->back()->withInput()->withErrors(['month' => 'Hợp đồng phòng này đã được xuất hóa đơn cho tháng này rồi.']);
        }

        // Lấy các dịch vụ đã cài đặt của phòng để truyền sang giao diện nhập chỉ số
        $serviceDetails = ServiceDetail::with('service')->where('room_id', $contract->room_id)->get();

        return view('invoices.create_table', [
            'contract' => $contract,
            'month' => $request->month,
            'status' => $request->status,
            'serviceDetails' => $serviceDetails
        ]);
    }

    public function store(Request $request) {
        $data = $request->validate([
            'contract_id' => 'required|exists:contracts,id',
            'month' => 'required|date_format:Y-m',
            'status' => 'required|in:0,1',
            'services' => 'nullable|array'
        ]);

        $exists = Invoice::where('contract_id', $data['contract_id'])->where('month', $data['month'])->exists();
        if ($exists) {
            return Redirect::back()->withInput()->withErrors(['month' => 'Hợp đồng này đã có hóa đơn trong tháng này.']);
        }

        $contract = Contract::with('room')->findOrFail($data['contract_id']);
        $roomPrice = (float)($contract->room->price ?? 0);

        // Lấy lại danh sách dịch vụ cấu hình gốc của phòng
        $serviceDetails = \App\Models\ServiceDetail::with('service')->where('room_id', $contract->room_id)->get();

        $finalDetails = [];
        $electricityQuantity = 0;
        $waterQuantity = 0;
        $fixedServiceTotal = 0;
        $servicesTotalAmount = 0;

        foreach ($serviceDetails as $sd) {
            $service = $sd->service;
            if (!$service) continue;

            $price = (float)$service->unit_price;
            $oldIndex = (float)$sd->old_index;
            $newIndex = (float)$sd->new_index;
            $quantity = 1;
            $amount = $price;

            $isElectric = str_contains(mb_strtolower($service->name, 'UTF-8'), 'điện') || str_contains(mb_strtolower($service->name, 'UTF-8'), 'dien');
            $isWater = str_contains(mb_strtolower($service->name, 'UTF-8'), 'nước') || str_contains(mb_strtolower($service->name, 'UTF-8'), 'nuoc');

            if ($isElectric || $isWater) {
                // Lấy số mới do admin thay đổi từ form giao diện truyền lên
                if (isset($data['services'][$service->id]['new_index'])) {
                    $newIndex = (float)$data['services'][$service->id]['new_index'];
                }
                $quantity = ($newIndex > $oldIndex) ? ($newIndex - $oldIndex) : 0;
                $amount = $quantity * $price;

                if ($isElectric) $electricityQuantity = $quantity;
                if ($isWater) $waterQuantity = $quantity;
            } else {
                $fixedServiceTotal += $amount;
            }

            $servicesTotalAmount += $amount;

            $finalDetails[] = [
                'service_id' => $service->id,
                'quantity' => $quantity,
                'price' => $price,
                'old_index' => $oldIndex,
                'new_index' => $newIndex,
                'amount' => $amount,
            ];
        }

        $totalAmount = $roomPrice + $servicesTotalAmount;

        // ĐỒNG BỘ CHỮ THƯỜNG TOÀN BỘ TRONG HOẶC NGOÀI ĐOẠN USE (...)
        DB::transaction(function () use ($data, $roomPrice, $electricityQuantity, $waterQuantity, $fixedServiceTotal, $totalAmount, $finalDetails, $contract) {
            // 1. Tạo hóa đơn tổng
            $invoice = Invoice::create([
                'contract_id' => $data['contract_id'],
                'month' => $data['month'],
                'electricity_index' => $electricityQuantity,
                'water_index' => $waterQuantity,
                'service_fee' => $fixedServiceTotal,
                'total_amount' => $totalAmount,
                'status' => $data['status'],
            ]);

            // 2. Tạo chi tiết từng dịch vụ đóng tiền của tháng đó
            foreach ($finalDetails as $detail) {
                InvoiceDetail::create([
                    'invoice_id' => $invoice->id,
                    'service_id' => $detail['service_id'],
                    'quantity' => $detail['quantity'],
                    'price' => $detail['price'],
                    'old_index' => $detail['old_index'],
                    'new_index' => $detail['new_index'],
                    'amount' => $detail['amount'],
                ]);

                // 3. ĐỒNG BỘ NGƯỢC LẠI BẢNG SERVICE_DETAILS
                \App\Models\ServiceDetail::where('room_id', $contract->room_id)
                    ->where('service_id', $detail['service_id'])
                    ->update([
                        'old_index' => $detail['new_index'],
                        'new_index' => $detail['new_index'],
                    ]);
            }
        });

        return Redirect::route('invoices.index')->with('success', 'Đã xuất hóa đơn thành công!');
    }

    public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);
        $contracts = Contract::with(['user', 'room'])->get();

        return view('invoices.edit', compact('invoice', 'contracts'));
    }

    // Bổ sung hàm này vào InvoiceController.php Duyệt nhé:
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'status' => 'required|in:0,1',
        ]);

        $invoice = Invoice::findOrFail($id);
        $invoice->update([
            'status' => $data['status']
        ]);

        return redirect()->route('invoices.index')->with('success', 'Cập nhật trạng thái hóa đơn thành công!');
    }

    public function destroy(Invoice $invoice) {
        InvoiceDetail::where('invoice_id', $invoice->id)->delete();
        $invoice->delete();
        if (Invoice::count() == 0) {
            DB::statement('ALTER TABLE invoices AUTO_INCREMENT = 1');
        }
        return Redirect::route('invoices.index')->with('success', 'Đã xóa hóa đơn thành công!');
    }

    // Thêm hàm này vào cuối file InvoiceController.php của bạn
    public function confirmPayment($id)
    {
        $invoice = Invoice::findOrFail($id);
        // Chuyển status thành 1 (Đã thanh toán)
        $invoice->status = 1;
        $invoice->save();

        return redirect()->back()->with('success', 'Xác nhận nộp tiền thành công!');
    }

    private function buildInvoiceData(Contract $contract): array {
        // Lấy danh sách đăng ký chỉ số/dịch vụ của phòng này
        $serviceDetails = ServiceDetail::with('service')->where('room_id', $contract->room_id)->get();
        $roomPrice = (float) ($contract->room->price ?? 0);

        $details = [];
        $electricityQuantity = 0;
        $waterQuantity = 0;
        $fixedServiceTotal = 0;

        foreach ($serviceDetails as $serviceDetail) {
            $service = $serviceDetail->service;
            if (!$service) continue;

            $price = (float) $service->unit_price;
            $oldIndex = (float) $serviceDetail->old_index;
            $newIndex = (float) $serviceDetail->new_index;

            // 1. Tính toán dựa trên loại dịch vụ (Điện / Nước / Cố định)
            if ($this->isElectricityService($service)) {
                $quantity = ($newIndex > $oldIndex) ? ($newIndex - $oldIndex) : 0;
                $amount = $quantity * $price;
                $electricityQuantity = $quantity;
            } elseif ($this->isWaterService($service)) {
                $quantity = ($newIndex > $oldIndex) ? ($newIndex - $oldIndex) : 0;
                $amount = $quantity * $price;
                $waterQuantity = $quantity;
            } else {
                // Đối với Wifi, Rác... Số lượng mặc định là 1, tính theo giá cố định
                $quantity = 1;
                $amount = $price;
                $fixedServiceTotal += $amount; // Gom tổng để lưu vào cột service_fee trong bảng invoices
            }

            // Tách riêng biệt từng dịch vụ cố định thành 1 dòng chi tiết trong mảng để lưu vào bảng invoice_details
            $details[] = [
                'service_id' => $service->id,
                'quantity' => $quantity,
                'price' => $price,
                'old_index' => $oldIndex,
                'new_index' => $newIndex,
                'amount' => $amount,
            ];
        }

        // 2. Công thức tính tổng tiền chuẩn (Bỏ khoản deposit dư thừa 100 ban đầu đi)
        // Tổng tiền = Tiền Phòng + Tổng tiền tất cả dịch vụ trong mảng details (gồm điện, nước, wifi, rác...)
        $totalAmount = $roomPrice + collect($details)->sum('amount');

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

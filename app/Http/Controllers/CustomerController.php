<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Invoice;
use App\Models\Room;
use App\Models\Service;
use App\Models\ServiceDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function index()
    {
        $rooms = Room::where('status', 0)->get();

        return view('customer.home', [
            'customer' => Auth::user(),
            'contract' => null,
            'serviceUsage' => collect(),
            'rooms' => $rooms,
        ]);
    }

    public function dashboard()
    {
        $user = Auth::user();
        $contract = Contract::where('user_id', $user->id)->with('room')->first();
        $invoices = collect();

        if ($contract) {
            $invoices = Invoice::where('contract_id', $contract->id)
                ->with(['contract.room', 'invoiceDetails.service'])
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('customer.home', compact('contract', 'invoices'))
            ->with('customer', $user);
    }

    public function profile()
    {
        return view('customer.profile');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'fullname' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'nullable|string|max:255',
        ]);

        $user->update([
            'fullname' => $request->fullname,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        if ($request->filled('new_password')) {
            $request->validate([
                'new_password' => 'confirmed',
            ]);

            $user->update([
                'password' => bcrypt($request->new_password),
            ]);
        }

        return redirect()->route('customer.home')->with('success', 'Thông tin đã được cập nhật!');
    }

    public function viewContract()
    {
        $customer = Auth::user();
        $contract = Contract::where('user_id', $customer->id)->with('room')->first();

        return view('customer.contract', compact('contract', 'customer'));
    }

    public function viewInvoices()
    {
        $customer = Auth::user();
        $contract = Contract::where('user_id', $customer->id)->first();
        $invoices = collect();

        if ($contract) {
            $invoices = Invoice::where('contract_id', $contract->id)
                ->with(['contract.room', 'invoiceDetails.service'])
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('customer.invoices', compact('invoices', 'customer'));
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Sai mật khẩu cũ');
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Đã đổi mật khẩu');
    }

    public function statistics()
    {
        $user = Auth::user();
        // Lấy hợp đồng còn hiệu lực của khách hàng
        $contract = Contract::where('user_id', $user->id)->with('room')->first();

        if (!$contract) {
            return view('customer.statistics', [
                'contract' => null,
                'chartLabels' => [],
                'electricityUsage' => array_fill(0, 12, 0),
                'waterUsage' => array_fill(0, 12, 0),
                'fixedServices' => collect(),
            ]);
        }

        $chartLabels = collect(range(1, 12))->map(fn ($m) => 'Tháng ' . $m)->all();
        $electricityUsage = array_fill(0, 12, 0);
        $waterUsage = array_fill(0, 12, 0);

        // Lấy lịch sử tất cả hóa đơn của hợp đồng này
        $invoices = Invoice::where('contract_id', $contract->id)
            ->with('invoiceDetails.service')
            ->get();

        foreach ($invoices as $invoice) {
            if (!$invoice->month) continue;

            // 1. Đọc số tháng từ chu kỳ hóa đơn (Ví dụ: "2026-05" -> lấy ra số 5)
            $invoiceMonth = (int) \Carbon\Carbon::parse($invoice->month)->format('n');

            // 2. DỊCH LÙI THÁNG: Kỳ hóa đơn tháng 5 phản ánh lượng tiêu thụ thực tế của Tháng 4
            $actualUsageMonth = $invoiceMonth - 1;
            if ($actualUsageMonth === 0) {
                $actualUsageMonth = 12; // Nếu hóa đơn kỳ tháng 1 thì tiêu thụ thuộc về tháng 12 năm ngoái
            }

            $monthIndex = $actualUsageMonth - 1; // Vị trí mảng biểu đồ (0 -> 11)

            if ($monthIndex >= 0 && $monthIndex < 12) {
                foreach ($invoice->invoiceDetails as $detail) {
                    if (!$detail->service) continue;

                    // 3. CÔNG THỨC CHUẨN: Lượng tiêu thụ = Số mới - Số cũ
                    $oldIdx = (float)$detail->old_index;
                    $newIdx = (float)$detail->new_index;
                    $amountUsed = $newIdx - $oldIdx;

                    if ($amountUsed < 0) $amountUsed = 0; // Tránh lỗi logic nếu nhập sai số

                    if ($this->isElectricityService($detail->service)) {
                        $electricityUsage[$monthIndex] = $amountUsed;
                    } elseif ($this->isWaterService($detail->service)) {
                        $waterUsage[$monthIndex] = $amountUsed;
                    }
                }
            }
        }

        // Bảng dịch vụ cố định bên dưới (Lấy theo hóa đơn mới nhất)
        $fixedServices = collect();
        $latestInvoice = $invoices->sortByDesc('month')->first();

        if ($latestInvoice) {
            $fixedServices = $latestInvoice->invoiceDetails
                ->filter(fn ($detail) => !$this->isElectricityService($detail->service) && !$this->isWaterService($detail->service))
                ->map(function ($detail) {
                    return [
                        'name' => $detail->service->name,
                        'unit' => $detail->service->unit_name ?: 'tháng',
                        'price' => (float)$detail->price,
                        'amount' => (float)$detail->amount,
                    ];
                });
        }

        $fixedServices = $fixedServices->prepend([
            'name' => 'Tiền phòng',
            'unit' => 'tháng',
            'price' => (float)($contract->room->price ?? 0),
            'amount' => (float)($contract->room->price ?? 0),
        ])->values();

        return view('customer.statistics', compact('contract', 'chartLabels', 'electricityUsage', 'waterUsage', 'fixedServices'));
    }

    private function isElectricityService(?Service $service): bool
    {
        if (!$service) return false;
        $name = mb_strtolower($service->name, 'UTF-8');
        // Kiểm tra xem tên có chứa chữ "dien" hoặc "điện" không
        return str_contains($name, 'dien') || str_contains($name, 'điện');
    }

    private function isWaterService(?Service $service): bool
    {
        if (!$service) return false;
        $name = mb_strtolower($service->name, 'UTF-8');
        // Kiểm tra xem tên có chứa chữ "nuoc" hoặc "nước" không
        return str_contains($name, 'nuoc') || str_contains($name, 'nước');
    }

// Hàm này không cần thiết nữa nếu đã kiểm tra trực tiếp như trên,
// Duyệt có thể giữ lại hoặc xóa đi cho gọn code.
    private function normalizeText(?string $value): string
    {
        return strtolower((string) $value);
    }
}

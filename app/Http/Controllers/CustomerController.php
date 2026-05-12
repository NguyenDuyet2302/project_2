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

        // Lấy dữ liệu chỉ số
        $serviceUsages = ServiceDetail::with('service')
            ->where('room_id', $contract->room_id)
            ->get();

        foreach ($serviceUsages as $usage) {
            if (!$usage->reading_date) continue;

            // Lấy tháng hiện tại từ reading_date
            $month = (int) \Carbon\Carbon::parse($usage->reading_date)->format('n');
            $monthIndex = $month - 1; // Index của tháng hiện tại (0-11)

            if ($monthIndex >= 0 && $monthIndex < 12) {
                if ($this->isElectricityService($usage->service)) {
                    // 1. Gán số mới cho tháng hiện tại
                    $electricityUsage[$monthIndex] = (float)$usage->new_index;

                    // 2. Gán số cũ cho tháng trước đó (nếu tháng hiện tại không phải tháng 1)
                    if ($monthIndex > 0) {
                        $electricityUsage[$monthIndex - 1] = (float)$usage->old_index;
                    }
                } elseif ($this->isWaterService($usage->service)) {
                    // Tương tự cho nước
                    $waterUsage[$monthIndex] = (float)$usage->new_index;

                    if ($monthIndex > 0) {
                        $waterUsage[$monthIndex - 1] = (float)$usage->old_index;
                    }
                }
            }
        }

        // Bảng dịch vụ cố định (Giữ nguyên logic lọc bỏ điện nước)
        $fixedServices = ServiceDetail::with('service')
            ->where('room_id', $contract->room_id)
            ->get()
            ->filter(fn ($sd) => !$this->isElectricityService($sd->service) && !$this->isWaterService($sd->service))
            ->unique('service_id')
            ->map(function ($sd) {
                return [
                    'name' => $sd->service->name,
                    'unit' => $sd->service->unit_name ?: 'tháng',
                    'price' => (float)($sd->service->unit_price ?? 0),
                    'amount' => (float)($sd->service->unit_price ?? 0),
                ];
            })
            ->prepend([
                'name' => 'Tiền phòng',
                'unit' => 'tháng',
                'price' => (float)($contract->room->price ?? 0),
                'amount' => (float)($contract->room->price ?? 0),
            ])
            ->values();

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

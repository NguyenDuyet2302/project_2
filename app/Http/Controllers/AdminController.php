<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Invoice;
use App\Models\Room;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class AdminController extends Controller
{
    /**
     * HIỂN THỊ TRANG TỔNG QUAN (DASHBOARD)
     */
    public function dashboard(\Illuminate\Http\Request $request)
    {
        $totalRooms = Room::count();
        $rentedRooms = Room::where('status', 2)->count();
        $availableRooms = Room::where('status', 1)->count();

        $currentYear = Carbon::now()->year;

        // --- ĐỒNG BỘ THEO YÊU CẦU TRƯỚC: Doanh thu hiển thị cố định của tháng hiện tại ngoài đời ---
        $currentMonthStr = date('Y-m');
        $currentMonthRevenue = Invoice::where('status', 1)
            ->where('month', $currentMonthStr)
            ->sum('total_amount');

        // --- 2. Tính doanh thu của từng tháng trong năm (từ tháng 1 -> tháng 12) làm biểu đồ ---
        $monthlyRevenueData = array_fill(0, 12, 0);

        // Gom nhóm doanh thu theo định dạng Y-m được chọn trong hóa đơn
        $allPaidInvoices = Invoice::where('status', 1)->get();
        foreach ($allPaidInvoices as $inv) {
            if (!$inv->month) continue;
            $parsedDate = Carbon::parse($inv->month);
            if ($parsedDate->year == $currentYear) {
                $monthIdx = $parsedDate->month - 1;
                $monthlyRevenueData[$monthIdx] += (float)$inv->total_amount;
            }
        }

        // Tạo nhãn biểu đồ từ Tháng 1 đến Tháng 12
        $chartLabels = collect(range(1, 12))->map(fn ($m) => 'Tháng ' . $m)->all();

        // --- 3. ĐỌC THAM SỐ CLICK TỪ BIỂU ĐỒ TRUYỀN XUỐNG ---
        // Nhận giá trị index từ 0 (Tháng 1) đến 11 (Tháng 12)
        $selectedMonthIndex = $request->get('selected_month');
        $selectedMonthName = null;
        $detailedInvoices = collect();

        if ($selectedMonthIndex !== null && $selectedMonthIndex >= 0 && $selectedMonthIndex < 12) {
            $targetMonth = (int)$selectedMonthIndex + 1; // Đổi về tháng thực tế (1 -> 12)
            $selectedMonthName = "Tháng " . $targetMonth;

            // Lọc ra các hóa đơn đã thanh toán thuộc năm hiện tại và có tháng trùng với tháng được chọn click
            $detailedInvoices = Invoice::with(['contract.user', 'contract.room'])
                ->where('status', 1)
                ->get()
                ->filter(function($invoice) use ($currentYear, $targetMonth) {
                    if (!$invoice->month) return false;
                    $date = Carbon::parse($invoice->month);
                    return $date->year == $currentYear && $date->month == $targetMonth;
                });
        }

        return view('dashboard', compact(
            'totalRooms',
            'rentedRooms',
            'availableRooms',
            'currentMonthRevenue',
            'monthlyRevenueData',
            'chartLabels',
            'selectedMonthName',
            'detailedInvoices'
        ));
    }

    /**
     * Hiển thị danh sách tất cả các Admin
     */
    public function index()
    {
        $admins = Admin::all();
        return view('admin.index', compact('admins'));
    }

    /**
     * Mở form tạo Admin mới
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Xử lý lưu Admin mới vào Database
     */
    public function store(StoreAdminRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        Admin::create($data);

        return redirect()->route('admin.index')->with('success', 'Thêm Admin thành công!');
    }

    /**
     * Xem chi tiết 1 Admin
     */
    public function show(Admin $admin)
    {
        return view('admin.show', compact('admin'));
    }

    /**
     * Mở form sửa thông tin Admin
     */
    public function edit(Admin $admin)
    {
        return view('admin.edit', compact('admin'));
    }

    /**
     * Cập nhật thông tin Admin vào Database
     */
    public function update(UpdateAdminRequest $request, Admin $admin)
    {
        $data = $request->validated();

        if ($request->filled('password')) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $admin->update($data);

        return redirect()->route('admin.index')->with('success', 'Cập nhật Admin thành công!');
    }

    /**
     * Xóa Admin
     */
    public function destroy(Admin $admin)
    {
        if (auth('admin')->id() == $admin->id) {
            return redirect()->back()->with('error', 'Bạn không thể tự xóa tài khoản của chính mình đang đăng nhập!');
        }

        $admin->delete();

        return redirect()->route('admin.index')->with('success', 'Đã xóa Admin!');
    }
}

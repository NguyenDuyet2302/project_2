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
    public function dashboard()
    {
        $totalRooms = Room::count();
        $rentedRooms = Room::where('status', 2)->count();
        $availableRooms = Room::where('status', 1)->count();

        // 1. Tính doanh thu tháng hiện tại (Chỉ tính hóa đơn đã thanh toán status = 1)
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $currentMonthRevenue = Invoice::where('status', 1)
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->sum('total_amount');

        // 2. Tính doanh thu của từng tháng trong năm (từ tháng 1 -> tháng 12) làm biểu đồ
        $monthlyRevenueData = array_fill(0, 12, 0); // Mảng 12 phần tử chứa số 0

        $monthlyRevenues = Invoice::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total_amount) as total')
        )
            ->where('status', 1) // Chỉ tính hóa đơn đã nộp tiền
            ->whereYear('created_at', $currentYear)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();

        foreach ($monthlyRevenues as $revenue) {
            $monthIndex = (int)$revenue->month - 1;
            $monthlyRevenueData[$monthIndex] = (float)$revenue->total;
        }

        // Tạo nhãn biểu đồ từ Tháng 1 đến Tháng 12
        $chartLabels = collect(range(1, 12))->map(fn ($m) => 'Tháng ' . $m)->all();

        return view('dashboard', compact(
            'totalRooms',
            'rentedRooms',
            'availableRooms',
            'currentMonthRevenue',
            'monthlyRevenueData',
            'chartLabels'
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

<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Room; // QUAN TRỌNG: Thêm dòng này để đếm được số lượng Phòng
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use Illuminate\Support\Facades\Hash;

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
        return view('dashboard', compact('totalRooms', 'rentedRooms', 'availableRooms'));
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

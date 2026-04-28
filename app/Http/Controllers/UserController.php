<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', '!=', 1)->paginate(10);
        return view('users.index', ['users' => $users]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'phone' => 'required|unique:users,phone',
            'id_card' => 'required|unique:users,id_card',
            'fullname' => 'required',
        ], [
            'phone.unique' => 'Số điện thoại này đã có khách thuê sử dụng!',
            'id_card.unique' => 'Số CMND/CCCD này đã tồn tại trên hệ thống!',
        ]);

        $data = $request->all();
        $data['role'] = 0;
        $data['email'] = $request->phone . '@nhatro.com';
        $data['password'] = Hash::make('123456');
        unset($data['start_date']);
        User::create($data);
        return Redirect::route('users.index');
    }

    public function edit(User $user)
    {
        return view('users.edit', ['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->all();
        // Nếu có đổi mật khẩu thì mới mã hóa, không thì xóa khỏi mảng data để giữ nguyên pass cũ
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        return redirect()->route('users.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy(User $user)
    {
        $user->delete();

        $remainingGuests = User::where('role', '!=', 1)->count();

        if ($remainingGuests == 0) {
            DB::statement('ALTER TABLE users AUTO_INCREMENT = 1');
        }

        return Redirect::route('users.index');
    }
}

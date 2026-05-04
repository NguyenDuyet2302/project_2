<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

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
            'fullname' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'id_card' => 'required|unique:users,id_card',
        ], [
            'email.required' => 'Ban phai nhap email cho khach thue.',
            'email.email' => 'Email khong dung dinh dang.',
            'email.unique' => 'Email nay da ton tai tren he thong.',
            'phone.unique' => 'So dien thoai nay da co khach thue su dung!',
            'id_card.unique' => 'So CMND/CCCD nay da ton tai tren he thong!',
        ]);

        $data = $request->all();
        $data['role'] = 0;
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
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        return redirect()->route('users.index')->with('success', 'Cap nhat thanh cong!');
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

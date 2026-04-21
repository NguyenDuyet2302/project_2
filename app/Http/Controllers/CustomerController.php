<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Contract;
use App\Models\ServiceDetail;
use App\Models\Room;

class CustomerController extends Controller
{
    public function index()
    {
        $rooms = Room::where('status', 0)->get();

        return view('customer.home', [
            'khach' => null,
            'hopdong' => null,
            'ds_dien_nuoc' => collect(),
            'rooms' => $rooms
        ]);
    }

    public function dashboard()
    {
        $user = Auth::user();

        $hopdong = Contract::where('user_id', $user->id)
            ->where('status', 1)
            ->first();

        $dien_nuoc = collect();

        if ($hopdong) {
            $dien_nuoc = ServiceDetail::where('room_id', $hopdong->room_id)
                ->orderBy('reading_date', 'desc')
                ->get();
        }

        return view('customer.home', [
            'khach' => $user,
            'hopdong' => $hopdong,
            'ds_dien_nuoc' => $dien_nuoc,
            'rooms' => collect()
        ]);
    }
}

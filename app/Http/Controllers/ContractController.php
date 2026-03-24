<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\User;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class ContractController extends Controller
{
    public function index()
    {
        $contracts = Contract::with(['user', 'room'])
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('contracts.index', compact('contracts'));
    }

    public function create()
    {
        $users = User::where('role', 0)->get();
        $rooms = Room::where('status', 1)->get();
        return view('contracts.create', compact('users', 'rooms'));
    }

    public function store(Request $request)
    {
        Contract::create($request->all());
        $room = Room::find($request->room_id);
        if ($room) {
            $room->update(['status' => 2]);
        }
        return Redirect::route('contracts.index');
    }

    public function edit(Contract $contract)
    {
        $users = User::where('role', 0)->get();
        $rooms = Room::where('status', 1)
            ->orWhere('id', $contract->room_id)
            ->get();
        return view('contracts.edit', compact('contract', 'users', 'rooms'));
    }

    public function update(Request $request, Contract $contract)
    {
        if ($contract->room_id != $request->room_id) {
            Room::where('id', $contract->room_id)->update(['status' => 1]);
            Room::where('id', $request->room_id)->update(['status' => 2]);
        }

        $contract->update($request->all());
        return Redirect::route('contracts.index');
    }

    public function destroy(Contract $contract)
    {
        $room = Room::find($contract->room_id);
        if ($room) {
            $room->update(['status' => 1]);
        }

        $contract->delete();

        if (Contract::count() == 0) {
            DB::statement('ALTER TABLE contracts AUTO_INCREMENT = 1');
        }

        return Redirect::route('contracts.index');
    }
}

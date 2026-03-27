<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB; // Bổ sung thư viện DB để ép reset ID

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::query();

        if ($request->filled('search')) {
            $query->where('number', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $rooms = $query->latest()->paginate(5)->withQueryString();

        return view('rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('rooms.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('rooms', 'public');
            $data['image'] = $path;
        }

        Room::create($data);
        return Redirect::route('rooms.index');
    }

    public function edit(Room $room)
    {
        return view('rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($room->image) {
                Storage::disk('public')->delete($room->image);
            }
            $path = $request->file('image')->store('rooms', 'public');
            $data['image'] = $path;
        }

        $room->update($data);
        return Redirect::route('rooms.index');
    }

    public function destroy(Room $room)
    {
        // 1. Xóa ảnh trong kho trước
        if ($room->image) {
            Storage::disk('public')->delete($room->image);
        }

        // 2. Xóa dữ liệu phòng trong Database
        $room->delete();

        // 3. LOGIC XỊN: Nếu tổng số phòng bây giờ = 0 (tức là đã xóa sạch bách)
        // thì ép cơ sở dữ liệu reset bộ đếm ID về lại 1
        if (Room::count() == 0) {
            DB::statement('ALTER TABLE rooms AUTO_INCREMENT = 1');
        }

        return Redirect::back();
    }
}

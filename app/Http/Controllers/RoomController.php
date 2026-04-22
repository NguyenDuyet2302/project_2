<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

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
            $data['image'] = $request->file('image')->store('Images', 'public');
        }
        Room::create($data);
        return Redirect::route('rooms.index');
    }

    public function edit(Room $room)
    {
        return view('rooms.edit', compact('room'));
    }

    // Trong RoomController.php

    public function update(Request $request, Room $room)
    {
        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($room->image) {
                Storage::disk('public')->delete($this->normalizeImagePath($room->image));
            }
            $data['image'] = $request->file('image')->store('Images', 'public');
        }

        $room->update($data);
        return Redirect::route('rooms.index');
    }

    public function destroy(Room $room)
    {
        if ($room->image) {
            Storage::disk('public')->delete($this->normalizeImagePath($room->image));
        }
        $room->delete();
        if (Room::count() == 0) {
            DB::statement('ALTER TABLE rooms AUTO_INCREMENT = 1');
        }
        return Redirect::back();
    }

    private function normalizeImagePath(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        $path = str_replace('\\', '/', $path);
        $path = preg_replace('#^(?:/?storage/)+#', '', $path);

        return preg_replace('#^(Images/)+#', 'Images/', ltrim($path, '/'));
    }
}

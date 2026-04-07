<?php

namespace App\Http\Controllers;

use App\Models\ServiceDetail;
use App\Models\Room;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ServiceDetailController extends Controller
{
    public function index()
    {
        $serviceDetails = ServiceDetail::all();
        return view('serviceDetails.index', compact('serviceDetails'));
    }

    public function create()
    {
        $rooms = Room::all();
        $services = Service::all();
        return view('serviceDetails.create', compact('rooms', 'services'));
    }

    public function store(Request $request)
    {
        if ($request->has('service_id')) {
            foreach ($request->service_id as $key => $val) {
                if ($request->new_index[$key] !== null) {
                    ServiceDetail::create([
                        'room_id'      => $request->room_id,
                        'service_id'   => $request->service_id[$key],
                        'new_index'    => $request->new_index[$key],
                        'old_index'    => 0,
                        'reading_date' => now(),
                    ]);
                }
            }
        }
        return redirect()->route('serviceDetails.index');
    }

    // Truyền 2 ID để tìm kiếm
    public function edit($room_id, $service_id)
    {
        $serviceDetail = ServiceDetail::where('room_id', $room_id)
            ->where('service_id', $service_id)
            ->firstOrFail();

        $rooms = Room::all();
        $services = Service::all();

        return view('serviceDetails.edit', compact('serviceDetail', 'rooms', 'services'));
    }

    public function update(Request $request, $room_id, $service_id)
    {
        $detail = ServiceDetail::where('room_id', $room_id)
            ->where('service_id', $service_id)
            ->firstOrFail();
        ServiceDetail::where('room_id', $room_id)
            ->where('service_id', $service_id)
            ->update([
                'old_index'    => $request->old_index ?? $detail->old_index,
                'new_index'    => $request->new_index ?? $detail->new_index,
                'reading_date' => $request->reading_date ?? now(),
            ]);

        return redirect()->route('serviceDetails.index');
    }

    public function destroy($room_id, $service_id)
    {
        ServiceDetail::where('room_id', $room_id)
            ->where('service_id', $service_id)
            ->delete();

        return Redirect::route('serviceDetails.index');
    }
}

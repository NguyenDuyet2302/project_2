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
        ServiceDetail::create($request->all());
        return Redirect::route('serviceDetails.index');
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
        ServiceDetail::where('room_id', $room_id)
            ->where('service_id', $service_id)
            ->update([
                'old_index' => $request->old_index,
                'new_index' => $request->new_index,
                'reading_date' => $request->reading_date,
            ]);

        return Redirect::route('serviceDetails.index');
    }

    public function destroy($room_id, $service_id)
    {
        ServiceDetail::where('room_id', $room_id)
            ->where('service_id', $service_id)
            ->delete();

        return Redirect::route('serviceDetails.index');
    }
}

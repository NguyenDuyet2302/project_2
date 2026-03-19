<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Service;
use App\Models\ServiceDetail;
use App\Http\Requests\StoreServiceDetailRequest;
use App\Http\Requests\UpdateServiceDetailRequest;

class ServiceDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $serviceDetails = ServiceDetail::all();
        return view('serviceDetails.index', ['serviceDetails' => $serviceDetails]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $services = Service::all();
        $rooms = Room::all();
        $serviceDetail = new ServiceDetail();
        return view('serviceDetails.create', ['serviceDetail' => $serviceDetail, 'services' => $services, 'rooms' => $rooms]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceDetailRequest $request)
    {
        //
        ServiceDetail::create($request->all());
        return Redirect()->route('serviceDetails.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceDetail $serviceDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($service_id, $room_id)
    {
        $serviceDetail = ServiceDetail::where('service_id', $service_id)
            ->where('room_id', $room_id)
            ->firstOrFail();

        $services = Service::all();
        $rooms = Room::all();
        return view('serviceDetails.edit', ['serviceDetail' => $serviceDetail, 'services' => $services, 'rooms' => $rooms]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceDetailRequest $request, $service_id, $room_id)
    {
        ServiceDetail::where('service_id', $service_id)
            ->where('room_id', $room_id)
            ->update([
                'service_id' => $request->service_id,
                'room_id'    => $request->room_id,
                'old_index'  => $request->old_index,
                'new_index'  => $request->new_index,
            ]);

        return Redirect()->route('serviceDetails.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($service_id, $room_id)
    {
        ServiceDetail::where('service_id', $service_id)
            ->where('room_id', $room_id)
            ->delete();

        return Redirect()->route('serviceDetails.index');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Http\Requests\StoreContractRequest;
use App\Http\Requests\UpdateContractRequest;
use App\Models\Room;
use App\Models\User;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $contracts = Contract::all();
        return view('contracts.index', ['contracts' => $contracts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $contracts = Contract::all();
        $users = User::all();
        $rooms = Room::all();
        return view('contracts.create', ['contracts' => $contracts, 'users' => $users, 'rooms' => $rooms]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContractRequest $request)
    {
        //
        Contract::create($request->all());
        return Redirect()->route('contracts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contract $contract)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contract $contract)
    {
        //
        $rooms = Room::all();
        $users = User::all();
        return view('contracts.edit', ['contract' => $contract, 'rooms' => $rooms, 'users' => $users]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContractRequest $request, Contract $contract)
    {
        //
        $contract->update($request->all());
        return Redirect()->route('contracts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contract $contract)
    {
        //
        $contract->delete();
        return Redirect()->route('contracts.index');
    }
}

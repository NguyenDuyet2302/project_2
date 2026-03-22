<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Http\Requests\StoreInvoiceDetailRequest;
use App\Http\Requests\UpdateInvoiceDetailRequest;
use App\Models\Service;
use Illuminate\Support\Facades\Redirect;

class InvoiceDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $invoiceDetails = InvoiceDetail::all();
        return view('invoiceDetails.index', ['invoiceDetails' => $invoiceDetails]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $services = Service::all();
        $invoices = Invoice::all();
        $invoiceDetail = new InvoiceDetail();
        return view('invoiceDetails.create', ['services' => $services, 'invoiceDetail' => $invoiceDetail, 'invoices' => $invoices]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceDetailRequest $request)
    {
        //
        InvoiceDetail::create($request->all());
        return Redirect::route('invoiceDetails.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(InvoiceDetail $invoiceDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($service_id, $invoice_id)
    {
        //
        $invoiceDetail = InvoiceDetail::where('service_id', $service_id)
        ->where('invoice_id', $invoice_id)
        ->firstOrFail();
        $services = Service::all();
        $invoices = Invoice::all();
        return view('invoiceDetails.edit', ['invoiceDetail' => $invoiceDetail, 'services' => $services, 'invoices' => $invoices]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceDetailRequest $request, $service_id, $invoice_id)
    {
        //
        InvoiceDetail::where('service_id', $service_id)
            ->where('invoice_id', $invoice_id)
            ->update([
                'service_id' => $request->service_id,
                'invoice_id' => $request->invoice_id,
                'old_index' => $request->old_index,
                'new_index' => $request->new_index,
                'quantity' => $request->quantity,
                'amount' => $request->amount,
                'price' => $request->price,
            ]);
        return Redirect::route('invoiceDetails.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($service_id, $invoice_id)
    {
        //
        InvoiceDetail::where('service_id', $service_id)
            ->where('invoice_id', $invoice_id)
            ->delete();
        return Redirect::route('invoiceDetails.index');
    }
}

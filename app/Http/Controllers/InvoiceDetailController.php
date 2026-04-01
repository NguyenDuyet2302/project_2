<?php

namespace App\Http\Controllers;

use App\Models\InvoiceDetail;
use App\Models\Service;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class InvoiceDetailController extends Controller
{
    public function index()
    {
        $invoiceDetails = InvoiceDetail::all();
        return view('invoiceDetails.index', compact('invoiceDetails'));
    }

    public function create()
    {
        $services = Service::all();
        $invoices = Invoice::all();
        return view('invoiceDetails.create', compact('services', 'invoices'));
    }

    public function store(Request $request)
    {
        InvoiceDetail::create($request->all());
        return Redirect::route('invoiceDetails.index');
    }

    // THAY ĐỔI LỚN BẮT ĐẦU TỪ ĐÂY: Truyền 2 ID thay vì truyền Model
    public function edit($service_id, $invoice_id)
    {
        // Tìm bản ghi dựa trên 2 khóa ngoại
        $invoiceDetail = InvoiceDetail::where('service_id', $service_id)
            ->where('invoice_id', $invoice_id)
            ->firstOrFail();

        $services = Service::all();
        $invoices = Invoice::all();

        return view('invoiceDetails.edit', compact('invoiceDetail', 'services', 'invoices'));
    }

    public function update(Request $request, $service_id, $invoice_id)
    {
        // Tìm và cập nhật
        InvoiceDetail::where('service_id', $service_id)
            ->where('invoice_id', $invoice_id)
            ->update([
                'quantity' => $request->quantity,
                'price' => $request->price,
                'amount' => $request->amount,
                'old_index' => $request->old_index,
                'new_index' => $request->new_index,
            ]);

        return Redirect::route('invoiceDetails.index');
    }

    public function destroy($service_id, $invoice_id)
    {
        InvoiceDetail::where('service_id', $service_id)
            ->where('invoice_id', $invoice_id)
            ->delete();

        return Redirect::route('invoiceDetails.index');
    }
}

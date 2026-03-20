<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Redirect;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $payments = Payment::all();
        return view('payments.index', ['payments' => $payments]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $invoices = Invoice::all();
        $payments = Payment::all();
        $paymentMethods = PaymentMethod::all();
        return view('payments.create', ['invoices' => $invoices, 'payments' => $payments, 'paymentMethods' => $paymentMethods]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request)
    {
        //
        $data = $request->all();
        $data['payment_date'] = now();
        Payment::create($data);
        return Redirect::route('payments.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
        $invoices = Invoice::all();
        $paymentMethods = PaymentMethod::all();
        return view('payments.edit', ['payment' => $payment, 'invoice' => $invoices, 'paymentMethods' => $paymentMethods]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        //
        $payment->update($request->all());
        return Redirect::route('payments.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
        $payment->delete();
        return Redirect::route('payments.index');
    }
}

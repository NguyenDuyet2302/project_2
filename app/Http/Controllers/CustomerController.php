<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Contract;
use App\Models\ServiceDetail;
use App\Models\Room;
use App\Models\Invoice; // Đảm bảo đã import Model Invoice

class CustomerController extends Controller
{
    public function index()
    {
        $rooms = Room::where('status', 0)->get();

        return view('customer.home', [
            'customer' => Auth::user(),
            'contract' => null,
            'serviceUsage' => collect(),
            'rooms' => $rooms
        ]);
    }

    public function dashboard() {
        $user = Auth::user();
        $contract = Contract::where('user_id', $user->id)->with('room')->first();
        $invoices = collect();

        if ($contract) {
            // QUAN TRỌNG: Phải nạp invoiceDetails VÀ service
            $invoices = Invoice::where('contract_id', $contract->id)
                ->with(['contract.room', 'invoiceDetails.service'])
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('customer.home', compact('contract', 'invoices'))
            ->with('customer', $user);
    }

    public function profile()
    {
        return view('customer.profile');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'fullname' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'nullable|string|max:255',
        ]);

        $user->update([
            'fullname' => $request->fullname,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('home')->with('success', 'Thông tin đã được cập nhật!');
    }

    public function viewContract() {
        $customer = Auth::user();
    $contract = Contract::where('user_id', $customer->id)->with('room')->first();
    return view('customer.contract', compact('contract', 'customer'));
}

    public function viewInvoices() {
        $customer = Auth::user();
    $contract = Contract::where('user_id', $customer->id)->first();

    $invoices = collect();
    if ($contract) {
        $invoices = Invoice::where('contract_id', $contract->id)
            ->with(['contract.room', 'invoiceDetails.service'])
            ->orderBy('created_at', 'desc')
            ->get();
    }
    return view('customer.invoices', compact('invoices', 'customer'));
}
}

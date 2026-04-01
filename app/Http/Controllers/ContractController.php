<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\User;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\ServiceDetail;

class ContractController extends Controller
{
    public function index()
    {
        $contracts = Contract::with(['user', 'room'])
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('contracts.index', compact('contracts'));
    }

    public function create()
    {
        $users = User::all();

        // Lấy danh sách phòng và dùng hàm map() để xử lý đính kèm dữ liệu cho từng phòng
        $rooms = Room::all()->map(function ($room) {

            // 1. Tìm hợp đồng cũ nhất của phòng này (status = 0 là đã kết thúc)
            $lastContract = Contract::where('room_id', $room->id)
                ->where('status', 0)
                ->latest('end_date') // Lấy cái gần đây nhất
                ->first();

            // Set giá trị mặc định nếu phòng mới toanh, chưa từng ai thuê
            $room->old_electric = 0;
            $room->old_water = 0;
            $room->last_end_date = null;

            if ($lastContract) {
                $room->last_end_date = $lastContract->end_date;

                // 2. Tìm hóa đơn cuối cùng của hợp đồng đó
                $lastInvoice = Invoice::where('contract_id', $lastContract->id)
                    ->latest('created_at')
                    ->first();

                if ($lastInvoice) {
                    // 3. Lấy new_index từ InvoiceDetail
                    // LƯU Ý: Giả sử service_id = 1 là Điện, service_id = 2 là Nước.
                    // (Bạn cần kiểm tra lại bảng `services` xem ID Điện/Nước của bạn là bao nhiêu để thay vào số 1 và 2 nhé!)
                    $electricDetail = InvoiceDetail::where('invoice_id', $lastInvoice->id)
                        ->where('service_id', 1)->first();

                    $waterDetail = InvoiceDetail::where('invoice_id', $lastInvoice->id)
                        ->where('service_id', 2)->first();

                    // Gắn kết quả vào biến $room để mang sang View
                    $room->old_electric = $electricDetail ? $electricDetail->new_index : 0;
                    $room->old_water = $waterDetail ? $waterDetail->new_index : 0;
                }
            }
            return $room;
        });

        return view('contracts.create', compact('users', 'rooms'));
    }

    public function store(Request $request)
    {
        // 1. Lưu hợp đồng vào bảng contracts
        Contract::create($request->all());

        // 2. Cập nhật trạng thái phòng thành Đã thuê
        $room = Room::find($request->room_id);
        if ($room) {
            $room->update(['status' => 2]);
        }

        // 3. Lưu số điện và nước bắt đầu vào bảng service_details
        // LƯU Ý: Mình đang giả sử service_id = 1 là Điện, service_id = 2 là Nước.
        // (Bạn nhớ check lại bảng `services` xem ID Điện/Nước có đúng là 1 và 2 không nhé)

        if ($request->has('start_electricity')) {
            ServiceDetail::create([
                'room_id' => $request->room_id,
                'service_id' => 1, // ID của dịch vụ Điện
                'old_index' => 0,
                'new_index' => $request->start_electricity,
                'reading_date' => $request->start_date // Lấy luôn ngày bắt đầu thuê làm ngày chốt số
            ]);
        }

        if ($request->has('start_water')) {
            ServiceDetail::create([
                'room_id' => $request->room_id,
                'service_id' => 2, // ID của dịch vụ Nước
                'old_index' => 0,
                'new_index' => $request->start_water,
                'reading_date' => $request->start_date
            ]);
        }

        return Redirect::route('contracts.index');
    }

    public function edit(Contract $contract)
    {
        $users = User::where('role', 0)->get();
        $rooms = Room::where('status', 1)
            ->orWhere('id', $contract->room_id)
            ->get();
        return view('contracts.edit', compact('contract', 'users', 'rooms'));
    }

    public function update(Request $request, Contract $contract)
    {
        if ($contract->room_id != $request->room_id) {
            Room::where('id', $contract->room_id)->update(['status' => 1]);
            Room::where('id', $request->room_id)->update(['status' => 2]);
        }

        $contract->update($request->all());
        return Redirect::route('contracts.index');
    }

    public function destroy(Contract $contract)
    {
        $room = Room::find($contract->room_id);
        if ($room) {
            $room->update(['status' => 1]);
        }

        $contract->delete();

        if (Contract::count() == 0) {
            DB::statement('ALTER TABLE contracts AUTO_INCREMENT = 1');
        }

        return Redirect::route('contracts.index');
    }
}

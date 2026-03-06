<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\User;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class ContractController extends Controller
{
    /**
     * SỬA LỖI: Thay get() bằng paginate(10) để chạy được phân trang
     */
    public function index()
    {
        // Lấy danh sách hợp đồng, kèm theo thông tin khách và phòng
        // Sắp xếp theo ID giảm dần (mới nhất lên đầu) và phân 10 bản ghi/trang
        $contracts = Contract::with(['user', 'room'])
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('contracts.index', compact('contracts'));
    }

    public function create()
    {
        // Lấy khách thuê (role = 0)
        $users = User::where('role', 0)->get();

        // CHỈ lấy những phòng có status = 1 (Số 1 là "Còn Trống")
        $rooms = Room::where('status', 1)->get();

        return view('contracts.create', compact('users', 'rooms'));
    }

    public function store(Request $request)
    {
        // Lưu hợp đồng mới
        Contract::create($request->all());

        // Cập nhật status phòng sang 2 (Số 2 là "Đã thuê/Hết")
        $room = Room::find($request->room_id);
        if ($room) {
            $room->update(['status' => 2]);
        }

        return Redirect::route('contracts.index');
    }

    public function edit(Contract $contract)
    {
        $users = User::where('role', 0)->get();

        // Logic: Hiện phòng hiện tại của hợp đồng + các phòng đang trống khác
        $rooms = Room::where('status', 1)
            ->orWhere('id', $contract->room_id)
            ->get();

        return view('contracts.edit', compact('contract', 'users', 'rooms'));
    }

    public function update(Request $request, Contract $contract)
    {
        // Nếu thay đổi phòng trong hợp đồng
        if ($contract->room_id != $request->room_id) {
            // Trả phòng cũ về status 1 (Trống)
            Room::where('id', $contract->room_id)->update(['status' => 1]);
            // Chuyển phòng mới sang status 2 (Hết)
            Room::where('id', $request->room_id)->update(['status' => 2]);
        }

        $contract->update($request->all());
        return Redirect::route('contracts.index');
    }

    public function destroy(Contract $contract)
    {
        // Khi xóa hợp đồng, tự động trả phòng về status 1 (Trống) để khách khác thuê
        $room = Room::find($contract->room_id);
        if ($room) {
            $room->update(['status' => 1]);
        }

        $contract->delete();

        // Reset ID nếu không còn hợp đồng nào (cho sạch database)
        if (Contract::count() == 0) {
            DB::statement('ALTER TABLE contracts AUTO_INCREMENT = 1');
        }

        return Redirect::route('contracts.index');
    }
}

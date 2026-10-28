<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $status = $request->get('status');

        $orders = Order::where('MaTaiKhoan', $user->MaTaiKhoan)
            ->when($status, function ($q) use ($status) {
                $q->where('TrangThai', $status);
            })
            ->orderBy('NgayTao', 'desc')
            ->paginate(5); // PHÂN TRANG

        return view('client.profile.index', compact('user', 'orders', 'status'));
    }
}

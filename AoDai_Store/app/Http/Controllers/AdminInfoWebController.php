<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InfoWeb;
class AdminInfoWebController extends Controller
{
    public function index()
    {
        $infoWeb = InfoWeb::first(); // luôn là dòng đầu
        return view('admin.dashboard', compact('infoWeb'));
    }

    public function update(Request $request)
    {
        $infoWeb = InfoWeb::first();

        $infoWeb->update([
            'DiaChiShop' => $request->DiaChiShop,
            'Email' => $request->Email,
            'SoDienThoai' => $request->SoDienThoai,
            'GioMoCua' => $request->GioMoCua,
        ]);

        return back()->with('success', 'Cập nhật thành công');
    }
}

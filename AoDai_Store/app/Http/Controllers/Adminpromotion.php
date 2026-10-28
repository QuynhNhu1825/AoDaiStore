<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;

class Adminpromotion extends Controller
{
    //
    public function index(Request $request) {
    $search = $request->input('search');
    $type = $request->input('loai_giam');
    $status = $request->input('status');

    $promotions = Promotion::query()
        ->when($request->filled('status'), function($query) use ($status) {
            return $query->where('TrangThai', $status);
        })
        
        ->when($request->filled('loai_giam'), function ($query, $type) {
            return $query->where('LoaiGiam', $type);
        })
        ->when($search, function ($query, $search) {
            return $query->where('TenKhuyenMai', 'like', "%{$search}%");
        })
        ->paginate(10)
        ->withQueryString(); // Giữ các tham số search/type/status trên thanh URL khi bấm sang trang 2, 3

    return view('admin.promotions.index', compact('promotions'));
    }
    public function create(){
        return view('admin.promotions.create');
    }
    public function edit($id){
        $promotion = Promotion::findOrFail($id);
        return view('admin.promotions.edit', compact('promotion'));
    }
    public function store(Request $request){
        $data=$request->validate([
            'TenKhuyenMai' => 'required|string|max:255',
            'LoaiGiam' => 'required',
            'GiamToiDa' => 'nullable|numeric',
            'GiaTriGiam' => 'required|numeric',
            'Dieukienkhuyenmai' => 'nullable',
            'SoLuong' => 'required|integer',
            'NgayBatDau' => 'required|date',
            'NgayKetThuc' => 'required|date|after_or_equal:NgayBatDau',
            'TrangThai' => 'required|boolean',
        ]);
        Promotion::create($data);


        return redirect()->route('promotions.index');
    }
   // Trong file PromotionController.php
        public function update(Request $request, $id) {
            $promotion = Promotion::findOrFail($id);
            
            $data = $request->validate([
                'TenKhuyenMai' => 'required|string|max:255',
                'LoaiGiam' => 'required|in:0,1', // Chỉ cho phép 0 hoặc 1
                'GiamToiDa' => 'nullable|numeric|min:0',
                'GiaTriGiam' => 'required|numeric|min:0',
                'Dieukienkhuyenmai' => 'nullable|min:0',
                'SoLuong' => 'required|integer|min:0',
                'NgayBatDau' => 'required|date',
                'NgayKetThuc' => 'required|date|after_or_equal:NgayBatDau',
            ]);

            // Logic bổ sung: Nếu là giảm tiền mặt (0), nên xóa giá trị Giảm tối đa về 0 hoặc null
            if ($data['LoaiGiam'] == 0) {
                $data['GiamToiDa'] = null;
            }

            $promotion->update($data);

            return redirect()
                ->route('promotions.index')
                ->with('success', 'Cập nhật chương trình khuyến mãi thành công');
        }
    public function destroy($id){
        $promotion = Promotion::findOrFail($id);
        $promotion->update(['TrangThai' => 0]);
        return redirect()->route('promotions.index');
    }
    public function show($id){
        $promotion = Promotion::findOrFail($id);
        return view('admin.promotions.show', compact('promotion'));
    }
    public function restore($id){
        $promotion = Promotion::findOrFail($id);
        $promotion->update(['TrangThai' => 1]);
        return redirect()->route('admin.promotions.index');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Product;
class AdminSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = Supplier::where('TrangThai', 1); 

    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('TenNCC', 'like', "%$search%")
              ->orWhere('SDT', 'like', "%$search%")
              ->orWhere('Email', 'like', "%$search%");
        });
    }

     $suppliers = $query->orderBy('MaNCC', 'desc')
                       ->paginate(10)
                       ->withQueryString();
    $totalSuppliers = Supplier::where('TrangThai', 1)->count();

    return view('admin.suppliers.index', compact('suppliers', 'totalSuppliers'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.suppliers.create');
    }

    public function store(Request $request)
    {
    $request->validate([
        'TenNCC' => 'required|string|max:255',
        'SDT'    => 'nullable|string|max:20',
        'Email'  => 'nullable|email|max:255',
        'DiaChi' => 'nullable|string',
    ]);

    Supplier::create([
        'TenNCC' => $request->TenNCC,
        'SDT'    => $request->SDT,
        'Email'  => $request->Email,
        'DiaChi' => $request->DiaChi,
    ]);

    return redirect()
        ->route('admin.suppliers.index')
        ->with('success', 'Thêm nhà cung cấp thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
    $supplier = Supplier::findOrFail($id);

    return view('admin.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'TenNCC'    => 'required|string|max:255',
        'SDT'       => 'nullable|string|max:20',
        'Email'     => 'nullable|email|max:255',
        'DiaChi'    => 'nullable|string',
        'TrangThai' => 'required|in:0,1',
    ]);

    $supplier = Supplier::findOrFail($id);

    $supplier->update([
        'TenNCC'    => $request->TenNCC,
        'SDT'       => $request->SDT,
        'Email'     => $request->Email,
        'DiaChi'    => $request->DiaChi,
        'TrangThai' => $request->TrangThai,
    ]);

    return redirect()
        ->route('admin.suppliers.index')
        ->with('success', 'Cập nhật nhà cung cấp thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $supplier = Supplier::findOrFail($id);
    $supplier->update([
        'TrangThai' => 0
    ]);

    // Ẩn toàn bộ sản phẩm của NCC này
    Product::where('MaNCC', $id)
           ->update(['TrangThai' => 0]);

    return redirect()
        ->route('admin.suppliers.index')
        ->with('success', 'Đã ngưng hợp tác và ẩn toàn bộ sản phẩm của nhà cung cấp!');
}

}

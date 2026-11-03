<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\ProductDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Thêm sản phẩm vào giỏ hàng thành viên.
     * Khách vãng lai sử dụng Local Storage ở frontend.
     */
    public function addToCart(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng sử dụng Local Storage cho giỏ hàng khách vãng lai.'
            ], 401);
        }

        $request->validate([
            'SoLuong' => 'nullable|integer|min:1',
        ]);

        $quantity = (int) $request->input('SoLuong', 1);

        $productDetail = ProductDetail::where('MaChiTietSP', $id)->first();

        if (!$productDetail) {
            return back()->with('error', 'Chi tiết sản phẩm không tồn tại!');
        }

        $cartItem = Cart::where('MaTaiKhoan', Auth::id())
            ->where('MaChiTietSP', $id)
            ->first();

        if ($cartItem) {
            $cartItem->SoLuong += $quantity;
            $cartItem->save();
        } else {
            Cart::create([
                'MaTaiKhoan' => Auth::id(),
                'MaChiTietSP' => $id,
                'SoLuong' => $quantity,
                'NgayThem' => now(),
            ]);
        }

        return back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
    }

    /**
     * Đồng bộ giỏ hàng Local Storage vào database sau đăng nhập.
     */
    public function mergeCartAfterLogin(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn chưa đăng nhập!'
            ], 401);
        }

        $request->validate([
            'items' => 'required|array',
            'items.*.MaChiTietSP' => 'required|integer',
            'items.*.SoLuong' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {

            foreach ($request->items as $item) {

                $detailId = $item['MaChiTietSP'];
                $quantity = $item['SoLuong'];

                // Kiểm tra biến thể sản phẩm tồn tại
                $productDetail= ProductDetail::where(
                    'MaChiTietSP',
                    $detailId
                )->first();

                if (!$productDetail) {
                    continue;
                }

                // Kiểm tra sản phẩm đã có trong giỏ hàng tài khoản
                $existing = Cart::where('MaTaiKhoan', Auth::id())
                    ->where('MaChiTietSP', $detailId)
                    ->first();

                if ($existing) {

                    // Đã tồn tại thì cộng số lượng
                    $existing->SoLuong += $quantity;
                    $existing->save();

                } else {

                    // Chưa tồn tại thì thêm mới
                    Cart::create([
                        'MaTaiKhoan' => Auth::id(),
                        'MaChiTietSP' => $detailId,
                        'SoLuong' => $quantity,
                        'NgayThem' => now(),
                    ]);
                }
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Đồng bộ giỏ hàng thành công!'
        ]);
    }

    /**
     * Cập nhật số lượng sản phẩm trong giỏ hàng thành viên.
     */
    public function updateQuantity(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập!'
            ], 401);
        }

        $request->validate([
            'id' => 'required|integer',
            'type' => 'required|in:increase,decrease',
        ]);

        $item = Cart::where('MaGioHang', $request->id)
            ->where('MaTaiKhoan', Auth::id())
            ->first();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy sản phẩm trong giỏ hàng!'
            ], 404);
        }

        if ($request->type === 'increase') {
            $item->SoLuong += 1;
        } else {
            if ($item->SoLuong > 1) {
                $item->SoLuong -= 1;
            }
        }

        $item->save();

        return response()->json([
            'success' => true,
            'new_qty' => $item->SoLuong,
        ]);
    }

    /**
     * Xóa một sản phẩm khỏi giỏ hàng thành viên.
     */
    public function removeFromCart($id)
    {
        if (!Auth::check()) {
            return back()->with('error', 'Vui lòng đăng nhập!');
        }

        Cart::where('MaGioHang', $id)
            ->where('MaTaiKhoan', Auth::id())
            ->delete();

        return back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    }

    /**
     * Xóa toàn bộ giỏ hàng thành viên.
     */
    public function clearCart()
    {
        if (!Auth::check()) {
            return back()->with('error', 'Vui lòng đăng nhập!');
        }

        Cart::where('MaTaiKhoan', Auth::id())->delete();

        return back()->with('success', 'Giỏ hàng đã được làm trống!');
    }

    /**
     * Hiển thị giỏ hàng.
     * Thành viên: lấy từ database.
     * Khách vãng lai: frontend đọc Local Storage.
     */
    public function viewCart()
{
    if (Auth::check()) {
        $cartItems = Cart::with([
            'productDetail.product.chatlieu',
            'productDetail.product.hinhanhsanpham',
            'productDetail.color',
            'productDetail.size',
        ])
        ->where('MaTaiKhoan', Auth::id())
        ->paginate(10);

        $totalPrice = $cartItems->sum(function ($item) {
            return $item->productDetail->product->GiaBan * $item->SoLuong;
        });

    } else {
        $cartItems = collect();
        $totalPrice = 0;
    }

    return view('client.cart.index', compact(
        'cartItems',
        'totalPrice'
    ));
}

    /**
     * Checkout dành cho thành viên.
     */
    public function checkout()
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Vui lòng đăng nhập để thanh toán!');
        }

        $cartItems = Cart::with('productDetail')
            ->where('MaTaiKhoan', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        // Thông tin tài khoản đăng nhập
        $info = Auth::user();

        $addressData = [
            'soNha' => '',
            'phuongXa' => '',
            'quanHuyen' => '',
            'tinhThanh' => '',
        ];

        if ($info && $info->DiaChi) {
            $parts = explode(', ', $info->DiaChi);

            $addressData['soNha'] = $parts[0] ?? '';
            $addressData['phuongXa'] = $parts[1] ?? '';
            $addressData['quanHuyen'] = $parts[2] ?? '';
            $addressData['tinhThanh'] = $parts[3] ?? '';
        }

        return view('client.checkout.index', compact(
            'cartItems',
            'info',
            'addressData',
        ));
    }

    /**
     * Trang checkout thành công.
     */
    public function checkoutSuccess(Request $request)
    {
        $request->validate([
            'fullName' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
        ]);

        return view('client.checkout.success');
    }
}

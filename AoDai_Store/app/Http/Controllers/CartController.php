<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Psy\Readline\Hoa\Console;

class CartController extends Controller
{
    //


public function addToCart(Request $request, $id)
{
    $quantity = $request->input('SoLuong', 1);
    $size = $request->input('MaSize', null); // Lấy kích thước nếu có
    if (Auth::check()) {
        // Người dùng đã đăng nhập
        $cartItem = Cart::where('MaSanPham', $id)
            ->where('MaTaiKhoan', Auth::id())
                ->where('MaSize', $size)
            ->first();
        if ($cartItem) {
            // Cập nhật số lượng nếu sản phẩm đã có trong giỏ hàng
            $cartItem->SoLuong += $quantity;
            $cartItem->save();
        } else {
            // Thêm sản phẩm mới vào giỏ hàng
            Cart::create([
                'MaSanPham' => $id,
                'MaSize' => $size,
                'MaTaiKhoan' => Auth::id(),
                'SoLuong' => $quantity,
            ]);
        }
    } else {
        // Người dùng chưa đăng nhập, sử dụng SessionID
        $sessionId = session()->getId();
        $cartItem = Cart::where('MaSanPham', $id)
            ->where('SessionID', $sessionId)
                ->where('MaSize', $size)
            ->first();
        

        if ($cartItem) {
            // Cập nhật số lượng nếu sản phẩm đã có trong giỏ hàng
            $cartItem->increment('SoLuong', $quantity);


            // dd($cartItem);
        } else {
            // Thêm sản phẩm mới vào giỏ hàng
            Cart::create([
                'MaSanPham' => $id,
                'MaSize' => $size,
                'SessionID' => $sessionId,
                'SoLuong' => $quantity,
            ]);
        }
    }
    return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
}

   public function updateQuantity(Request $request)
{
    if(Auth::check()){
        $item = Cart::where('MaSanPham', $request->id)
            ->where('MaTaiKhoan', Auth::id())
            ->first();
    }
    else{
        $sessionId=session()->getId();
        $item = Cart::where('MaSanPham', $request->id)
            ->where('SessionID', $sessionId)
            ->first();
    }
    if (!$item) {
        return response()->json([
            'success' => false,
            'message' => 'Không tìm thấy sản phẩm trong giỏ hàng'
        ], 404);
    }
    if ($request->type == 'increase') {
        $item->SoLuong += 1;
    } else {
        if ($item->SoLuong > 1) {
            $item->SoLuong -= 1;
        }
    }
    
    $item->save();

    return response()->json([
        'success' => true,
        'new_qty' => $item->SoLuong
    ]);
}

    public function mergeCartAfterLogin($sessionId)
{
    
    $userId = Auth::id();

    $guestItems = Cart::where('SessionID', $sessionId)->get();

    foreach ($guestItems as $item) {
        $existing = Cart::where('MaTaiKhoan', $userId)
            ->where('MaSanPham', $item->MaSanPham)
            ->where('MaSize', $item->MaSize)
            ->first();

        if ($existing) {
            $existing->SoLuong += $item->SoLuong;
            $existing->save();

            $item->delete();
        } else {
            $item->MaTaiKhoan = $userId;
            $item->SessionID = null;
            $item->save();
        }
    }
}

    public function checkout()
    {
   
        
    if(Auth::check()){
        
        
        // Xóa các mục giỏ hàng từ session sau khi chuyển sang tài khoản
        Cart::where('SessionID', session()->getId())->delete();
        $cartItems = Cart::with('sanpham','size')
            ->where('MaTaiKhoan', Auth::id())->get();
        $promotions = Promotion::where('TrangThai', 1)
            ->where('NgayBatDau', '<=', now())
            ->where('NgayKetThuc', '>=', now())
            ->where('Soluong', '>', 0)
            ->get();
        
    } 

    $totalPrice = $cartItems->sum(function($item) {
        return $item->sanpham ? ($item->sanpham->GiaBan * $item->SoLuong) : 0;
    });

    // Xử lý tách địa chỉ
    $addressData = [
        'soNha' => '',
        'phuongXa' => '',
        'quanHuyen' => '',
        'tinhThanh' => ''
    ];
    $info = User::where('MaTaiKhoan',Auth::id())->first();
    if ($info && $info->DiaChi) {
        // Giả sử lưu dạng: "Số 123 Lê Lợi, Phường Hải Châu I, Quận Hải Châu, Đà Nẵng"
        $parts = explode(', ', $info->DiaChi);
        $addressData['soNha'] = $parts[0] ?? '';
        $addressData['phuongXa'] = $parts[1] ?? '';
        $addressData['quanHuyen'] = $parts[2] ?? '';
        $addressData['tinhThanh'] = $parts[3] ?? '';
    }

    return view('client.checkout.index', compact('cartItems', 'totalPrice', 'info', 'addressData', 'promotions'));
    }

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
    public function clearCart(){
        if(Auth::check()){
            Cart::where('MaTaiKhoan',Auth::id())->delete();
        }
        else{
            $sessionId=session()->getId();
            Cart::where('SessionID',$sessionId)->delete();
        }
        return redirect()->back()->with('success', 'Giỏ hàng đã được làm trống!');
    }
    public function removeFromCart($id,Request $request){
        $request->input('size_id');
        if(Auth::check()){
            Cart::where('MaSanpham',$id)
                ->where('MaTaiKhoan',Auth::id())
                    ->where('MaSize',$request->input('size_id'))
                ->delete();
        }
        else{
            $sessionId=session()->getId();
            Cart::where('MaSanPham',$id)
                ->where('SessionID',$sessionId)
                    ->where('MaSize',$request->input('size_id'))
                ->delete();
        }
        return redirect()->back()->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng!');
    }
    public function viewCart()
    {
        // Fetch cart items from database or session
        if(Auth::check()){

            $cartItems = Cart::with('sanpham','size')
            ->where('MaTaiKhoan', Auth::id())->paginate(5);
        }
        else{
            $sessionId=session()->getId();
            $cartItems=Cart::with('sanpham','size')->where('SessionID', $sessionId)->paginate(5);
        }
        $totalPrice = $cartItems->sum(function($item) {
        // Kiểm tra nếu sản phẩm tồn tại để tránh lỗi null
        return $item->sanpham ? ($item->sanpham->GiaBan * $item->SoLuong) : 0;
    });
        return view('client.cart.index', compact('cartItems', 'totalPrice'));
    }
}

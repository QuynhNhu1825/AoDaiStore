<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Cart extends Model
{
    //
    use HasFactory;
    protected $table = 'giohang';
    public $timestamps = false;
    protected $primaryKey = 'ID';
    protected $fillable = [
        'id',
        'MaSanPham',
        'MaTaiKhoan',
        'MaSize',
        'SessionID',
        'SoLuong'
    ];
    public function sanpham()
    {
        // Đảm bảo 'MaSanPham' (hoặc id) là tên cột thực tế trong DB của bạn
        return $this->belongsTo(Product::class, 'MaSanPham', 'MaSanPham'); 
    }
    public static function getCartQuantity()
    {
        if (Auth::check()) {
            // Trường hợp 1: Đã đăng nhập -> Lấy theo MaKH
            return self::where('MaTaiKhoan', auth()->id())->sum('SoLuong') ?? 0;
        }

        // Trường hợp 2: Chưa đăng nhập -> Lấy theo Session ID
        // Laravel tự động tạo một ID duy nhất cho mỗi trình duyệt khách truy cập
        $sessionId = session()->getId();
        return self::where('SessionID', $sessionId)
                ->whereNull('MaTaiKhoan') // Đảm bảo chỉ lấy giỏ hàng vãng lai
                ->sum('SoLuong') ?? 0;
    }
    public function size(){
        return $this->belongsTo(Size::class, 'MaSize', 'MaSize');
    }
}

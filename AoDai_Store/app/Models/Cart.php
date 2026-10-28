<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'giohang';

    protected $primaryKey = 'MaGioHang';

    public $timestamps = false;

    protected $fillable = [
        'MaTaiKhoan',
        'MaBienThe',
        'SoLuong',
        'NgayThem',
    ];

    protected $casts = [
        'SoLuong' => 'integer',
        'NgayThem' => 'datetime',
    ];

    /**
     * Một mục giỏ hàng thuộc về một biến thể sản phẩm.
     */
    public function productVariant()
    {
        return $this->belongsTo(
            ProductVariant::class,
            'MaBienThe',
            'MaBienThe'
        );
    }

    /**
     * Một mục giỏ hàng thuộc về một tài khoản.
     */
    public function user()
    {
        return $this->belongsTo(
            User::class,
            'MaTaiKhoan',
            'id'
        );
    }

    /**
     * Lấy tổng số lượng sản phẩm trong giỏ hàng.
     */
    public static function getCartQuantity()
    {
        if (Auth::check()) {
            return self::where(
                'MaTaiKhoan',
                Auth::id()
            )->sum('SoLuong');
        }

        return 0;
    }
}

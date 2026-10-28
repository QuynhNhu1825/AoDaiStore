<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    //
    protected $table = 'chitiethoadon';
      public $incrementing = false;   
    public $timestamps = false;

  
    protected $primaryKey = null;
    protected $fillable = [
        'MaHoaDon',
        'MaSanPham',
        'SoLuong',
        'DonGia',
        'ThanhTien'
    ];
    public function product()
    {
        // Mỗi chi tiết hóa đơn thuộc về một Sản phẩm
        return $this->belongsTo(Product::class, 'MaSanPham', 'MaSanPham');
    }

    public function order()
    {
        // Mỗi chi tiết hóa đơn thuộc về một Hóa đơn
        return $this->belongsTo(Order::class, 'MaHoaDon', 'MaHoaDon');
    }

}

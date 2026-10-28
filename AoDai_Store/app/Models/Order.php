<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    use HasFactory;
    protected $table = 'hoadon';
    protected $primaryKey = 'MaHoaDon';
    const CREATED_AT = 'NgayTao';
    const UPDATED_AT = 'NgayCapNhat';
    protected $fillable = [
        'MaTaiKhoan',
        'NgayDatHang',
        'TenNguoiNhan',
        'SDTNguoiNhan',
        'TienHang',
        'PhiVanChuyen',
        'GiamGia',
        'MaKhuyenMai',
        'TongTien',
        'TrangThai',
        'DiaChiGiaoHang',
        'Ghichu',
        'PhuongThucThanhToan'
    ];
    public function getTrangThaiTextAttribute()
    {
        return match ($this->TrangThai) {
            'ChoXacNhan' => 'Chờ xác nhận',
            'DangGiao' => 'Đang giao',
            'DaHuy' => 'Đã hủy',
            'DaXacNhan' => 'Đã xác nhận',
            'DaGiao' => 'Đã giao',
            default => $this->TrangThai,
        };
    }

}

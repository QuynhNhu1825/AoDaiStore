<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Account extends Authenticatable
{
    protected $table = 'taikhoan';
    protected $primaryKey = 'MaTaiKhoan';
    public $timestamps = false;

    protected $fillable = [
        'TenDangNhap',
        'MatKhau',
        'HoTen',
        'Email',
        'SoDienThoai',
        'DiaChi',
        'Role',
        'TrangThai',
        'CreatedDate',
    ];

     protected $casts = [
        'CreatedDate' => 'datetime',
    ];
    
    // Laravel mặc định dùng password → đổi sang MatKhau
    public function getAuthPassword()
    {
        return $this->MatKhau;
    }
}

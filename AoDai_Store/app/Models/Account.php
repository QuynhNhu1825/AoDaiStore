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
<<<<<<< Updated upstream
    
    // Laravel mặc định dùng password → đổi sang MatKhau
=======

    protected $casts = [
        'TrangThai' => 'boolean',
        'IsDeleted' => 'boolean',
        'NgayTao' => 'datetime',
        'NgayCapNhat' => 'datetime',
        'NgayXoa' => 'datetime',
    ];

    /**
     * Lấy mật khẩu dùng cho quá trình xác thực Laravel.
     */
>>>>>>> Stashed changes
    public function getAuthPassword()
    {
        return $this->MatKhau;
    }
<<<<<<< Updated upstream
}
=======

    /**
     * Tên cột chứa mật khẩu.
     */
    public function getAuthPasswordName()
    {
        return 'MatKhau';
    }

    /**
     * Một tài khoản có nhiều sản phẩm yêu thích.
     */
    public function favorites()
    {
        return $this->hasMany(
            Favorite::class,
            'MaTaiKhoan',
            'MaTaiKhoan'
        );
    }
}
>>>>>>> Stashed changes

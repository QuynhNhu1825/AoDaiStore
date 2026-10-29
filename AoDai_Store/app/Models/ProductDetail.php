<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;

    protected $table = 'bienthesp';

    protected $primaryKey = 'MaBienThe';

    public $timestamps = false;

    protected $fillable = [
        'MaSanPham',
        'MaMau',
        'MaSize',
        'Gia',
        'SoLuong',
        'NguoiTao',
        'NgayTao',
        'NguoiCapNhat',
        'NgayCapNhat',
        'NguoiXoa',
        'NgayXoa',
        'IsDeleted',
    ];

    protected $casts = [
        'Gia' => 'decimal:2',
        'SoLuong' => 'integer',
        'NgayTao' => 'datetime',
        'NgayCapNhat' => 'datetime',
        'NgayXoa' => 'datetime',
        'IsDeleted' => 'boolean',
    ];

    /**
     * Quan hệ với bảng sản phẩm.
     */
    public function sanPham()
    {
        return $this->belongsTo(
            Product::class,
            'MaSanPham',
            'MaSanPham'
        );
    }
}

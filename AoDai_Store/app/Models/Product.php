<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    use HasFactory;
    protected $table = 'sanpham';
    protected $primaryKey = 'MaSanPham';
    public $timestamps = false;
    public function chatlieu()
    {
        return $this->belongsTo(Material::class, 'MaChatLieu', 'MaChatLieu');
    }

    public function loaimau()
    {
        return $this->belongsTo(Color::class, 'MaLoaiMau', 'MaLoaiMau');
    }
    public function loaisanpham()
    {
        return $this->belongsTo(Category::class, 'MaLoaiSP', 'MaLoaiSP');
    }
    public function hinhanhsanpham()
    {
        return $this->hasMany(ProductImage::class, 'MaSanPham', 'MaSanPham');
    }

    public function sizes()
    {

        return $this->belongsToMany(Size::class, 'sanpham_size', 'MaSanPham', 'MaSize')
            ->withPivot('SoLuong');
    }
    public function nhacungcap()
    {
        return $this->belongsTo(Supplier::class, 'MaNCC', 'MaNCC');
    }
    public function getRelatedProducts($limit = 4)
    {
        return Product::where('MaSanPham', '<>', $this->MaSanPham) // Không lấy chính nó
            ->where(function($query) {
                $query->where('MaLoaiSP', $this->MaLoaiSP) // Ưu tiên cùng loại
                    ->orWhere('MaChatLieu', $this->MaChatLieu); // Hoặc cùng chất liệu
            })
            ->where('TrangThai', '1')
            ->inRandomOrder() // Hiển thị ngẫu nhiên để tăng sự đa dạng
            ->limit($limit)
            ->get();
    }
    protected $fillable = [
        'TenSanPham',
        'GiaBan',
        'MaLoaiSP',
        'MaChatLieu',
        'MaNCC',
        'MaLoaiMau',
        'MaSize',
        'SoLuong',
        'HinhAnh',
        'TrangThai',
        'CreatedDate',
        'MoTa',
    ];
}

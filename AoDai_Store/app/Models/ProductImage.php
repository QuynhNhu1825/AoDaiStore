<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $table = 'hinhanhsanpham';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'MaSanPham', 
        'TenHinh',
        'DuongDan'
       
    ];
    public function sanpham() {
        return $this->belongsTo(Product::class, 'MaSanPham', 'MaSanPham');
    }
}

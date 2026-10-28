<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    use HasFactory;
    protected $table = 'loaisanpham';
    protected $primaryKey = 'MaLoaiSP';
    public $timestamps = false;
    public function sanpham() {
        return $this->hasMany(Product::class, 'MaLoaiSP', 'MaLoaiSP');
    }
    protected $fillable = [
        'TenLoaiSP',
        'MoTa',
        'TrangThai',
        'CreatedDate',
    ];
    
}

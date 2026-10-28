<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    //
    use HasFactory;
    protected $table = 'size';
    public $timestamps = false;
    protected $primaryKey = 'MaSize';
    public function products()
    {
        return $this->belongsToMany( Product::class,'sanpham_size', 'MaSize', 'MaSanPham')
            ->withPivot('SoLuong');
    }

    protected $fillable = [
        'TenSize',
        'MoTa',
        'TrangThai'
    ];
}

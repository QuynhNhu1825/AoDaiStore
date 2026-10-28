<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    //
    use HasFactory;
    protected $table = 'khuyenmai';
    public $timestamps = false;
    protected $primaryKey = 'MaKhuyenMai';

    protected $fillable = [
        'TenKhuyenMai',
        'MaCode',
        'LoaiGiam',
        'GiamToiDa',
        'GiaTriGiam',
        'DieuKienKhuyenMai',
        'Soluong',
        'NgayBatDau',
        'NgayKetThuc',
        'TrangThai',
    ];
}

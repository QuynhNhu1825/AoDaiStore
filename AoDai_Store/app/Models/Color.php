<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    //
    use HasFactory;
    protected $table = 'loaimau';
    public $timestamps = false;
    protected $primaryKey = 'MaLoaiMau';
    protected $fillable = [
        'TenLoaiMau',
        'HinhAnhMau',
        'MoTa',
        'TrangThai',
    ];
    public function products()
    {
        return $this->hasMany(Product::class, 'MaLoaiMau', 'MaLoaiMau');
    }
}

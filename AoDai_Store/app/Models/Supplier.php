<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
     protected $table = 'nhacungcap';
    protected $primaryKey = 'MaNCC';
    public $timestamps = false;
    protected $fillable = [
        'TenNCC',
        'DiaChi',
        'SDT',
        'Email',
        'TrangThai'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'MaNCC', 'MaNCC');
    }
}

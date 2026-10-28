<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    //
    use HasFactory;
    protected $table = 'chatlieu';
    public $timestamps = false;
    protected $primaryKey = 'MaChatLieu';
    protected $fillable = [
        'TenChatLieu',
        'Xuatxu',
        'HuongDanBaoQuan',
        'TrangThai'
    ];
    public function products()
    {
        return $this->hasMany(Product::class, 'MaChatLieu', 'MaChatLieu');
    }
}

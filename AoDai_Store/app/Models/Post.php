<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'baiviet';
    protected $primaryKey = 'MaBaiViet';

    public $timestamps = false; 
    

    protected $fillable = [
        'TieuDe',
        'Slug',
        'NoiDung',
        'HinhAnh',
        'LoaiBaiViet',
        'TrangThai',
        'NgayTao',
        'NgayCapNhat'
    ];
}

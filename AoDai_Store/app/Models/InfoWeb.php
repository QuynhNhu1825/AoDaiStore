<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InfoWeb extends Model
{
    protected $table = 'infoweb'; 
    protected $primaryKey = 'MaInfoWeb';

    protected $fillable = [
        'DiaChiShop',
        'Email',
        'SoDienThoai',
        'GioMoCua'
    ];

    public $timestamps = false;
}

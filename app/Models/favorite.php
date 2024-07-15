<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class favorite extends Model
{
    use HasFactory;
    public  $table = 'favorite';
    protected $fillable =[
    'id_fav_product',
    'id_fav_user',
];
    protected $hidden = [
        'time'
    ];
    public $timestamps = false
    ;public  function products(){
    return $this->hasOne(products::class,'id','id_fav_product');
}
}

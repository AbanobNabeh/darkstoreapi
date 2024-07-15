<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    use HasFactory;
    protected $fillable =[
        'title_ar',
        'title_en',
        'description_ar',
        'quantity',
        'rate',
        'id_user',
        'id_categorie ',
        'id_product',
        'price',
        'discount',
        'active',
        'image'
    ];
    protected $hidden = ['time'
    ];
    public $timestamps = false;

    public  function reviews(){
        return $this->hasMany(reviews::class,'product_id');
    }
    public  function favorite(){
        return $this->hasMany(favorite::class,'id_fav_product');
    }
    public  function categories(){
        return $this->hasOne(categories::class,'id',"id_categorie");
    }
}

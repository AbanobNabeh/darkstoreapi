<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cart extends Model
{
    use HasFactory;
    public  $table = 'cart';
    protected $fillable =[
        'id_user',
        'id_product',
        'status',
        'quantity_cart',
        'order_id'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    public $timestamps = true;
    public  function products(){
        return $this->hasOne(products::class,'id','id_product');
    }
}

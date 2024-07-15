<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    use HasFactory;
    protected $fillable =[
        'order_id',
        'location',
        'phonenumber',
        'id_user',
        'status_order',
        'amount_cents',
        'name_user'
    ];
    protected $hidden = [
    ];
    public $timestamps = false;
    public  function cart(){
        return $this->hasMany(cart::class,'order_id','order_id');
    }
}

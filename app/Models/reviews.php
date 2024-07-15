<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reviews extends Model
{
    use HasFactory;
    protected $fillable =[
        'product_id',
        'comment',
        'image_user',
        'id_user',
        'review',
        'name_user',
    ];
    protected $hidden = ['time'
    ];
    public $timestamps = false;


}

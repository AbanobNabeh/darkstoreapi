<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class categories extends Model
{
    use HasFactory;
    protected $fillable =[
        'name_ar',
        'name_en',
        'image',
    ];
    protected $hidden = ['time'
    ];
    public $timestamps = false;

}

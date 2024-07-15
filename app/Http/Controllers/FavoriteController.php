<?php

namespace App\Http\Controllers;

use App\Models\favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function addfavorite(Request $request){
        $fav = favorite::create([
             "id_fav_product" => $request->id_fav_product,
             "id_fav_user" => $request->id_fav_user
        ]);
        return $fav;
    }
    public function getfavorite(Request $request){
        $fav = favorite::where("id_fav_user" , $request->id_fav_user)->get();
        return $fav;
    }
    public function removefavorite(Request  $request){
        $fav = favorite::where([
            "id_fav_product" => $request->id_fav_product,
            "id_fav_user" => $request->id_fav_user,
        ])->delete();
        return $fav;
    }
    public function getfav(Request  $request){
        $fav = favorite::with('products')->where( "id_fav_user" , $request->id_fav_user,)->get();
        return $fav;
    }
}

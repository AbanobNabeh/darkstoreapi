<?php

namespace App\Http\Controllers;

use App\Models\banners;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BannerController extends Controller
{
    public function getbanner(){
       $banner =  banners::get();
       return $banner;
    }

    public function addbanner(Request $request){
        $request->images->storeAs('images',$request->data['image'],'public');
        $banner =   banners::create([
            'banner' => $request->data['image']
        ]);
        return $banner;
    }

    public function removebanner(Request $request){
        $banner =   banners::where('id',$request->id)->delete();    
        return $banner;
    }
}

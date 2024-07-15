<?php

namespace App\Http\Controllers;

use App\Models\coupons;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class CouponController extends Controller
{
    public  function usecoupon (Request $request){
        $coupon = coupons::where('code' , $request->code)->get();
        if(count($coupon)==0){
            return 'coupon code invalid';
        }else{
            if($coupon[0]['active'] ==0){
                return 'coupon code has expired';
            }else{
                return $coupon;
            }
        }
    }
    public  function getcoupons(){
        $coupon = coupons::get();
        return $coupon;
    }
    public  function enablecoupon(Request $request){
    $coupon = coupons::where('id', $request->id)->update(["active"=>1]);
    return $coupon;
    }
    public  function disablecoupon(Request $request){
    $coupon = coupons::where('id', $request->id)->update(["active"=>0]);
    return $coupon;
    }
    public  function addcoupons(Request  $request){
        $coupon = coupons::where('code',$request->code)->get();
        if(count($coupon) == 0){
            coupons::insert([
                "code" => $request->code,
                "discount" => $request->discount,
                "active" => 1,
            ]);
        }else{
            return "This Code Already Used";
        }
    }

}



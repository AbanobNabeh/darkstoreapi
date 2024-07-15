<?php

use App\Http\Controllers\BannerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\CartController;
use  App\Http\Controllers\CouponController;


Route::get('banner',[BannerController::class,"getbanner"]);
Route::post('addbanner',[BannerController::class,"addbanner"]);
Route::post('removebanner',[BannerController::class,"removebanner"]);
Route::get('category',[CategoryController::class,'getcategory']);
Route::post('productcat',[CategoryController::class,'getproductcat']);
Route::post('addcategory',[CategoryController::class,'addcategory']);
Route::post('deletecategory',[CategoryController::class,'deletecategory']);
Route::post('editcategory',[CategoryController::class,'editcategory']);
Route::post('product',[ProductController::class,'product']);
Route::post('addproduct',[ProductController::class,'addproduct']);
Route::post('search',[ProductController::class,'search']);
Route::get('getproduct',[ProductController::class,'getallproduct']);
Route::post('deleteproduct',[ProductController::class,'deleteproduct']);
Route::post('editproduct',[ProductController::class,'editproduct']);
Route::post('addfav',[FavoriteController::class,'addfavorite']);
Route::post('getfav',[FavoriteController::class,'getfavorite']);
Route::post('removefav',[FavoriteController::class,'removefavorite']);
Route::post('getfav',[FavoriteController::class,'getfav']);
Route::post('addreview',[ReviewsController::class,'addreview']);
Route::post('addcart',[CartController::class,'addcart']);
Route::post('getcart',[CartController::class,'getcart']);
Route::post('removecart',[CartController::class,'removecart']);
Route::post('minuscart',[CartController::class,'minusone']);
Route::post('payment',[CartController::class,'payment']);
Route::post('order',[CartController::class,'getorder']);
Route::get('getallorder',[CartController::class,'getallorder']);
Route::post('confirma',[CartController::class,'confirma']);
Route::post('myorder',[CartController::class,'myorder']);
Route::post('updateorder',[CartController::class,'updateorder']);
Route::post('usecoupon',[CouponController::class,'usecoupon']);
Route::get('getcoupons',[CouponController::class,'getcoupons']);
Route::post('enablecoupon',[CouponController::class,'enablecoupon']);
Route::post('disablecoupon',[CouponController::class,'disablecoupon']);
Route::post('addcoupons',[CouponController::class,'addcoupons']);

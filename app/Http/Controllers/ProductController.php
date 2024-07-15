<?php

namespace App\Http\Controllers;

use App\Models\products;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function product(Request $request){
        $product = products::with(['reviews','favorite'])->orderBy('id',"DESC")->limit(25)->get();
        for ($i = 0; $i < count($product);){
                if(!empty($product[$i]->reviews[0])){

                    foreach ($product[$i]->reviews as $value) {
                        $rateing = 0.0;
                        $value['review'] = strval($value['review']);
                        $rateing = $value['review'] + $rateing;
                        if($value['id_user'] == $request['id']) {
                            $product[$i]->myrate = true;
                        }
                    }
                    $product[$i]->rate = strval($rateing / count($product[$i]->reviews));
                }else{
                    $product[$i]->rate = '0';
                }
                if(!empty($product[$i]->favorite[0])){

                    foreach ($product[$i]->favorite as $value) {
                      if($value->id_fav_user == $request['id']){
                          $product[$i]->myfavorite = true;
                      }
                    }
                }
                $i++;
        }
        return $product;
    }
    public function addproduct(Request $request){
        $request->images->storeAs('images',$request->data['image'],'public');
        $product = products::insert([
            'title_ar' =>$request->data['title_ar'],
            'title_en' =>$request->data['title_en'],
            'description_ar' =>$request->data['description_ar'],
            'description_en' =>$request->data['description_en'],
            'quantity' =>$request->data['quantity'],
            'id_categorie' =>$request->data['id_categorie'],
            'price' =>$request->data['price'],
            'discount' =>$request->data['discount'],
            'active' =>$request->data['active'],
            'image' => $request->data['image'],
        ]);
        return $product;
    }
    public function deleteproduct(Request $request){
        $product = products::where('id',$request->id)->delete();
        return $product;
    }
    public function search(Request $request){
        $product = products::with(['reviews','favorite'])->where('title_ar','like', '%'. $request->title.'%')->orWhere('title_en','like', '%'. $request->title.'%')->orderBy('id',"DESC")->limit(10)->get();
        for ($i = 0; $i < count($product);){
            if(!empty($product[$i]->reviews[0])){
                foreach ($product[$i]->reviews as $value) {
                    $rateing = 0.0;
                    $value['review'] = strval($value['review']);
                    $rateing = $value['review'] + $rateing;
                    if($value['id_user'] == $request['id']) {
                        $product[$i]->myrate = true;
                    }
                }
                $product[$i]->rate = strval($rateing / count($product[$i]->reviews));
            }else{
                $product[$i]->rate = '0';
            }
            if(!empty($product[$i]->favorite[0])){

                foreach ($product[$i]->favorite as $value) {
                    if($value->id_fav_user == $request['id']){
                        $product[$i]->myfavorite = true;
                    }
                }
            }
            $i++;
        }
        return $product;
    }
    public function editproduct(Request $request){
            if($request->images == null){
                $product = products::where('id',$request->id)->update([
                    'title_ar' =>$request->title_ar,
                    'title_en' =>$request->title_en,
                    'description_ar' =>$request->description_ar,
                    'description_en' =>$request->description_en,
                    'quantity' =>$request->quantity,
                    'id_categorie' =>$request->id_categorie,
                    'price' =>$request->price,
                    'discount' =>$request->discount,
                    'active' =>$request->active,
                    'image' =>$request->image,
                ]);
                return $product;
            }else{
                $image_path = $request->images->storeAs('images',$request->data['image'],'public');
                $product = products::where('id',$request->data['id'])->update([
                    'title_ar' =>$request->data['title_ar'],
                    'title_en' =>$request->data['title_en'],
                    'description_ar' =>$request->data['description_ar'],
                    'description_en' =>$request->data['description_en'],
                    'quantity' =>$request->data['quantity'],
                    'id_categorie' =>$request->data['id_categorie'],
                    'price' =>$request->data['price'],
                    'discount' =>$request->data['discount'],
                    'active' =>$request->data['active'],
                    'image' => $request->data['image'],
                ]);
                return $product;
            }
    }
    public function getallproduct(){
        $product = products::get();
        return $product;
    }
}

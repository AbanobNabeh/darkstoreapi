<?php

namespace App\Http\Controllers;

use App\Models\categories;
use App\Models\products;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getcategory(){
        $category =  categories::get();
        return $category;
    }

    public function getproductcat(Request  $request){
        $rateing = 0.0;
        $product = products::with(['reviews','favorite'])->where('id_categorie',$request['category'])->orderBy('id',"DESC")->get();
        for ($i = 0; $i < count($product);){
            if(!empty($product[$i]->reviews[0])){
                foreach ($product[$i]->reviews as $value) {
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

    public function addcategory(Request $request){
        $request->images->storeAs('images',$request->data['image'],'public');
        $category =  categories::insert([
            'name_ar' => $request->data['name_ar'],
            'name_en' => $request->data['name_en'],
            'image' => $request->data['image'],
        ]);
        return $category;
    }

    public function deletecategory(Request $request){
        $category =  categories::where('id',$request->id)->delete();
        return $category;
    }
    public function editcategory(Request $request){
        if($request->images == null){
            $category = categories::where('id',$request->id)->update([
                'name_ar' =>$request->name_ar,
                'name_en' =>$request->name_en,
                'image' =>$request->image,
            ]);
            return $category;
        }else{
            $image_path = $request->images->storeAs('images',$request->data['image'],'public');
            $category = categories::where('id',$request->data['id'])->update([
                'name_ar' =>$request->data['name_ar'],
                'name_en' =>$request->data['name_en'],
                'image' =>$request->data['image'],
            ]);
            return $category;
        }
    }
}

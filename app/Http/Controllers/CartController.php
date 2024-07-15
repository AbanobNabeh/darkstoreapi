<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Models\orders;
use App\Models\products;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public  function addcart(Request  $request){
       $getcart = cart::where(['id_product' => $request->id_product,  'id_user' => $request->id_user])->get();
       if(count($getcart) == 0){
           cart::create([
               'id_product' => $request->id_product,
               'id_user' => $request->id_user,
               'status' => 'incart',
               'quantity_cart' => 1,
               'order_id' => 0,
           ]);
           return  "The product has been added to the cart";
       }else if ($getcart[0]['status'] == 'incart'){
           if($getcart[0]['quantity_cart'] == 1){
               $product = products::where('id',$request->id_product)->get();
               if ($product[0]['quantity'] <= 1){
                   return 'Only one piece of this product is available';
               }else{
                   cart::where(['id_product' => $request->id_product,  'id_user' => $request->id_user])->update(['quantity_cart' => 2]);
                   return 'The product has been added to the cart';
               }
           }
           else{
               return  'you cannot add two pieces of the same product';
           }
       }else{
           return "You cannot add the product before receiving your order";
       }

    }
    public function removecart(Request $request){
        $cart =cart::where(['id_user' => $request->id_user , 'id_product'=>$request->id_product])->delete();
        return $cart;
    }
    public function getcart(Request $request){
       $cart = cart::with(['products'])->where(['id_user' => $request->id_user , 'status'=>'incart'])->get();
       return $cart;
    }
    public function minusone(Request $request){
        $cart =cart::where(['id_user' => $request->id_user , 'id_product'=>$request->id_product])->update(['quantity_cart' => 1]);
        return $cart;
    }
    public function payment(Request $request){
        $paymob = [
            "id_order" => $request->obj['order']['shipping_data']['order_id'],
            "amount_cents" => $request->obj['amount_cents'],
            "success"=> $request->obj['success'],
            "created_at"=> $request->obj['order']['created_at'],
            "name_user"=> $request->obj['order']['shipping_data']['first_name'],
            "id_user"=> $request->obj['order']['shipping_data']['last_name'],
            "location"=> $request->obj['order']['shipping_data']['street'],
            "email"=> $request->obj['order']['shipping_data']['email'],
            "phone_number"=> $request->obj['order']['shipping_data']['phone_number'],
            "items"=> count($request->obj['order']['items'])
        ];
        DB::table('payment')->insert($paymob);
        if($paymob['success']){
            DB::table('orders')->insert([
                "order_id" => $paymob['id_order'],
                "location" => $paymob['location'],
                "phonenumber" => $paymob['phone_number'],
                "id_user" => $paymob['id_user'],
                "status_order" => 'inreview',
                "amount_cents" => $paymob['amount_cents'],
                "name_user" => $paymob['name_user'],
            ]);
            for ($i = 0; $i < $paymob['items'];) {
                  cart::where([
                    'id_product'=> $request->obj['order']['items'][$i]['name'],
                    'id_user'=> $request->obj['order']['items'][$i]['description'],
                ])->update([
                    "status"=> 'inorder',
                    "order_id" => $paymob['id_order'],
                ]);
                $product = DB::table('products')->where('id',$request->obj['order']['items'][$i]['name'])->get();
                DB::table('products')->where('id' , $request->obj['order']['items'][$i]['name'])->update([
                    'quantity' => $product[0]->quantity - $request->obj['order']['items'][$i]['quantity']
                ]);
                $i++;
            }
        }
    }
    public function getorder(Request $request){
        $order = orders::with(['cart'])->where('id_user' , $request->id_user)->where( 'status_order' ,'!=', 'done')->get();
        foreach ($order[0]['cart'] as $item) {
            $product = products::where('id' , $item['id_product'])->get();
            $item['product'] =$product;
        }
        return  $order;
    }
    public function confirma(Request $request){
       $order =  orders::where('order_id',$request->order_id)->update(['status_order'=>'done']);
       return $order;
    }
    public function getallorder(Request $request){
       $orders = orders::with(['cart'])->where('status_order' ,'!=', 'done')->get();
        foreach ($orders as $items) {
            $product = array();
            foreach ($items['cart'] as $item) {
                $products = products::where('id',$item['id_product'])->get();
                array_push($product,$products[0]);
                $items['products'] = $product;
            }

        }
        return $orders;
    }
    public function updateorder(Request $request){
      $order = orders::where('id',$request->id)->update(["status_order"=>$request->state]);
      return $order;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\reviews;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{

    public function addreview(Request  $request){
        $review = reviews::create([
            "product_id" => $request->product_id,
            "comment" => $request->comment,
            "image_user" => $request->image_user,
            "id_user" => $request->id_user,
            "review" => $request->review,
            "name_user" => $request->name_user,
        ]);
        return $review;
    }
}

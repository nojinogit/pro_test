<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function index(Request $request){
    $shops=Shop::all();
    $areas=Shop::select('area')->distinct()->get();
    $categories=Shop::select('category')->distinct()->get();
    return view('/index',compact('shops','areas','categories'));
    }

    public function detail($id){
    $shop=Shop::find($id);
    $reviews=Review::with('user')->where('shop_id',$id)->whereNot('score')->get();
    if(!empty(Auth::user()->id)){
        $reviewArea=Review::where('user_id',Auth::user()->id)->where('shop_id',$id)->first();
        if(!empty($reviewArea->score)){
            return view('/detail',compact('shop','reviews'));
        }
        elseif(empty($reviewArea->score)){
            return view('/detail',compact('shop','reviewArea','reviews'));
        }
    }
    return view('/detail',compact('shop','reviews'));
    }
}

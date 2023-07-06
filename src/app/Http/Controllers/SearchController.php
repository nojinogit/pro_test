<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;

class SearchController extends Controller
{
    public function search(Request $request){
        
        $shops=Shop::AreaSearch($request->area)->CategorySearch($request->category)->NameSearch($request->name)->get();
        $areas=Shop::select('area')->distinct()->get();
        $categories=Shop::select('category')->distinct()->get();
        return view('/index',compact('shops','areas','categories'));
    }

}

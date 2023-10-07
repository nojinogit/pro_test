<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Kutikomi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class KutikomiController extends Controller
{
    public function kutikomiIndex($id){
    $shop=Shop::find($id);
    $kutikomi=Kutikomi::where('user_id',Auth::user()->id)->where('shop_id',$id)->first();
    return view('/kutikomi',compact('shop','kutikomi'));
    }

    public function kutikomiCreate(Request $request){
    $randomFileName = Str::random(20);
    $extension = $request->file('image')->getClientOriginalExtension();
    $request->file('image')->storeAs('public/kutikomi_photo', $randomFileName . '.' . $extension);
    $path='storage/kutikomi_photo/'.$randomFileName . '.' . $extension;
    $kutikomi=$request->only(['shop_id','score','kutikomi']);
    $kutikomi['user_id']=Auth::user()->id;
    $kutikomi['path']=$path;
    Kutikomi::create($kutikomi);
    $shop=shop::find($request->shop_id);

    return redirect()->route('kutikomiIndex', ['id' => $shop->id])
            ->with('kutikomi', $kutikomi)
            ->with('message', '投稿が完了しました');
    }

    public function kutikomiUpdate(Request $request){
    $randomFileName = Str::random(20);
    $extension = $request->file('image')->getClientOriginalExtension();
    $request->file('image')->storeAs('public/kutikomi_photo', $randomFileName . '.' . $extension);
    $path='storage/kutikomi_photo/'.$randomFileName . '.' . $extension;
    $kutikomi=$request->only(['shop_id','score','kutikomi']);
    $kutikomi['user_id']=Auth::user()->id;
    $kutikomi['path']=$path;
    Kutikomi::create($kutikomi);
    $shop=shop::find($request->shop_id);

    return redirect()->route('kutikomiIndex', ['id' => $shop->id])
            ->with('kutikomi', $kutikomi)
            ->with('message', '投稿が完了しました');
    }
}

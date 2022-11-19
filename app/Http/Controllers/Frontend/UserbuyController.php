<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Sell;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserbuyController extends Controller
{
    public function buyNowPage(Request $request, $id)
    {

        $upload = Upload::firstWhere('id', $id);
        $check = Sell::where('buyer_id', Auth::user()->id)->where('upload_id', $upload->id)->count();

        if($upload->sell == false || $check && $check > 0){
            return  redirect()->back();
        };

        return view('frontend.buy-now', compact('upload'));
    }

    public function buyNow(Request $request, $id)
    {
        $upload = Upload::firstWhere('id', $id);
        $check = Sell::where('buyer_id', Auth::user()->id)->where('upload_id', $upload->id)->count();

        if($check && $check > 0){
            return  redirect()->back();
        };

        Sell::create([
            'upload_id' => $request->upload_id,
            'seller_id' => $request->seller_id,
            'buyer_id'  => Auth::user()->id,
            'price'     => $request->price
        ]);

        return redirect()->route('singleVideo', $id);


    }
}

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Upload;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Follower;
use App\Models\Multi_image;
use App\Models\Sell;
use App\Models\Setting;
use Facade\FlareClient\Flare;
use Illuminate\Support\Facades\Auth;
use Stevebauman\Location\Facades\Location;

use File;
use Illuminate\Support\Facades\Storage;
use Repsonse;

class HomeController extends Controller
{
    public function index(){
        $country = getLocation(); // Get location fron Helper fuction.

        $upload = Upload::whereStatus(1)
        ->when($country, function ($query, $country) {
            return $query->where('region', $country);
        })
        ->latest()->get();
        $others = null;
        if(count($upload) < 20){
            $others = Upload::latest()->paginate(20);
        }
        $countries = Upload::whereStatus(1)->pluck('region');

        $likeCheck = Like::where('user_id',Auth::id())->first();
        $settings = Setting::first();
        return view('frontend.homepage', ['uploads'=>$upload, 'others'=> $others, "likeChecks"=> $likeCheck, 'countries'=> $countries, 'settings' => $settings]);
    }
    public function music(){
        $country = getLocation(); // Get location fron Helper fuction.

        $upload = Upload::whereStatus(1)->where('category_id', '1')
        ->when($country, function ($query, $country) {
            return $query->where('region', $country);
        })->latest()->get();

        return view('frontend.categories.music', ['uploads'=>$upload]);
    }
    public function comedy(){
        $country = getLocation(); // Get location fron Helper fuction.

        $upload = Upload::whereStatus(1)->where('category_id', '2')
        ->when($country, function ($query, $country) {
            return $query->where('region', $country);
        })->latest()->get();
        return view('frontend.categories.comedy', ['uploads'=>$upload]);
    }
    public function talent(){
        $upload = Upload::whereStatus(1)->where('category_id', '3')->latest()->get();
        return view('frontend.categories.talent', ['uploads'=>$upload]);
    }

    public function singleVideo($id){
        $upload = Upload::findOrFail($id);
        $is_purchased = false;
        $is_author = false;

        if($upload->sell && Auth::user()){
            $check = Sell::where('upload_id', $upload->id)->where('buyer_id', Auth::user()->id)->first();
            if($check){
                $is_purchased = true;
            }
            if($upload->user_id == Auth::user()->id){
                $is_author = true;
            }
        };

       $followCheck =Follower::whereFollowing_id($upload->user_id)->whereFollower_id(Auth::id())->first();
       $viewCheck = Upload::where('user_id',Auth::id())->first();
       if (!$viewCheck) {
        $upload->increment('view');
       }
       $likeCheck = Like::where('user_id',Auth::id())->where('upload_id',$id)->first();
       $cat_id = $upload->category_id;
	   $relatedUpload = Upload::whereStatus(1)->where('category_id',$cat_id)->where('id','!=',$id)->orderBy('id','DESC')->take(3)->get();
    //    Social Share with jorenvanhocht/laravel-share pack
       $shareButtons = \Share::page(
        \Request::url(),
        $upload->name,
    )
    ->facebook()
    ->twitter()
    ->linkedin()
    ->telegram()
    ->whatsapp()
    ->reddit();

    $images = Multi_image::where('upload_id', $id)->get();

        return view('frontend.single_video', compact('upload', 'images', "likeCheck", "followCheck","relatedUpload", "shareButtons", 'is_purchased', 'is_author'));
    }
    public function getLatest()
    {
        $upload = Upload::whereStatus(1)->orderBy('id','DESC')->get();
        $others = null;
        if(count($upload) < 20){
            $others = Upload::latest()->paginate(20);
        }
        $countries = Upload::whereStatus(1)->pluck('region');
        $likeCheck = Like::where('user_id',Auth::id())->first();
        return view('frontend.homepage', ['uploads'=>$upload, "likeChecks"=> $likeCheck, 'others'=> $others, 'countries'=> $countries]);
    }
    public function getView()
    {
        $upload = Upload::whereStatus(1)->orderBy('view','DESC')->get();
        $others = null;
        if(count($upload) < 20){
            $others = Upload::latest()->paginate(20);
        }
        $countries = Upload::whereStatus(1)->pluck('region');
        $likeCheck = Like::where('user_id',Auth::id())->first();
        return view('frontend.homepage', ['uploads'=>$upload, "likeChecks"=> $likeCheck, 'others'=> $others, 'countries'=> $countries]);
    }
    public function getLike()
    {
        $upload = Upload::with(['likes' => function ($q){
            $q->orderBy('count', 'DESC');
        }])->get();
        $others = null;
        if(count($upload) < 20){
            $others = Upload::latest()->paginate(20);
        }
        $countries = Upload::whereStatus(1)->pluck('region');
        // $upload = Upload::with('likes')->get()->sortByDesc('likes.count');
        $likeCheck = Like::where('user_id',Auth::id())->first();
        return view('frontend.homepage', ['uploads'=>$upload, "likeChecks"=> $likeCheck, 'others'=> $others, 'countries'=> $countries]);
    }
    public function autoplayChange(Request $request)
    {
        $user = Auth::user();
        $user->auto_play = !$user->auto_play;
        $user->save();

    }


    public function download($id)
    {

        $upload = Upload::firstWhere('id', $id);
        $file = public_path($upload->upload);
        $fileExtension = explode('.',$file);

        $headers = array(
            'Content-Type: application/'.$fileExtension[1],
        );

        return response()->download($file, $upload->name, $headers);
    }
}

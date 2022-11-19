<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Upload;
use App\Models\User;
use Illuminate\Http\Request;

class ChannelpageController extends Controller
{
    public function channelpage(Request $request, $id)
    {
        $uploads = Upload::where('user_id', $id)->get();
        $channel = User::firstWhere('id', $id);

        // return $uploads;


        return view('frontend.channel-page', compact('uploads', 'channel'));
    }
}

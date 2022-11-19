<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Sell;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersellController extends Controller
{
    public function sellsList()
    {
        // $sells = Sell::with('upload')->where('seller_id', Auth::user()->id)->latest()->distinct()->paginate(10);
        // return $sells;

        $sells = Upload::where('user_id', Auth::user()->id)
        ->where('sell', true)
        // ->withCount('sells')
        ->has('sells')
        ->withCount('sells')
        ->paginate(10);

        // return $sells;
        return view('backend.user-sell.index', compact('sells'));
    }
}

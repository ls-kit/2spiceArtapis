<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $country = getLocation(); // Get location fron Helper fuction.
        $keyword = null;
        if (isset($_GET['keyword'])) {
            $keyword = trim($_GET['keyword']);
        }

        $upload = Upload::whereStatus(1)
            ->when($keyword, function ($query, $keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%')
                    ->orWhereHas('user', function ($query) use ($keyword) {
                        $query->where('name', 'like', '%' . $keyword . '%');
                    });
            })
            ->when($country, function ($query, $country) {
                return $query->where('region', $country);
            })
            ->get();

        $likeCheck = Like::where('user_id', Auth::id())->first();
        return view('frontend.searchpage', ['uploads' => $upload, "likeChecks" => $likeCheck]);
    }


    public function ajaxSearch(Request $request, $keyword)
    {
        $country = getLocation(); // Get location fron Helper fuction.

        $upload = Upload::whereStatus(1)->where('name', 'like', '%' . $request->keyword . '%')
            ->orWhereHas('user', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->keyword . '%');
            })
            ->when($country, function ($query, $country) {
                return $query->where('region', $country);
            })
            ->take(7)->get();
        $keyword = $request->keyword;

        return view('frontend.ajax.searchresult', ['uploads' => $upload, 'keyword' => $keyword]);
    }
}

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function getLocation(Request $request)
    {
        $country = null;
        $data = $request->session()->put('country', $request->country);
        return redirect()->back();
    }
}

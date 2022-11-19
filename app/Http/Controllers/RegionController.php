<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Adrianorosa\GeoLocation\GeoLocation;
use Monarobase\CountryList\CountryListFacade;

class RegionController extends Controller
{
    public function index()
    {
        $details = GeoLocation::lookup();

echo $details->getIp();
// 8.8.8.8

echo $details->getCity();
// Mountain View

echo $details->getRegion();
// California

echo $details->getCountry();
// United States
    }
}

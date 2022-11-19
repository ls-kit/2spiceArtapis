<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Category;
use App\Models\Region;
use App\Models\Upload;
use jeremykenedy\LaravelRoles\Models\Role;
use Monarobase\CountryList\CountryListFacade;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return view('backend.home');
        }else{
            $page_title = 'Create A New Upload';
            $categories = Category::all();
            // $regions = Region::all();
            $countries =CountryListFacade::getList('en');
            return view('backend.uploads.create', compact('page_title', 'countries','categories'));
        }
    }
}

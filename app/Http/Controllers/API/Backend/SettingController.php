<?php

namespace App\Http\Controllers\API\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Region;
use App\Models\Menu;
use App\Models\Setting;
use jeremykenedy\LaravelRoles\Models\Role;
use Validator;
use Illuminate\Support\Facades\Auth;
use Monarobase\CountryList\CountryListFacade;

class SettingController extends Controller
{
    public function siteSetting()
    {
      $setting = Setting::first();
      return response()->json($setting);
    }
    public function siteSettingStore(Request $request)
    {
        $request->validate([

            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $count = Setting::count();
        if ( $count == 0 ) {
            $input = $request->all();

            $image=$request->file('logo');
                if ($image) {
                    $image_name=hexdec(uniqid());
                    $ext=strtolower($image->getClientOriginalExtension());
                    $image_full_name=$image_name.'.'.$ext;
                    $upload_path='uploads/sitesetting/';
                    $image_url=$upload_path.$image_full_name;
                    $success=$image->move($upload_path,$image_full_name);
                    $input['logo']=$image_url;
            }
            $image=$request->file('favicon');
                if ($image) {
                    $image_name=hexdec(uniqid());
                    $ext=strtolower($image->getClientOriginalExtension());
                    $image_full_name=$image_name.'.'.$ext;
                    $upload_path='uploads/sitesetting/';
                    $image_url=$upload_path.$image_full_name;
                    $success=$image->move($upload_path,$image_full_name);
                    $input['favicon']=$image_url;
            }
           $data = Setting::create($input);

            return response()->json($data);
        } else {
            $firstdata =Setting::first();
            $setting = Setting::findOrFail($firstdata->id);

            $input = $request->all();

            $image=$request->file('logo');
            if ($image) {
                $image_name=hexdec(uniqid());
                $ext=strtolower($image->getClientOriginalExtension());
                $image_full_name=$image_name.'.'.$ext;
                $upload_path='uploads/sitesetting/';
                $image_url=$upload_path.$image_full_name;
                $success=$image->move($upload_path,$image_full_name);
                $input['logo']=$image_url;

                if (file_exists(public_path($request->old_logo))) {
                    unlink(public_path($request->old_logo));
                }
        }
            $image=$request->file('favicon');
            if ($image) {
                $image_name=hexdec(uniqid());
                $ext=strtolower($image->getClientOriginalExtension());
                $image_full_name=$image_name.'.'.$ext;
                $upload_path='uploads/sitesetting/';
                $image_url=$upload_path.$image_full_name;
                $success=$image->move($upload_path,$image_full_name);
                $input['favicon']=$image_url;

                if (file_exists(public_path($request->old_fevicon))) {
                   unlink(public_path($request->old_fevicon));
                }
        }


        $setting->update($input);
        return response()->json($setting);
        }



    }


    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $menu = Menu::get();
        return response()->json( ['menus'=> $menu]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('backend.admin.menu.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'type' => 'required',
        ]);

        $menu = new Menu();
        $menu->name = $request->name;
        $menu->link = $request->link;
        $menu->type = $request->type;
        $menu->status = $request->status;
        $menu->icon = $request->icon;
        $menu->save();
        return response()->json(['create' => 'Menu has been created successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function show(){
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $menu = Menu::find($id);
        return response()->json( ['menus'=> $menu]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function update(){

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $delete=  Menu::findOrFail($id);
        $delete->delete();
        return response()->json(['delete' => 'Menu has been delete successfully.']);
    }
}

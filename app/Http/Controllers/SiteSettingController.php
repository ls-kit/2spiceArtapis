<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SiteSettingController extends Controller
{
    public function index()
    {

        $setting = Setting::first();
       return view('backend.admin.sitesettings.index', compact('setting'));
    }
    public function store(Request $request)
    {
        $request->validate([

            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $count = Setting::count();
        if ( $count == 0 ) {
            $input = $request->all();

            $image=$request->file('banner_image');
                if ($image) {
                    $image_name=hexdec(uniqid());
                    $ext=strtolower($image->getClientOriginalExtension());
                    $image_full_name=$image_name.'.'.$ext;
                    $upload_path='uploads/sitesetting/';
                    $image_url=$upload_path.$image_full_name;
                    $success=$image->move($upload_path,$image_full_name);
                    $input['banner_image']=$image_url;
            }

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
            Setting::create($input);
        } else {
            $firstdata =Setting::first();
            $setting = Setting::findOrFail($firstdata->id);

            $input = $request->all();

            $image=$request->file('banner_image');
            if ($image) {
                $image_name=hexdec(uniqid());
                $ext=strtolower($image->getClientOriginalExtension());
                $image_full_name=$image_name.'.'.$ext;
                $upload_path='uploads/sitesetting/';
                $image_url=$upload_path.$image_full_name;
                $success=$image->move($upload_path,$image_full_name);
                $input['banner_image']=$image_url;

                if (file_exists(public_path($request->old_banner_image))) {
                    unlink(public_path($request->old_banner_image));
                }
            }

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
        }


        return redirect()->route('site.settings')
        ->with('success','Settings created successfully.');
    }

}

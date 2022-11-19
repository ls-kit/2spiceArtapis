<?php

namespace App\Http\Controllers\API\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Region;
use App\Models\Upload;
use App\Models\Multi_image;
use App\Models\Follower;
use App\Models\Like;
use App\Models\User;
use jeremykenedy\LaravelRoles\Models\Role;
use Validator;
use Illuminate\Support\Facades\Auth;
use Monarobase\CountryList\CountryListFacade;
use File;
use Image;

class UploadController extends Controller
{

    public function index()
    {
        $page_title = 'Create A New Upload';
        return response()->json(['page_title' => $page_title]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = 'Create A New Upload';
        $categories = Category::all();
        // $regions = Region::all();
        $countries = CountryListFacade::getList('en');

        $data = [
            'page_title' => $page_title,
            'countries' => $countries,
            'categories' => $categories
        ];
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'thumbnail_image' => 'required',
            'thumbnail_image.*' => 'image|mimes:jpg,png,jpeg,gif,svg|max:5120',
            'imges.*' => 'image|mimes:jpg,png,jpeg,gif,svg|max:5120',
            'upload' => 'mimes:mp3,mp4,3gp,mpeg,mkv,amv,avi',
            'region' => 'required',
        ]);
        // for image
        $newFileName = '';
        if ($request->hasFile('thumbnail_image')) {
            $thumb = $request->thumbnail_image;
            $fileName = $thumb->getClientOriginalExtension();
            if ($fileName == 'jpg' || $fileName == 'png' || $fileName == 'jpeg' || $fileName == 'gif' || $fileName == 'svg') {
                $uploadPath = 'uploads/' . Auth::user()->name . '/images/';
                $newFileName = $uploadPath . time() . '.' . $fileName;
                Image::make($thumb)->resize(346, 215)->save($newFileName);
            }
        }

        $uploadFileName = '';
        if ($request->hasFile('upload')) {
            $upload_extension = $request->file('upload')->getClientOriginalExtension();
            if ($upload_extension == 'mp3') {
                $type = 1;
                $uploadPath = 'uploads/' . Auth::user()->name . '/audio/';
                $uploadFileName = $uploadPath . time() . '.' . $upload_extension;
                $request->upload->move($uploadPath, $uploadFileName);
            } elseif ($upload_extension == 'mp4' || $upload_extension == '3gp' || $upload_extension == 'mpeg') {
                $type = 2;
                $uploadPath = 'uploads/' . Auth::user()->name . '/video/';
                $uploadFileName = $uploadPath . time() . '.' . $upload_extension;
                $request->upload->move($uploadPath, $uploadFileName);
            } else {
                $type = 3;
            }
            // For calculate file duration
            $getID3 = new \getID3;
            $durationtime =  $getID3->analyze($uploadFileName);
            $duration =  $durationtime['playtime_string'];
        }


        $upload = new Upload;
        $upload->name = $request->name;
        $upload->category_id = $request->category_id;
        $upload->user_id  = Auth::user()->id;
        $upload->description = $request->description;
        $upload->thumbnail_image = $newFileName;
        $upload->upload = $uploadFileName;
        $upload->release_date = $request->release_date;
        $upload->region = $request->region;
        $upload->type_id = $type ?? null;
        $upload->upload_duration = $duration ?? null;
        $upload->sell = $request->sell;
        $upload->price = $request->price;
        if ($upload->save()) {
            if ($request->hasFile('images')) {
                $images = $request->images;
                $i = 1;
                foreach ($images as $key => $image) {
                    $uploadImage = new Multi_image();

                    $fileName = $image->getClientOriginalExtension();
                    if ($fileName == 'jpg' || $fileName == 'png' || $fileName == 'jpeg' || $fileName == 'gif' || $fileName == 'svg') {
                        // $uploadPath = 'uploads/' . Auth::user()->name . '/images/';
                        $imageName = 'uploads/' . Auth::user()->name . '/images/'. $i++ . time() . '.' . $fileName;
                        Image::make($image)->resize(346, 215)->save($imageName);
                        
                        $uploadImage->upload_id = $upload->id;
                        $uploadImage->image = $imageName;
                        $uploadImage->save();
                    }
                    
                }
            }
        }

        return response()->json(['message'=> 'File has been created successfully', 'upload' => $upload]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VideoManagement  $videoManagement
     * @return \Illuminate\Http\Response
     */
    public function show(Upload $upload)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Upload  $Upload
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_title = 'Update A New Upload';
        $upload = Upload::find($id);
        $countries = CountryListFacade::getList('en');

        $data = [
            'page_title' => $page_title,
            'countries' => $countries,
            'upload' => $upload
        ];
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VideoManagement  $videoManagement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'thumbnail_image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'upload' => 'mimes:mp3,mp4,3gp,mpeg,mkv,amv,avi',
            'region' => 'required',
        ]);


        $upload = Upload::findOrFail($id);

        $input = $request->all();
        $newFileName = '';
        if ($request->hasFile('thumbnail_image')) {
            if (file_exists(public_path($upload->thumbnail_image))) {
                unlink(public_path($upload->thumbnail_image));
            }
            $fileName = $request->file('thumbnail_image')->getClientOriginalExtension();
            if ($fileName == 'jpg' || $fileName == 'png' || $fileName == 'jpeg' || $fileName == 'gif' || $fileName == 'svg') {
                $uploadPath = 'uploads/' . Auth::user()->name . '/images/';
                $newFileName = $uploadPath . time() . '.' . $fileName;
                $request->thumbnail_image->move($uploadPath, $newFileName);
            }
            $input['thumbnail_image'] = $newFileName;
        }
        //FOR VIDEO UPDATE
        if ($request->hasFile('upload')) {

            if (file_exists(public_path($upload->upload))) {
                unlink(public_path($upload->upload));
            }


            $video_Audio_extension = $request->file('upload')->getClientOriginalExtension();
            if ($video_Audio_extension == 'mp3') {
                $input['type'] = 1;
                $uploadPath = 'uploads/' . Auth::user()->name . '/audio/';
                $audioVideoFileName = $uploadPath . time() . '.' . $video_Audio_extension;
                $request->video->move($uploadPath, $audioVideoFileName);
                $input['upload'] = $audioVideoFileName;
            } elseif ($video_Audio_extension == 'mp4' || $video_Audio_extension == '3gp' || $video_Audio_extension == 'mpeg') {
                $input['type'] = 2;
                $uploadPath = 'uploads/' . Auth::user()->name . '/video/';
                $uploadFileName = $uploadPath . time() . '.' . $video_Audio_extension;
                $request->upload->move($uploadPath, $uploadFileName);
                $input['upload'] = $uploadFileName;
            } else {
                $input['type'] = 3;
            }
            $input['sell'] = $request->sell;
            $input['price'] = $request->price;
            // For calculate file duration
            $getID3 = new \getID3;
            $durationtime =  $getID3->analyze($uploadFileName);
            $duration =  $durationtime['playtime_string'];
            $input['upload_duration'] = $duration;
        }
        $upload->update($input);

        return response()->json(['message'=> 'File has been updated successfully', 'upload' => $upload]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete =  Upload::findOrFail($id);
        if (File::exists($delete->upload)) {
            unlink(public_path($delete->upload));
        }
        if (File::exists($delete->thumbnail_image)) {
            unlink(public_path($delete->thumbnail_image));
        }
        $delete->delete();

        return response()->json(['message'=> 'File has been deleted successfully']);
    }

    public function get_all_followers()
    {
        $users = User::get();
        foreach ($users as $user) {
            $followers = Follower::where('following_id', $user->id)->count();
            $data[] = [
                'user' => $user->id,
                'followers' => $followers,
            ];
        }

        return response()->json([$data]);
    }

    public function get_followers($id)
    {
        $followers = Follower::where('following_id', $id)->count();
        return response()->json(['total_followers' => $followers]);
    }

    // LIST OF A USER LIKES PER VIDEO
    public function get_likes($id)
    {
        $uploads = Upload::where('user_id', $id)->get();
        foreach ($uploads as $upload) {
            $likes = Like::where('upload_id', $upload->id)->count();
            $data[] = [
                'upload_id' => $upload->id,
                'likes' => $likes,
            ];
        }

        return response()->json([$data]);
    }

    public function get_total_likes($id)
    {
        $uploads = Upload::where('user_id', $id)->get();
        $likes = 0;
        foreach ($uploads as $upload) {
            $likes += Like::where('upload_id', $upload->id)->count();
        }

        return response()->json(['total_likes' => $likes]);
    }
    // fetch all data from Upload table
    public function fetch_upload_data(Request $request){
        $all_data=Upload::all();
        return response()->json($all_data);
    }
}

<?php

namespace App\Http\Controllers\API\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\User;
use App\Models\Comment;
use App\Models\Upload;
use Illuminate\Support\Facades\Auth;


class SocialController extends Controller
{
    public function unlike($id)
    {
      $data =  Like::where('user_id',Auth::id())->delete();

        return response()->json($data);
    }
    public function likeStore($id)
    {
        if (Auth::check()) {

            $exists = Like::where('user_id',Auth::id())->where('upload_id',$id)->first();
            if (!$exists) {
              $data =  Like::create([
                'user_id' => Auth::id(),
                'upload_id' => $id,
                'count' => 1,
            ]);
               return response()->json($data);
            }

        }else{

            return response()->json(["massege"=> "Loging First"]);

        }

    }
    public function follow($id)
    {
        $a = User::find($id);
       return $b = Auth::id();
       $test = $a->following()->attach($b);
       return response()->json(['create'=> 'followed successfully.']);
    }

    public function unfollow($id)
    {
        $a = User::find($id);
        $b = Auth::id();
       $test = $a->following()->detach($b);
        return response()->json(['delete'=> 'Unfollowed successfully.', "data" => $test]);
    }

    // comment mathod
    public function commentStore(Request $request)
    {
        $input = $request->all();
        $request->validate([
            'body'=>'required',
        ]);
        $input['user_id'] = auth()->user()->id;
       $data = Comment::create($input);
        return response()->json(['create'=> 'data store successfully.', "data" => $data]);
    }

    public function replyStore(Request $request)
    {
        $reply = new Comment();

        $reply->comment = $request->get('comment');
        $reply->upload_id = $request->upload_id;

        $reply->user()->associate($request->user());

        $reply->parent_id = $request->get('comment_id');

        $upload = Upload::find($request->upload_id);

        $upload->comments()->save($reply);

        return response()->json(['create'=> 'data store successfully.', "data" => $upload]);

    }

}

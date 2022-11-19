<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Upload;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $user = User::find(Auth::id());
        $input = $request->all();
        $request->validate([
            'body'=>'required',
        ]);
        $input['user_id'] = Auth::id();
        Comment::create($input);
        return back();
    }

    public function delComment($id)
    {
       if (Auth::check()) {
        $comment =Comment::findOrFail($id);
        $comment->delete();
        $reply =Comment::where('parent_id',$id)->first();
        if($reply){
            $reply->delete();
        }

        return response()->json([
            'success' => true,
            'code' => 200,

        ]);
       }
    }
    public function getComment($id)
    {
       $comment =Comment::with('user', "replies")->where('upload_id', $id)->get();
       return response()->json([
        'success' => true,
        'code' => 200,
        "data"=> $comment,
        // "replycount"=> $comment->replies->count(),

    ]);
    }

    public function storeComment(Request $request)
    {

        $input = $request->all();
        $request->validate([
            'body'=>'required',
        ]);
        $input['user_id'] = Auth::id();
        $comment = Comment::create($input);
        $comment = Comment::with(['user','replies'])->where("id",$comment->id)->get();
        $data = view('frontend.partials._ajax_comment',[
            'comments' => $comment,
            'post_id' => $input['upload_id'],
            'parent_id'=>$input['parent_id']
        ])->render();
        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => $data,
            'comment'=>$comment
        ]);
    }
    public function replyStoreComment(Request $request)
    {

        $input = $request->all();
        $request->validate([
            'body'=>'required',
        ]);
        $input['user_id'] = Auth::id();
        $comment = Comment::create($input);
        $id = $input['parent_id'];
        $comment = Comment::with(['user','replies'])->where("id",$comment->id)->get();
        $comment_counter = Comment::with(['user','replies'])->where("parent_id",$id);
        $data = view('frontend.partials._comment_replies',[
            'comments' => $comment,
            'post_id' => $input['upload_id'],
            'parent_id'=>$input['parent_id']
        ])->render();
        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => $data,
            'count'=> $comment_counter->count(),
            'comment'=>$comment
        ]);
    }

}

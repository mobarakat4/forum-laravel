<?php

namespace App\Http\Controllers\Feed;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Feed;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Requests\CommentRequest;
use App\Models\Like;
class FeedController extends Controller
{
    
    public function index(){
        $feeds=Feed::with('user')->with('likes')->with('comments')->latest()->get();
        return response(
            [
                'feeds'=>$feeds
            ],200
        );
    }
    public function store(PostRequest $request){
        $request->validated();
        auth()->user()->feeds()->create(['content' => $request->content]);

        return response([
            'message'=> 'success'
        ],201);
    }
    public function likepost($feed_id){
        $feed = Feed::whereId($feed_id)->first();
        if(!$feed){
            return response([
                'message' => '404 not found'
            ]
            );
        }
        $unlike=Like::where('user_id',auth()->id())->where('feed_id',$feed_id)->delete();
        if($unlike){
            
            return response([
                'message' => 'unliked'
            ],200
            );
        }
        $like=Like::create(
            [
                'user_id'=>auth()->id(),
                'feed_id'=>$feed_id
            ]
        );
        if($like){
            
            return response([
                'message' => 'liked'
            ]
            ,200);
        }
    }
    public function comment(Commentrequest $request,$feed_id){
        $comment = Comment::create([
            'user_id'=>auth()->id(),
            'feed_id'=>$feed_id,
            'content'=>$request->content
        ]);
        if(!$comment){
            return response([
                'message' => '404 not found'
            ],500
            );
        }
        return response([ 'message' =>'comment added successfuly'],200);


    }
    public function getcomments($feed_id){
        $comments = Comment::with('user')->where('feed_id',$feed_id)->latest()->get();
        if(empty($comments)){
            return response(['message'=>'no comments here yet'],201);
        }
        return response(['comments'=> $comments],200);
    }
}

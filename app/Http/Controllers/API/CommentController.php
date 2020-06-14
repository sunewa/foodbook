<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Comment;
use App\Post;

use App\CommentProduct;
use App\Product;

class CommentController extends Controller
{
    public function getAll(Request $request, $slug){

        $post = Post::where('slug',$slug)->first();
        if(!$post){
            return response()->json(['message'=>"Not found"], 401);
        }

        $comments = Comment::where('post_id',$post->id)->orderBy('created_at','desc')->get();

        return response()->json(['comments'=>$comments, 'message'=>"Saved"]);
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'comment'=>'required|string|max:100'
        ]);

        $comment = new Comment;
        $comment->post_id = $request->id;
        $comment->user_id = \Auth::user()->id;
        $comment->full_name = \Auth::user()->name;
        $comment->comment = $request->comment;
        $comment->save();

        $comments = Comment::where('post_id',$request->id)->orderBy('created_at','desc')->get();
        return response()->json(['comments'=>$comments, 'message'=>"Saved"], 200);
    }

    public function destroy(Request $request, $slug)
    {
        $post = Post::where('slug',$slug)->first();
        if(!$post){
            return response()->json(['message'=>"Not found"], 401);
        }

        $comment = Comment::findOrFail($request->id);
        if(\Auth::user()->role !== "admin" && $post->user_id !== \Auth::user()->id){
            return response()->json(['message'=>"Not authorized"], 401);
        }
        $comment->delete();

        $comments = Comment::where('post_id',$post->id)->orderBy('created_at','desc')->get();

        return response()->json(['comments'=>$comments, 'message'=>"Saved"], 200);
    }










    public function getAllProduct(Request $request, $slug){

        $product = Product::where('slug',$slug)->first();
        if(!$product){
            return response()->json(['message'=>"Not found"], 401);
        }

        $comments = CommentProduct::where('product_id',$product->id)->orderBy('created_at','desc')->get();

        return response()->json(['comments'=>$comments, 'message'=>"Saved"]);
    }
    
    public function storeProduct(Request $request)
    {
        $this->validate($request, [
            'comment'=>'required|string|max:100'
        ]);

        $comment = new CommentProduct;
        $comment->product_id = $request->id;
        $comment->user_id = \Auth::user()->id;
        $comment->full_name = \Auth::user()->name;
        $comment->comment = $request->comment;
        $comment->save();

        $comments = CommentProduct::where('product_id',$request->id)->orderBy('created_at','desc')->get();
        return response()->json(['comments'=>$comments, 'message'=>"Saved"], 200);
    }

    public function destroyProduct(Request $request, $slug)
    {
        $product = Product::where('slug',$slug)->first();
        if(!$product){
            return response()->json(['message'=>"Not found"], 401);
        }

        $comment = CommentProduct::findOrFail($request->id);
        if(\Auth::user()->role !== "admin" && $product->user_id !== \Auth::user()->id){
            return response()->json(['message'=>"Not authorized"], 401);
        }
        $comment->delete();

        $comments = CommentProduct::where('product_id',$product->id)->orderBy('created_at','desc')->get();

        return response()->json(['comments'=>$comments, 'message'=>"Saved"], 200);
    }
}

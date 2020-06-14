<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Like;
use App\Post;
use App\LikeProduct;
use App\Product;

class LikeController extends Controller
{


    public function getAll(Request $request, $slug){

        $post = Post::where('slug',$slug)->first();
        if(!$post){
            return response()->json(['message'=>"Not found"], 401);
        }

        $like_count = Like::where('post_id',$post->id)->count();

        $can_like=false;
        if(\Auth::user()){
            $can_like = Like::where('post_id',$post->id)->where('user_id',\Auth::user()->id)->count();
        }
        

        return response()->json(['like_count'=>$like_count,'can_like'=>!$can_like]);
    }
    
    public function store(Request $request)
    {
        $can_like = false;
        if($request->type =="like"){

            $like = new Like;
            $like->post_id = $request->id;
            $like->user_id = \Auth::user()->id;
            $like->full_name = \Auth::user()->name;
            $like->save();
            $can_like = false;
        
        }
        if($request->type =="unlike"){
            
            $like = Like::where('post_id',$request->id)
            ->where('user_id',\Auth::user()->id)->first();
            
            if(!$like){
                return response()->json(['message'=>"Not authorized"], 401);
            }
            
            $like->delete();
            $can_like = true;
            
        }

        $like_count = Like::where('post_id',$request->id)->count();
        return response()->json(['like_count'=>$like_count, 'can_like'=>$can_like]);
    }










    public function getAllProduct(Request $request, $slug){

        $product = Product::where('slug',$slug)->first();
        if(!$product){
            return response()->json(['message'=>"Not found"], 401);
        }

        $like_count = LikeProduct::where('product_id',$product->id)->count();

        $can_like=false;
        if(\Auth::user()){
            $can_like = LikeProduct::where('product_id',$product->id)->where('user_id',\Auth::user()->id)->count();
        }
        

        return response()->json(['like_count'=>$like_count,'can_like'=>!$can_like]);
    }
    
    public function storeProduct(Request $request)
    {
        $can_like = false;
        if($request->type =="like"){

            $like = new LikeProduct;
        $like->product_id = $request->id;
        $like->user_id = \Auth::user()->id;
        $like->full_name = \Auth::user()->name;
        $like->save();
        $can_like = false;
        
        }
        if($request->type =="unlike"){
            
            $like = LikeProduct::where('product_id',$request->id)->first();
            
            if($like->user_id !== \Auth::user()->id){
                return response()->json(['message'=>"Not authorized"], 401);
            }
            
            $like->delete();
            $can_like = true;
            
        }

        $like_count = LikeProduct::where('product_id',$request->id)->count();
        return response()->json(['like_count'=>$like_count, 'can_like'=>$can_like]);
    }
}

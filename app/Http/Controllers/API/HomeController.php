<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Feedback;
use App\User;
use App\Post;

class HomeController extends Controller
{

    public function count_stats(){
        $count['user'] = User::count();
        $count['post'] = Post::count();
        $count['feedback'] = Feedback::count();

        return response()->json(['count'=>$count]);
    }

    public function storeFeedback(Request $request)
    {
        
        $this->validate($request, [
            'name'=>'required|string|max:100',
            'message'=>'required|string|min:10',
        ]);

        $fb = new Feedback;
        $fb->name = $request->name;
        $fb->email = $request->email;
        $fb->message = $request->message;
        $fb->save();

        return response()->json(['message'=>"Saved"]);
    }
    
    public function getFeedback()
    {
        
        $feedback = Feedback::orderBy('created_at','desc')->get();

        return response()->json(['feedback'=>$feedback]);
    }
}

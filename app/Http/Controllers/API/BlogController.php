<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Blog;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::all();

        return response()->json(['blogs'=>$blogs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    public static function slugify($text) {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
        }

    public function checkSlug(Request $request){
        
        $slug = $this->slugify($request->title);
        $isExist = Blog::whereSlug($slug)->first();
        if($isExist){
            return response()->json(['slug'=>$slug, 'unique'=> 0]);
        }else{
            return response()->json(['slug'=>$slug, 'unique'=> 1]);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $slug = $this->slugify($request->title);
        $isExist = Blog::whereSlug($slug)->first();
        if($isExist){
            return response()->json(['message'=>"Slug already exist"], 500);
        }

        $this->validate($request, [
            'title'=>'required|string|max:100',
            'description'=>'required|string|min:10',
        ]);

        $blog = new Blog;
        $blog->user_id = \Auth::user()->id;
        $blog->slug = $slug;
        $blog->title = $request->title;
        $blog->description = $request->description;
        $blog->image = 'default.png';
        $blog->allow_comment = 1;
        $blog->save();

        return response()->json(['blog'=>$blog, 'message'=>"Saved"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $blog = Blog::find($id);
        return response()->json(['blog'=>$blog]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title'=>'required|string|max:100',
            'description'=>'required|string|min:10',
        ]);

        $blog = Blog::find($id);
        $this->checkifBelongsToUser($blog->user_id);

        $blog->title = $request->title;
        $blog->description = $request->description;
        $blog->image = 'default.png';
        $blog->allow_comment = 1;
        $blog->save();

        return response()->json(['blog'=>$blog, 'message'=>"Saved"]);
    }

    private function checkifBelongsToUser($user_id){
        if($user_id !== \Auth::user()->id) {
            return response()->json(['message'=>"Not authorized"], 401);
        };

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $this->checkifBelongsToUser($blog->user_id);
        
        $blog->delete();

        return response()->json(['message'=>"Blog deleted successfully"]);
    }
}

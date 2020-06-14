<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use App\Tag;
use App\Category;
use Image;
use Auth;

class PostController extends Controller
{
    public function home(Request $request){
        $posts =[];
        if($request->search){
            $posts = Post::with('tags')->with('categories')
            ->where('title','like',"%".$request->search."%")
            ->whereOr('slug','like',"%".$request->search."%")
            ->orderBy('updated_at','desc')->get();
        }else{
            $posts = Post::with('tags')->with('categories')->orderBy('updated_at','desc')->get();
        }

        foreach($posts as $post) {
            $post->short_description = substr(strip_tags($post->description),0,50);
            $post->image_url = URL('img/default.png');
            if($post->image){
                 $post->image_url_thumbs = URL('img/uploads/thumbs/').'/'.$post->image;    
            }
            unset($post->description);
         };
 
         return response()->json(['posts'=>$posts]);
    }
    public function homeShow($slug){
        $post = Post::with('tags')->with('categories')->where('slug',$slug)->first();

        $post->image_url = URL('img/default.png');
        if($post->image){
            $post->image_url = URL('img/uploads/').'/'.$post->image;    
        }
        $post->description = str_replace("<img src=","<img width='100%' src=", $post->description);
    
        return response()->json(['post'=>$post]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts=[];
        if(Auth::user()->role == "admin"){
            $posts = Post::all();
        }else if(Auth::user()->role == "user"){
            $posts = Post::where('user_id',Auth::user()->id)->get();
        }else{

        }
        
        foreach($posts as $post) {
           if($post->image){
                $post->image_url = URL('img/uploads/thumbs/').'/'.$post->image;    
           }
           $post->image_url = URL('img/default.png');
        };

        return response()->json(['posts'=>$posts]);
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
        $isExist = Post::whereSlug($slug)->first();
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
        $isExist = Post::whereSlug($slug)->first();
        if($isExist){
            return response()->json(['message'=>"Slug already exist"], 500);
        }

        $this->validate($request, [
            'title'=>'required|string|max:100',
            'description'=>'required|string|min:10',
            'categories' => 'required'
        ]);

        $post = new Post;
        $post->user_id = \Auth::user()->id;
        $post->slug = $slug;
        $post->title = $request->title;
        $post->description = $request->description;
        $post->image = ($request->image) ? $request->image : '';
        $post->allow_comment = $request->allow_comment;

        $post->save();

        $tag_ids = $this->storeTags($request->tags);
        $post->tags()->sync($tag_ids);

        $category_ids = $this->storeCategorys($request->categories);
        $post->categories()->sync($category_ids);

        return response()->json(['post'=>$post, 'message'=>"Saved"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::with('tags')->with('categories')->find($id);
        
        if(Auth::user()->role !== "admin" && $post->user_id !== \Auth::user()->id){
            return response()->json(['message'=>"Not authorized"], 401);
        }
        
        $post->image_url = URL('img/default.png');
        if($post->image){
            $post->image_url = URL('img/uploads/thumbs/').'/'.$post->image;    
        }
        return response()->json(['post'=>$post]);
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
            'categories' => 'required'
        ]);

        $post = Post::find($id);

        if(Auth::user()->role !== "admin" && $post->user_id !== \Auth::user()->id){
            return response()->json(['message'=>"Not authorized"], 401);
        }

        $post->title = $request->title;
        $post->description = $request->description;
        $post->image = $request->image;
        $post->allow_comment = $request->allow_comment;
        
        $tag_ids = $this->storeTags($request->tags);
        $post->tags()->sync($tag_ids);

        $category_ids = $this->storeCategorys($request->categories);
        $post->categories()->sync($category_ids);

        $post->save();

        return response()->json(['post'=>$post, 'message'=>"Saved"]);
    }

    private function storeTags($tags){
        $tag_ids=[];
        foreach($tags as $h){
            $d=[];
            $d['name'] = $h['name'];
            $d['code'] = $h['code'];
            array_push($tag_ids, Tag::firstOrCreate($d)->id);
        }
        return $tag_ids;
    }

    private function storeCategorys($categorys){
        $category_ids=[];
        foreach($categorys as $h){
            $d=[];
            $d['name'] = $h['name'];
            $d['code'] = $h['code'];
            array_push($category_ids, (Category::where('code',$d['code'])->first())->id);
        }
        return $category_ids;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if(Auth::user()->role !== "admin" && $post->user_id !== \Auth::user()->id){
            return response()->json(['message'=>"Not authorized"], 401);
        }
        
        $post->delete();

        return response()->json(['message'=>"Post deleted successfully"]);
    }

    public function imageUpload(Request $request){
        if($request->hasFile('image')){
            $this->validate($request, array(
                'image' => 'required'
                ));

            // add new image
            // delete old image
            // update db
            $image = $request->file('image');    

            $filename = time().'.'.$image->getClientOriginalExtension(); //get extension of file
            $location = public_path('img/uploads/'.$filename);
            $thumbs_location = public_path('img/uploads/thumbs/'. $filename);
    
            // save image with default orientation
            Image::make($image)->orientate()->save($location);
            // Image::make($image)->save($location);
    
            $img = Image::make($location);
    
            $img->fit(400, 400)->save($thumbs_location);

    
            // return $filename;
        
            return response()->json(['url'=> URL('img/uploads/thumbs/'.$filename), 'filename'=>$filename, 'success' => 'You have successfully uploaded an image'], 200);
        }
        
    }

    public function getTags(){
        $tags = Tag::all();
        return response()->json(['tags'=>$tags]);
    }

    public function getCategorys(){
        $categories = Category::all();
        return response()->json(['categories'=>$categories]);
    }
}

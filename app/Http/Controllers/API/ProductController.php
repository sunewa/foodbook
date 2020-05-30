<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Tag;
use App\Category;
use Image;
use Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products=[];
        if(Auth::user()->role == "admin"){
            $products = Product::all();
        }else if(Auth::user()->role == "user"){
            $products = Product::where('user_id',Auth::user()->id)->get();
        }else{

        }
        
        foreach($products as $product) {
           if($product->image){
                $product->image_url = URL('img/uploads/thumbs/').'/'.$product->image;    
           }
           $product->image_url = URL('img/default.png');
        };

        return response()->json(['products'=>$products]);
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
        $isExist = Product::whereSlug($slug)->first();
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
        $isExist = Product::whereSlug($slug)->first();
        if($isExist){
            return response()->json(['message'=>"Slug already exist"], 500);
        }

        $this->validate($request, [
            'title'=>'required|string|max:100',
            'description'=>'required|string|min:10',
            'categories' => 'required'
        ]);

        $product = new Product;
        $product->user_id = \Auth::user()->id;
        $product->slug = $slug;
        $product->title = $request->title;
        $product->description = $request->description;
        $product->image = ($request->image) ? $request->image : '';
        $product->available = $request->available;
        $product->price = $request->price;

        $product->save();

        $tag_ids = $this->storeTags($request->tags);
        $product->tags()->sync($tag_ids);

        $category_ids = $this->storeCategorys($request->categories);
        $product->categories()->sync($category_ids);

        return response()->json(['product'=>$product, 'message'=>"Saved"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::with('tags')->with('categories')->find($id);
        
        if(Auth::user()->role !== "admin" && $product->user_id !== \Auth::user()->id){
            return response()->json(['message'=>"Not authorized"], 401);
        }
        
        $product->image_url = URL('img/default.png');
        if($product->image){
            $product->image_url = URL('img/uploads/thumbs/').'/'.$product->image;    
        }
        
    

        return response()->json(['product'=>$product]);
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

        $product = Product::find($id);

        if(Auth::user()->role !== "admin" && $product->user_id !== \Auth::user()->id){
            return response()->json(['message'=>"Not authorized"], 401);
        }

        $product->title = $request->title;
        $product->description = $request->description;
        $product->image = $request->image;
        $product->available = $request->available;
        $product->price = $request->price;
        
        $tag_ids = $this->storeTags($request->tags);
        $product->tags()->sync($tag_ids);

        $category_ids = $this->storeCategorys($request->categories);
        $product->categories()->sync($category_ids);

        $product->save();

        return response()->json(['product'=>$product, 'message'=>"Saved"]);
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
        $product = Product::findOrFail($id);
        if(Auth::user()->role !== "admin" && $product->user_id !== \Auth::user()->id){
            return response()->json(['message'=>"Not authorized"], 401);
        }
        
        $product->delete();

        return response()->json(['message'=>"Product deleted successfully"]);
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

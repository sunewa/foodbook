<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\CartLoaded;
use App\Cart;
use App\CartDetail;

class CartController extends Controller
{
    public function storeCart(Request $request){

        $this->validate($request, [
            'name'=>'required|string|max:100',
            'address'=>'required|string|min:2',
            'contact' => 'required',
            'card_name' => "required",
            'card_number' => 'required',
            'card_expiry_date' => 'required',
            'card_ccv' => 'required'
        ]);


        $cart = new Cart;
        $cart->user_id = \Auth::user()->id;
        $cart->buyer_name = $request->name;
        $cart->buyer_address = $request->address;
        $cart->buyer_contact = $request->contact;
        $cart->buyer_email = $request->email;
        $cart->message = $request->message;
        $cart->amount = $request->amount;

        $cart->save();

        foreach($request->products as $p){
            
            $product = Product::find($p['product_id']);

            $cart = CartDetail::updateOrCreate(
                ['cart_id'=> $cart->id, 'product_id'=>$product->id],
                ['seller_id'=>$product->user_id, 'product_name'=>$product->title, 'quantity'=>$p['quantity'], 'price'=>$product->price]
            );
        }
        
        $cart = CartLoaded::where('user_id',\Auth::user()->id)->delete();

        return response()->json(['message'=>"Saved"],201);

    }
    public function storeAddToCart(Request $request)
    {
        $product = Product::find($request->id);
        if(!$product){
            return response()->json(['message'=>"Not available"], 201);
        }

        $loaded = CartLoaded::where('user_id', )
                    ->where('product_id', $request->id)
                    ->first();

        
        $cart = CartLoaded::updateOrCreate(
            ['user_id'=> \Auth::user()->id, 'product_id'=>$request->id],
            ['product_name'=>$product->title, 'quantity'=>$request->quantity, 'price'=>$product->price]
        );
    
        
        return response()->json(['message'=>"Saved"]);
    }
    public function getCart(){
        $cart = CartLoaded::where('user_id',\Auth::user()->id)->with('product:id,image')->get();
        foreach($cart as $product) {
            $product->price_prefix = "AU$";
            $product->product->image_url = URL('img/default.png');
            
            if($product->product->image){
                $product->product->image_url_thumbs = URL('img/uploads/thumbs/').'/'.$product->product->image;    
            }
        }
        return response()->json(['cart'=>$cart, 'message'=>"Done"]);
    }

    public function deleteCart()
    {
        $cart = CartLoaded::where('user_id',\Auth::user()->id)->delete();

        return response()->json(['message'=>"Cart deleted successfully"]);
    }

    public function deleteCartProduct($id, $product_id)
    {
        $cart = CartLoaded::where('id',$id)
                    ->where('product_id',$product_id)
                    ->where('user_id',\Auth::user()->id)->first();
        
        $cart->delete();

        return response()->json(['message'=>"Product deleted successfully"]);
    }




    public function getOrderHistory(){
        $order = Cart::where('user_id',\Auth::user()->id)->with('details')->get();
        
        
        return response()->json(['order'=>$order, 'message'=>"Done"]);
    }

    public function getOrderPurchase(){
            
        $order = Cart::with(['details' => function($q)  {
                // Query the name field in status table
                $q->where('seller_id', \Auth::user()->id); 
            }])->get();

        return response()->json(['order'=>$order, 'message'=>"Done"]);
    }
}

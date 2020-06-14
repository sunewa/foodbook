<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartDetail extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'cart_id','seller_id', 'product_id', 'product_name','quantity','price'
    ];
}

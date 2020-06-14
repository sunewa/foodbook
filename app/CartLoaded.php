<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartLoaded extends Model
{
    protected $fillable = [
        'user_id', 'product_id', 'product_name','quantity','price'
    ];
    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }
}

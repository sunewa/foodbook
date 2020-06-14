<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id', 'buyer_name','buyer_address','buyer_contact','buyer_email',"message", "amount"
    ];

    public function details()
    {
        return $this->hasMany('App\CartDetail','cart_id','id');
    }
}

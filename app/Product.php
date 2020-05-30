<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'product_tag');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category', 'category_product');
    }
}

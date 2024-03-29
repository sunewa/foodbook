<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'post_tag');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category', 'category_post');
    }
}

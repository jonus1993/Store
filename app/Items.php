<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ghanem\Rating\Traits\Ratingable as Rating;

class Items extends Model 
{
    use Rating;

    protected $fillable = [
        'id','name','category_id','price'
    ];

    public function tags() {
        return $this->belongsToMany(Tags::class, 'item_tags', 'item_id', 'tag_id')->withTimestamps();
    }

    public function category() {
        return $this->belongsTo(Categories::class, 'category_id');
    }

}

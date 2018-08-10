<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
       protected $fillable = [
        'id', 
    ];
       
        public function tags() {
        return $this->belongsToMany(Tags::class, 'item_tags', 'item_id', 'tag_id')->withTimestamps();
    }
    
     public function category() {
        return $this->belongsTo(Categories::class, 'category_id');
    }
}

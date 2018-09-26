<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    
     public function items() {
        return $this->belongsToMany(Items::class,'item_tags', 'tag_id', 'item_id')->withTimestamps();
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart_Items extends Model
{
     protected $fillable = [
        'cart_id','item_id','qty',
    ];
    
    protected $table = 'cart_items';
    
    
//    odwoładnie do relacji
   function item() {
        return $this->belongsTo(Items::class);
    }
    
    function cart() {
        return $this->belongsTo(Cart2::class);
    }
    
}

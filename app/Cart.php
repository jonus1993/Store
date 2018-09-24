<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    
    public function items() {
        return $this->belongsToMany(Items::class,'cart_items', 'cart_id', 'item_id')->withPivot('qty')->withTimestamps();
    }
    
     public function order()
    {
        $this->state = 1;
        $this->save();
        return $this->belongsToMany(Orders::class, 'orders', 'cart_id', 'user_id')->withTimestamps();
    }  

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    protected $fillable = [
        'user_id', 'state'
    ];
    

}

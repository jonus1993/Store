<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{    
     protected $fillable = [
        'user_id', 'address_id', 'total_qty', 'total_cost',
    ];
     
    public function cart() {
        return $this->belongsTo(Cart::class);
    }
    
     public function user() {
        return $this->belongsTo(User::class);
    }
    
}

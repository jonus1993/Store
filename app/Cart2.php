<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart2 extends Model
{
     public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    
    
}

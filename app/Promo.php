<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promo extends Model
{  
        use SoftDeletes; 
        
        protected $fillable = [
        'value','item_id', 'code',
    ];
        
    protected $dates = ['deleted_at'];
    
    protected $hidden = array('pivot');

    public function user() {
        return $this->belongsToMany(User::class)->withPivot('used')->withTimestamps();
    }
    
     public function item() {
        return $this->belongsTo(Items::class);
    }
    
        

}

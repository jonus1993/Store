<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Cart_Items;
class Cart2 extends Model {

    public function getCartID($userid) {
        return $this->where('user_id', $userid)->select('id')->first();
    }
    
    public function delCart($cartid) {
          Cart_Items::where('cart_id','=', $cartid)->delete();
        $this->where('id', $cartid)->delete();
    }
    

    public function user() {
        return $this->belongsTo('App\User');
    }

    protected $fillable = [
        'user_id',
    ];
    protected $table = 'Cart2';

}

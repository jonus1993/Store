<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Order_Items;
class Orders extends Model
{
    function orderItem() {
        return $this->hasMany(Order_Items::class);
    }
}

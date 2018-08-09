<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_Items extends Model {

    function item() {
        return $this->belongsTo(Items::class);
    }

}

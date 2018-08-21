<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuestsOrders_Items extends Model
{
      function item() {
        return $this->belongsTo(Items::class);
    }
}

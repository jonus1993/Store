<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotifiPrice extends Model {

    public function item() {
        return $this->hasOne('App\Items','id');
    }
    public function user() {
        return $this->hasOne('App\User','id');
    }

}

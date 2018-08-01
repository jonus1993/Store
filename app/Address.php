<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'street', 'zip_code', 'city','user_id',
    ];
    protected $hidden = [
        'user_id',
    ];

    protected $table = 'addresses';

}

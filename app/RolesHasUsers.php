<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RolesHasUsers extends Model
{
     protected $fillable = [
        'users_id', 'role_id', 
    ];    
}

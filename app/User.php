<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\PriceDown;
use Illuminate\Database\Eloquent\SoftDeletes;

//$user->notify(new PriceDown($invoice));

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];
    
    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany(Roles::class, 'roles_has_users', 'users_id', 'roles_id')->withTimestamps();
    }
    
    public function items()
    {
        return $this->belongsToMany(Items::class, 'notifi_prices', 'user_id', 'item_id')->withTimestamps();
    }

    public function isAdmin()
    {
        if ($this->roles()->where('name', 'Admin')->exists()) {
            return true;
        }
        return false;
    }
    
     public function promo()
    {
          return $this->belongsToMany(Promo::class,'promo_user','user_id','promo_id');
    } 
   
    
    public function cart()
    {
        return $this->hasOne('App\Cart');
    }
    
    public function getCart()
    {
        return $this->cart()->firstOrCreate(['user_id' => $this->id, 'state' => 0]);
    }
    
    public function orders()
    {
        return $this->hasMany(Orders::class);
    }
    
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}

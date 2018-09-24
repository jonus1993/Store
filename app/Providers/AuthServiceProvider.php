<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Policies\ModeratorPolicy;
use App\RolesHasUsers;
use App\User;

class AuthServiceProvider extends ServiceProvider
{

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
//        'App\User' => ModeratorPolicy::class,
          User::class => ModeratorPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    
    public function boot()
    {
        $this->registerPolicies();
        
        Gate::define('delete', 'App\Policies\ModeratorPolicy@delete');
        //gate - decyduje czy użytkownik może się dostać do sekcji dla moderatorów
        Gate::define('moderator-allowed', function ($user) {

            $role = $user->roles()->get()->toArray();

            if (!!array_intersect(["Admin", "Modeartor"], array_column($role, 'name'))) {
                return true;
            } else {
                return false;
            }
        });
    }
}

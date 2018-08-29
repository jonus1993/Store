<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Policies\ModeratorPolicy;
use App\RolesHasUsers;
use App\User;

class AuthServiceProvider extends ServiceProvider {

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
    
    public function boot() {
        $this->registerPolicies();
        
           Gate::define('delete', 'App\Policies\ModeratorPolicy@delete');
        //gate - decyduje czy użytkownik może się dostać do sekcji dla moderatorów 
        Gate::define('moderator-allowed', function ($user) {
            $user = RolesHasUsers::where('users_id', $user->id)->get()->toArray();

            if (!!array_intersect([1, 2], array_column($user, 'roles_id')))
                return true;
            else
                return false;
        });
    }

}

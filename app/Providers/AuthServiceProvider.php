<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Policies\ModeratorPolicy;
use App\RolesHasUsers;

class AuthServiceProvider extends ServiceProvider {

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        'App\User' => ModeratorPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot() {
        $this->registerPolicies();

        Gate::define('moderator-allowed', function ($user) {
            $user = RolesHasUsers::where('users_id', $user->id)->get()->toArray();

            if (!!array_intersect([1, 2], array_column($user, 'roles_id')))
                return true;
            else
                return false;
        });

        Gate::define('change-item', function ($user) {
            $user = RolesHasUsers::where('users_id', $user->id)->get()->toArray();
            dd($user);
            if (in_array(1, array_column($user, 'roles_id')))
                return true;
            else
                return false;
        });
    }

}

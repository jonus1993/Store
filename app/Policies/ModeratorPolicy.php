<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\RolesHasUsers;

class ModeratorPolicy {

    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    public function delete(User $user) {
        $user = RolesHasUsers::where('users_id', $user->id)->get()->toArray();
//        dd($user);
        if (in_array(1, array_column($user, 'roles_id')))
            return true;
        else
            return false;
    }

}

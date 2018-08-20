<?php

namespace App\Policies;
use App\RolesHasUsers;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

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

    //polityka mówi, że tylko admin może usuwać przedmioty
    public function delete(User $user) {
        $user = RolesHasUsers::where('users_id', $user->id)->get()->toArray();

        if (in_array(1, array_column($user, 'roles_id')))
            return true;
        else
            return false;
    }

}

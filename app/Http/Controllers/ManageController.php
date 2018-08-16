<?php

namespace App\Http\Controllers;

use App\User;
use App\RolesHasUsers;

class ManageController extends Controller {

    public function getUserslist() {

        $users = User::with('roles')->get();
//        dd($users);
        return view('manage', compact('users'));
    }

    public function deleteUser($userid) {

        User::where('id', '$userid')->delete();
        $this->getUserslist();
    }

    public function upUser($userid, $who) {
        $user = new RolesHasUsers();
        $user->user_id = $userid;
        $user->roles_id = $who;
        $user->save();
        $this->getUserslist();
    }

    public function downUser($userid, $who) {



        RolesHasUsers::where('user_id', $userid)->where('role_id', $who)->delete();
        $this->getUserslist();
    }

}

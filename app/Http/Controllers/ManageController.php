<?php

namespace App\Http\Controllers;

use App\User;
use App\RolesHasUsers;
use App\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class ManageController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function getUserslist() {
//        return Auth::user()->id;
        $roles = Roles::all();
        $users = User::with('roles')->get();
//        dd($users);
        return view('manage', compact('users', 'roles'));
    }

    public function deleteUser($userid) {

        User::where('id', '$userid')->delete();
        $this->getUserslist();
    }

    public function changeUser(Request $request, $userid) {

        $request->validate([
            'roles' => 'bail|required',
        ]);

        RolesHasUsers::where('users_id', $userid)->delete();
        $roles = $request->input('roles');
        foreach ($roles as $roleID) {
            $user = new RolesHasUsers();
            $user->users_id = $userid;
            $user->roles_id = $roleID;
            $user->save();
        }

        Session::flash('message', "Pomyślnie zmieniono uprawnienia");
        return redirect(route('manage'));
    }

    public function showAllorders() {

        $guests = DB::table('guests_orders')->select('id', 'total_cost', 'total_items', 'created_at', DB::raw('"guest" AS new_column'));

        $orders = DB::table('orders')
                ->select('id', 'total_cost', 'total_items', 'created_at', DB::raw('"user" AS new_column'))
                ->union($guests)->get();
                
//        dd($orders);

        return view('orders.allOrders', compact('orders'));
    }

}

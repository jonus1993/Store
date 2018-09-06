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

        $roles = Roles::all();
        $users = User::with('roles')->get();

        return view('manage', compact('users', 'roles'));
    }

    public function deleteUser(User $user) {

        $user->delete();
        return $this->getUserslist();
        
    }

    public function changeUser(Request $request) {

        $request->validate([
            'users_id' => 'bail|required',
            'roles_id' => 'required'
        ]);
        
        $userID = $request->users_id;
        $roles = $request->get('roles_id');
        RolesHasUsers::where('users_id',$userID )->delete();

        foreach ($roles as $roleID) {
            $user = new RolesHasUsers();
            $user->users_id = $userID;
            $user->roles_id = $roleID;
            $user->save();
        }
        
          if (request()->expectsJson()) {
            return response("Change was made");
        }

        Session::flash('message', trans('messages.userRoleChanged'));
        return redirect(route('manage'));
    }
    
    

    public function showAllorders() {

        $guests = DB::table('guests_orders')->select('id', 'total_cost', 'total_items', 'created_at', DB::raw('"guest" AS new_column'));

        $orders = DB::table('orders')
                        ->select('id', 'total_cost', 'total_items', 'created_at', DB::raw('"user" AS new_column'))
                        ->union($guests)->get();


        return view('orders.allOrders', compact('orders'));
    }

}

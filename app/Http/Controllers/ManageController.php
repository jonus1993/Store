<?php

namespace App\Http\Controllers;

use App\User;
use App\Roles;
use App\Orders;
use App\Items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ManageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function getUserslist()
    {
        $roles = Roles::all();
        $users = User::withTrashed()->with('roles')->get();

        return view('manage', compact('users', 'roles'));
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        return $this->getUserslist();
    }

    public function changeUser(Request $request)
    {
        $request->validate([
            'users_id' => 'bail|required|numeric',
            'roles_id' => 'required',
             array('roles_id' => 'numericarray'),
        ]);
    
        $user = User::withTrashed()->find($request->users_id);
        $user->roles()->detach();
        $roles = $request->get('roles_id');

        foreach ($roles as $roleID) {
            $user->roles()->attach($roleID);
        }

        if (request()->expectsJson()) {
            return response("Change was made");
        }

        Session::flash('message', trans('messages.userRoleChanged'));
        return redirect(route('manage'));
    }

    public function showAllorders()
    {
        $orders = Orders::all();

        return view('orders.allOrders', compact('orders'));
    }
    
    public function showOrder(Orders $order)
    {
        $order = $order->cart()->first()->items()->get();
       
        return view('orders.Order', compact('order'));
    }
    
    public function getOrderInfo(Request $request)
    {
        $item = Items::find($request->id);
        $orders = $item->cart()->get();
      
        return view('orders.table', compact('orders'));
    }
}

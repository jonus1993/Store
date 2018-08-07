<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Address;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAddresses() {
        $userid = auth()->id();
        return Address::where('user_id', '=', $userid)->get();
    }

    public function index() {

        $addresses = $this->getAddresses();
//        dd($addresses);
        return view('home', compact('addresses'));
    }

}

<?php

namespace App\Http\Controllers;


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
    public function __invoke() {
        return redirect('/home2');
        $addresses = new Address();
        $addresses = $addresses->getAddresses();
        return view('home', compact('addresses'));
    }

}

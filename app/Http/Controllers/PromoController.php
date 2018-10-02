<?php

namespace App\Http\Controllers;

use App\Promo;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promos = Promo::withTrashed()->with('item')->get();

        return view('manage.discounts', compact('promos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $promo = Promo::withTrashed()->find($id);
        return view('manage.promo', compact('promo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'start_date' => 'bail|date|nullable',
            'end_date' => 'date|nullable',
            'start_order' => 'numeric|nullable',
            'end_order' => 'numeric|nullable',
        ]);
        
        $input = $request->all();
        if ($input['start_order']<$input['end_order']) {
            $users = User::whereHas('orders', function ($q) use ($input) {
                $q->whereBetween('total_cost', [$input['start_order'],$input['end_order']]);
            })->get();
        } else {
            $users = User::all();
        }                
        
        if ($input['start_date'] != null) {
            $users = $users->where('created_at', '>', $input['start_date']);
        }
        if ($input['end_date'] != null) {
            $users = $users->where('created_at', '<', $input['end_date']);
        }
        
        $usersIDs = $users->pluck('id')->toArray();

        $promo = Promo::find($id);
        $promo->user()->syncWithoutDetaching($usersIDs);
        
        return redirect()->route('promo.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Promo::destroy($id);

        return redirect()->route('promo.index');
    }

    public function restore($id)
    {
        Promo::withTrashed()->find($id)->restore();

        return redirect()->route('promo.index');
    }
}

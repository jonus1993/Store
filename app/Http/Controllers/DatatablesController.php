<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use App\Items;


class DatatablesController extends Controller
{
    
    
    public function getIndex()
    {
       

        return view('items.index2');
    }
    
    public function anyData()
{
     $items = Items::select(['id','name','price']);
             
//             ->limit(10)
//             ->get()->toArray();
//     
//     dd($items);
        return Datatables::of($items)->make();
}
    public function getItems()
    {
       $itemas = DB::table('items')->get();

        return view('items.index3', ['items' => $itemas]);

      
    }
    
}

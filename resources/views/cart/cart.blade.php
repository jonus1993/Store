@extends('layouts.master')
@section('title')
    DB Store Cart
@endsection
@section('content')

    <table class="table table-hover">
        <tr>
            <th>NAME</th>
            <th>QUANTATY</th>
            <th>PRICE</th>

            <th>DELETE</th>
        </tr>
         
        @foreach($cart_items as $item)
  
            <tr>
                <td>{{ $item->item->name }}</td>
                <td>{{ $item['qty'] }}</td>
                <td>{{ $item->item->price*$item['qty'] }}</td>
                <td><a class="btn btn-info" href="{{route('item2.delFromCart', ['id' => $item->item->id])}}">DELETE</a></td>

            </tr>
        @endforeach
         <tr>
                <td>TOTAL</td>
                <td>{{ $totalQty }}</td>
                <td>{{ $totalPrice }}</td>
                <td><a class="btn btn-info" href="{{route('item2.delFromCart', ['id' => 0])}}">DELETE ALL</a></td>

            </tr>
        
    </table>
   <div style="float: right;"><a class="btn btn-success" href="{{ route('checkout2') }}">CHECKOUT</a></div>

@endsection
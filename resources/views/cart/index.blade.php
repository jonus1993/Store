@extends('layouts.master')
@section('title')
    Store Cart
@endsection
@section('content')




@if(Session::has('cart'))
    <table class="table table-hover">
        <tr>
            <th>NAME</th>
            <th>QUANTATY</th>
            <th>PRICE</th>

            <th>DELETE</th>
        </tr>
        @foreach($items as $item)
            <tr>
                <td>{{ $item['item']['name'] }}</td>
                <td>{{ $item['qty'] }}</td>
                <td>{{ $item['price'] }}</td>
                <td><a class="btn btn-info" href="#">DELETE</a></td>

            </tr>
        @endforeach
    </table>
   <div style="float: right;"><a class="btn btn-success" href="{{ route('checkout') }}">CHECKOUT</a></div>


@else
   <h1>nic</h1>
@endif
@endsection
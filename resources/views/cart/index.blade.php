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
        <td><a class="btn btn-info" href="{{ route('item.sesdelete', ['item' => $item['item']])}}">DELETE</a></td>

    </tr>
    @endforeach
    <tr>
        <td>TOTAL</td>
        <td>{{ $totalQty }}</td>
        <td>{{ $totalPrice }}</td>
        <td><a id="del" class="btn btn-info" href="{{ route('forgetCart')}}">DELETE ALL</a></td>

    </tr>


</table>
<div style="float: right;"><a class="btn btn-success" href="{{ route('checkout') }}">CHECKOUT</a></div>


@else
<h1>Your Cart is empty, go back...</h1>
@endif
@endsection

@section('scripts')
<script
    src="https://code.jquery.com/jquery-3.3.1.js"
    integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
crossorigin="anonymous"></script>

<!--//usuwanie przez jquery-->
<script>
$(document).ready(function () {
    $("#del").click(function () {
        var isGood = confirm('Are You Sure?');
        if (isGood) {
            $.get(" {{route('forgetCart')}} ", function (data) {
            });
        }
    });
});
</script>
@endsection

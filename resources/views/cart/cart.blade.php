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
        <td><a class="btn btn-info" href="{{route('item2.delFromCart', $item)}}">DELETE</a></td>

    </tr>
    @endforeach
    <tr>
        <td>TOTAL</td>
        <td>{{ $totalQty }}</td>
        <td>{{ $totalPrice }}</td>
        <td><a id="del" class="btn btn-info" href="">DELETE ALL</a></td>

    </tr>
</table>
<div style="float: right;"><a  class="btn btn-success" href="{{ route('checkout2') }}">CHECKOUT</a></div>

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
            $.get(" {{route('delete.cart')}} ", function (data) {
            });
        }
    });
});
</script>
@endsection
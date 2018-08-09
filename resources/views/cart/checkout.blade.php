@extends('layouts.master')
@section('title')
Checkout
@endsection
@section('content')
<h1>Finish your order!</h1>
@if ($errors->any())
<h4 style="color: red">Something wents wrong... check it!</h4>
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<form action="{{route('finishOrder')}}" method="post">
    @csrf
    @php($i = 1)
 

    <div class="row">
        @foreach($addresses as $address)

        <address class="rounded border border-primary col-md-3">
            <input checked="checked" type="radio" name="address" value="{{$address['id']}}">
            <strong>Address {{$address['id']}}</strong><br>
            Street: {{$address['street']}} <br>
            City: {{$address['city']}} <br>
            Zip Code: {{$address['zip_code']}} <br>
            Phone: {{$address['phone']}} <br>
        </address>
        @endforeach
    </div>
    <table class="table table-hover">
        <tr>
            <th>NAME</th>
            <th>QUANTATY</th>
            <th>PRICE</th>
        </tr>


        @foreach($cart['cart_items'] as $cart_item)

        <tr>
            <td>{{ $cart_item->item->name }}</td>
            <td>{{ $cart_item->qty }}</td>
            <td>{{ $cart_item->item->price }}</td>
        </tr>

        @endforeach
        <tr>
            <th>TOTAL</th>
            <th>{{ $cart['totalQty'] }}</th>
            <th>{{ $cart['totalPrice'] }}</th>
        </tr>
    </table>


    <div style="float: right;">
        <button class="btn btn-success" type="submit">MAKE ORDER</button></div>

</form>
@endsection
@extends('layouts.master')
@section('title')
Checkout order
@endsection
@section('content')
<h1>Finish the order</h1>
<h4>Total: ${{ $total }}</h4>

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
<form action="{{route('checkout')}}" method="post">
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control" name="name" id="who" required="">
    </div>
    <div class="form-group">
        <label for="street">Street address:</label>
        <input type="text" class="form-control" name="street" id="street" required="">
    </div>
    <div class="form-group">
        <label for="city">City:</label>
        <input type="text" class="form-control" name="city" id="city" required="">
    </div>
    <div class="form-group">
        <label for="zipcode">Zip-code:</label>
        <input type="text" class="form-control" name="zip_code" id="zipcode" required="">
    </div>
    <div class="form-group">
        <label for="phone">Phone:</label>
        <input type="text" class="form-control" name="phone" id="phone" required="">
    </div>
    {{ csrf_field() }}
    <button type="submit" class="btn btn-primary">Make an Order</button>
</form>

@endsection
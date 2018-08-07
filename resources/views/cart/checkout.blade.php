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
<form action="" method="post">
    @csrf


    <div class="row">
        @foreach($addresses as $address)
        <input type="radio" name="address" value="{{$address['id']}}">
        <address class="col-md-3">
            <strong>Address {{$address['id']}}</strong><br>
            Street: {{$address['street']}} <br>
            City: {{$address['city']}} <br>
            Zip Code: {{$address['zip_code']}} <br>
            Phone: {{$address['phone']}} <br>
        </address>
        @endforeach
    </div>




<!--    <div class="form-group">
        <label for="street">Street address:</label>
        <input type="text" class="form-control" name="street" id="street" value="{{$address->street}}">
    </div>
    <div class="form-group">
        <label for="city">City:</label>
        <input type="text" class="form-control" name="city" id="city" value="{{$address->city}}">
    </div>
    <div class="form-group">
        <label for="zipcode">Zip-code:</label>
        <input type="text" class="form-control" name="zipcode" id="zipcode" value="{{$address->zip_code}}">
    </div>
    <div class="form-group">
        <label for="phone">Phone:</label>
        <input type="text" class="form-control" name="phone" id="phone" value="{{$address->phone}}">
    </div>
    {{ csrf_field() }}
    <button type="submit" class="btn btn-primary">Edit</button>-->

</form>
@endsection
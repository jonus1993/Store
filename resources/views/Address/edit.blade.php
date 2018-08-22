@extends('layouts.master')
@section('title')
Edit Address
@endsection
@section('content')
<h1>Edit Your Address</h1>
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
<form action="{{route('address.edit',$address->id)}}" method="post">
    @csrf
    <div class="form-group">
        <label for="street">Street address:</label>
        <input type="text" class="form-control" name="street" id="street" value="{{$address->street}}">
    </div>
    <div class="form-group">
        <label for="city">City:</label>
        <input type="text" class="form-control" name="city" id="city" value="{{$address->city}}">
    </div>
    <div class="form-group">
        <label for="zip_code">Zip-code:</label>
        <input type="text" class="form-control" name="zip_code" id="zip_code" value="{{$address->zip_code}}">
    </div>
    <div class="form-group">
        <label for="phone">Phone:</label>
        <input type="text" class="form-control" name="phone" id="phone" value="{{$address->phone}}">
    </div>
    <!--{{ csrf_field() }}-->
    <button type="submit" class="btn btn-primary">Edit</button>
    
</form>
@endsection
@extends('layouts.master')
@section('title')
    Add Address
@endsection
@section('content')
    <form action="{{route('address.add')}}" method="post">
        
        <div class="form-group">
            <label for="street">Street address:</label>
            <input type="text" class="form-control" name="street" id="street">
        </div>
        <div class="form-group">
            <label for="city">City:</label>
            <input type="text" class="form-control" name="city" id="city">
        </div>
        <div class="form-group">
            <label for="zipcode">Zip-code:</label>
            <input type="number" class="form-control" name="zipcode" id="zipcode">
        </div>
        {{ csrf_field() }}
        <button type="submit" class="btn btn-primary">Add</button>
        
    </form>
@endsection
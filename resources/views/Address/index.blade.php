@extends('layouts.master')
@section('title')
    Add Address
@endsection
@section('content')
<h1>Add Your New Address</h1>
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
    <form action="{{route('address.store')}}" method="post">
        @csrf
        <input type=hidden name="last_url" value="{{old('last_url', URL::previous())}}" >
        <div class="form-group">
            <label for="street">Street address:</label>
            <input type="text" class="form-control" name="street" id="street">
        </div>
        <div class="form-group">
            <label for="city">City:</label>
            <input type="text" class="form-control" name="city" id="city">
        </div>
        <div class="form-group">
            <label for="zip_code">Zip-code:</label>
            <input type="text" class="form-control" name="zip_code" id="zip_code">
        </div>
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" class="form-control" name="phone" id="phone">
        </div>

        <button type="submit" class="btn btn-primary">Add</button>
        
    </form>
@endsection
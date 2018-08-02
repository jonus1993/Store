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
    <form action="{{route('address.add')}}" method="post">
        @csrf
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
        <!--{{ csrf_field() }}-->
        <button type="submit" class="btn btn-primary">Add</button>
        
    </form>
@endsection
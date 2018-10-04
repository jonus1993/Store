@extends('layouts.master')
@section('title', 'Add Address')
@section('breadcrumb')
{{ Breadcrumbs::render('addAddress') }}
@endsection
@section('content')
<h1>Add Your New Address</h1>
<!--wyświetlnia wiadomości-->
@if (Session::has('message'))
<div id="message" class="alert alert-info">{{ Session::get('message') }}</div>
@endif

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
     
        <input type=hidden name="last_url" value="{{old('last_url', URL::previous())}}" >
              <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}" required>
    </div>
    <div class="form-group">
        <label for="street">Street address:</label>
        <input type="text" class="form-control" name="street" id="street" value="{{old('street')}}" required>
    </div>
    <div class="form-group">
        <label for="city">City:</label>
        <input type="text" class="form-control" name="city" id="city" value="{{old('city')}}" required>
    </div>
    <div class="form-group">
        <label for="zipcode">Zip-code:</label>
        <input type="text" class="form-control" name="zip_code" id="zip_code" value="{{old('zip_code')}}" required>
    </div>
    <div class="form-group">
        <label for="phone">Phone:</label>
        <input type="text" class="form-control" name="phone" id="phone" value="{{old('phone')}}" required>
    </div>
    {{ csrf_field() }}

        <button type="submit" class="btn btn-primary">Add</button>
        
    </form>
@endsection
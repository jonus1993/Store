@extends('layouts.master')
@section('title')
Edit Address
@endsection
@section('breadcrumb')
{{ Breadcrumbs::render('editAddress',$address) }}
@endsection
@section('content')
<h1>Edit Your Address</h1>
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
<form action="{{route('address.update',$address->id)}}" method="post">
      @csrf
            <input name="_method" type="hidden" value="PUT">

        <input name="addressID" type="hidden" class="form-control" value="address{{$address->id}}">
        <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control" name="name" id="name" value="{{$address->name}}" required>
		</div>
        <div class="form-group">
            <label for="street">Street address:</label>
            <input type="text" class="form-control" name="street" id="street" value="{{$address->street}}" required>
        </div>
        <div class="form-group">
            <label for="city">City:</label>
            <input type="text" class="form-control" name="city" id="city" value="{{$address->city}}" required>
        </div>
        <div class="form-group">
            <label for="zip_code">Zip-code:</label>
            <input type="text" class="form-control" name="zip_code" id="zip_code" value="{{$address->zip_code}}" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" class="form-control" name="phone" id="phone" value="{{$address->phone}}" required>
        </div>

    <button type="submit" class="btn btn-primary">Edit</button>

</form>
@endsection

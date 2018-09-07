@extends('layouts.master')
@section('title')
Home
@endsection
@section('content')


<!--wyświetlnia wiadomości-->
@if (Session::has('message'))
<div id="message" class="alert alert-info">{{ Session::get('message') }}</div>
@endif
<div id="addresses" class="row">
    @foreach($addresses as $address)
    <address class="col-md-3">
        <strong>Address {{$address['id']}}</strong><br>
        Street: {{$address['street']}} <br>
        City: {{$address['city']}} <br>
        Zip Code: {{$address['zip_code']}} <br>
        Phone: {{$address['phone']}} <br>

        <div class="row">
            &emsp;
            {{ Form::open(['route' => ['address.destroy', $address->id], 'method' => 'delete']) }}
            <button class="btn btn-danger btn-sm" type="submit">DELETE</button>
            {{ Form::close() }}
            &emsp;
            <a class="btn btn-success btn-sm" href="{{route('address.edit', $address['id']) }}">EDIT</a>
        </div>
    </address>
    @endforeach
</div>
<a class="btn btn-primary" href="{{ route('address.create') }}">Add Address</a>

@endsection

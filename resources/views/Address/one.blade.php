@extends('layouts.master')
@section('title', 'one Address')
@section('content')
<address class="rounded border border-primary col-sm-2" id="address{{$address['id']}}">

    <label for="adrs{{$address['id']}}">
        <input id="adrs{{$address['id']}}" checked="checked" type="radio" name="address_id" value="{{$address['id']}}">
        <strong> {{$address['street']}}</strong> <br>
        City: {{$address['city']}} <br>
        Zip Code: {{$address['zip_code']}} <br>
        Phone: {{$address['phone']}} <br>
    </label>

</address>
@endsection

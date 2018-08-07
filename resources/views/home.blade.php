@extends('layouts.master')
@section('title')
Home
@endsection
@section('content')



<div class="row">
    @foreach($addresses as $address)
    <address class="col-md-3">
        <strong>Address {{$address['id']}}</strong><br>
        Street: {{$address['street']}} <br>
        City: {{$address['city']}} <br>
        Zip Code: {{$address['zip_code']}} <br>
        Phone: {{$address['phone']}} <br>
       
        <!--<button id="delbtn" value="{{$address['id']}}"  class="btn btn-danger btn-sm" >DELETE</button>-->
        {{ Form::open(['route' => ['address.del', $address->id], 'method' => 'delete']) }}
        <button class="btn btn-danger btn-sm" type="submit">DELETE</button>
        {{ Form::close() }}
         <a class="btn btn-success btn-sm" href="{{ url('/address/edit', $address['id']) }}">EDIT</a>
    </address>
    @endforeach
</div>


<a class="btn btn-primary" href="{{ url('/address') }}" >Add Address</a>
@endsection

@section('scripts')
<script>
    $('.delbtn').click(function () {
        $.ajax({
            url: '/address/del/' + $(this).val(),
            type: 'DELETE', // user.destroy
            success: function (result) {
                // Do something with the result
            }
        });
    });
</script>

@endsection

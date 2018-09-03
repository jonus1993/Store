
<div id="addresses" class="row">
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
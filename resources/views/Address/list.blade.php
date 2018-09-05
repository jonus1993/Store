<div id="addresses" class="row">
    @foreach($addresses as $address)
    <address class="col-md-3">
        <strong>Address {{$address['id']}}</strong><br>
        Street: {{$address['street']}} <br>
        City: {{$address['city']}} <br>
        Zip Code: {{$address['zip_code']}} <br>
        Phone: {{$address['phone']}} <br>

        <div class="row">
            <button data-field="{{$address['id']}}" class="delAddresses btn btn-danger btn-sm">
                <img src="{{url('/open-iconic/svg/trash.svg')}}" alt="icon name">
            </button>

            <a class="btn btn-success btn-sm" href="{{ url('/address/edit', $address['id']) }}"> <img src="{{url('/open-iconic/svg/brush.svg')}}" alt="icon name">
            </a>
        </div>
    </address>
    @endforeach
</div>

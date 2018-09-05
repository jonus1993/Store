
    <address id="address{{$address['id']}}" class="col-md-3">
        <strong>Address {{$address['id']}}</strong><br>
        Street: {{$address['street']}} <br>
        City: {{$address['city']}} <br>
        Zip Code: {{$address['zip_code']}} <br>
        Phone: {{$address['phone']}} <br>

        <div class="row">
            <button data-field="{{$address['id']}}" class="delAddresses btn btn-danger btn-sm">
                <img src="{{url('/open-iconic/svg/trash.svg')}}" alt="icon name">
            </button>
            <button data-field="{{$address['id']}}" class="editAddresses btn btn-success btn-sm">
                <img src="{{url('/open-iconic/svg/brush.svg')}}" alt="icon name">

            </button>
        </div>
    </address>
   

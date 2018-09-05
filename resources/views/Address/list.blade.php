
    @foreach($addresses as $address)
        @include('Address.list_item', ['address' => $address])
     @endforeach

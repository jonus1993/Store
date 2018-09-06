
    <address  class="rounded border border-primary col-sm-2" id="address{{$address['id']}}">

    <label for="adrs{{$address['id']}}">
     <input id="adrs{{$address['id']}}" checked="checked" type="radio" name="address_id" value="{{$address['id']}}">
    <strong>  {{$address['street']}}</strong> <br>
    City: {{$address['city']}} <br>
    Zip Code: {{$address['zip_code']}} <br>
    Phone: {{$address['phone']}} <br>
   </label>
   
    
        <button style="width:100%;" data-field="{{$address['id']}}" class="delAddresses btn btn-danger ">
            <img src="{{url('/open-iconic/svg/trash.svg')}}" alt="icon name">
        </button>
        <button style="width:100%;" data-field="{{$address['id']}}" class="editAddresses btn btn-success ">
            <img src="{{url('/open-iconic/svg/brush.svg')}}" alt="icon name">

        </button>
  
</address>

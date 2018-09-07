@extends('layouts.master')
@section('title', 'Checkout')
@section('styles')
<style>
body {background-color: powderblue;}
h1   {color: blue;}
</style>
@endsection
@section('content')
<h1>Finish your order!</h1>
@if ($errors->any())

    <div class="alert alert-danger">
       <h4 style="color: red">Need to put an address.</h4>
</div>
@endif


<div id="addressnfo" class="alert alert-info" style="display: none;">
    <span></span>
</div>
<div> <br>
    <button id="ajaxaddressbtn" class="btn btn-primary">Add AJAX Address</button>
    <br><br>
</div>

<div id="addressDivForm"></div>

<form action="{{route('finishOrder')}}" method="post">
    @csrf
    <div id="addresses" class="row"></div>
    <p></p>
    <table class="table table-hover">
        <tr>
            <th>NAME</th>
            <th>QUANTATY</th>
            <th>PRICE</th>
        </tr>

        @foreach($cart['cart_items'] as $cart_item)
        <tr>
            <td>{{ $cart_item->item->name }}</td>
            <td>{{ $cart_item->qty }}</td>
            <td>{{ $cart_item->item->price }}</td>
        </tr>
        @endforeach
        <tr>
            <th>TOTAL</th>
            <th>{{ $cart['totalQty'] }}</th>
            <th>{{ $cart['totalPrice'] }}</th>
        </tr>
    </table>

    <div style="float: right;">
        <button class="btn btn-success" type="submit">MAKE ORDER</button></div>

</form>

@stop

@push('scripts')
<script src="http://malsup.github.com/jquery.form.js"></script>

<script>
    function getForm() {
        $.get("{{route('home2.form')}}", function(data) {
            $('#addressDivForm').html(data);
            $("#ajaxaddressbtn").attr("disabled", true);
        });
    }

    function getAllAddresses() {
        $.get("{{route('address.index')}}", function(data) {
            $('#addresses').html(data);
        });
    }

</script>



<script>
    $(document).ready(function() {
        getAllAddresses();

        $("#ajaxaddressbtn").click(function() {
            getForm();
        });

    });


    $(document).on('click', 'button.delAddresses', function() {
        var $this = $(this);
        var addressID = $this.attr('data-field');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ url('address') }}" + '/' + addressID,
            type: 'DELETE',
            success: function(data) {
                $("#addressnfo").show().delay(125).hide(1000).children("span").text(data);

                $this.parents('address:first').remove();
            }
        });
        return false;
    });


    $(document).on('click', 'button.editAddresses', function() {

        var addressID = $(this).attr('data-field');
        var url = "{{route('address.edit',':id')}}";
        url = url.replace(':id',addressID);

        $.get(url, function(data) {
            $('#addressDivForm').html(data);

        });
        return false;
    });

</script>



@endpush

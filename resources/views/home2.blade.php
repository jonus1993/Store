@extends('layouts.master')
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('title')
Home
@endsection

@section('content')


<div id="allAddresses">

</div>

<button id="ajaxaddressbtn" class="btn btn-primary">Add AJAX Address</button>


<div id="addressDivForm">

</div>


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
        $.get("{{route('home2.data')}}", function(data) {
            $('#allAddresses').html(data);
            putDelBtn();


        });


    }



    function putDelBtn() {

        $(".delAddresses").on('click', function() {

            var addressID = $(this).attr('data-field');
            console.log(addressID);
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                url: "{{url('address/del')}}" + '/' + addressID,
                type: 'DELETE',
                success: function() {
                    getAllAddresses();
                }


            });

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

</script>



@endpush

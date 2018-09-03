@extends('layouts.master')
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

    function getAllAddresses() {
        $.get("{{route('home2.data')}}", function (data) {
            $('#allAddresses').html(data);
        });
    }

    function getForm() {
        $.get("{{route('home2.form')}}", function (data) {
            $('#addressDivForm').html(data);
        $("#ajaxaddressbtn").attr("disabled", true);
        });
    }

</script>



<script>
    $(document).ready(function () {
        getAllAddresses();

        $("#ajaxaddressbtn").click(function () {
            getForm();
        });

    });
</script>



@endpush
@extends('layouts.master')
@section('title', 'hone')

@section('content')
<div id="addressnfo" class="alert alert-info" style="display: none;">
    <span></span>
</div>
<div> <br>
    <button id="ajaxaddressbtn" class="btn btn-primary">Add AJAX Address</button>
    <br><br>
</div>

<div id="addressDivForm"></div>

<div id="addresses" class="row"></div>




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
            url: "{{ url('address/del') }}" + '/' + addressID,
            type: 'DELETE',
            success: function(data) {
                $("#addressnfo").show().delay(125).hide(1000).children("span").text(data);

                $this.parents('address:first').remove();
            }
        });

    });


    $(document).on('click', 'button.editAddresses', function() {

        var addressID = $(this).attr('data-field');
        $.get("{{url('address/edit')}}" + '/' + addressID, function(data) {
            $('#addressDivForm').html(data);

        });
    });

</script>



@endpush

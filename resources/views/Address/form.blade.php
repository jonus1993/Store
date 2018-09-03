<!--wyświetlnia wiadomości-->
@if (Session::has('message'))
<div id="message" class="alert alert-info">{{ Session::get('message') }}</div>
@endif
<h1>Add Your New Address</h1>
<div id="errors">

</div>


<form id="addressForm" action="{{route('address2.add')}}" method="post">

    <div class="form-group">
        <label for="street">Street address:</label>
        <input type="text" class="form-control{{ $errors->has('street') ? ' invalid-feedback' : ''}}" name="street" id="street">

    </div>

    <div class="form-group">
        <label for="city">City:</label>
        <input type="text" class="form-control" name="city" id="city">
    </div>
    <div class="form-group">
        <label for="zip_code">Zip-code:</label>
        <input type="text" class="form-control" name="zip_code" id="zip_code">
    </div>
    <div class="form-group">
        <label for="phone">Phone:</label>
        <input type="text" class="form-control" name="phone" id="phone">
    </div>
    {{ csrf_field() }}
    <input id="submitbtn" type="submit"  class="btn btn-primary" value="Add Address" /> 

</form>



<script>
    $(document).ready(function () {
        var options = {

            success: function () {
                getAllAddresses();
                getForm();
            },

            error: function (data) {
                $('.invalid-feedback').removeClass('invalid-feedback');
                var errors = data.responseJSON.errors;
                console.log(errors);
                
                var html = '';
                for (var e in errors) {
                    console.log(e);
                    $('input[name='+e+']').addClass('invalid-feedback');
                    
                    console.log($('input[name='+e+']'));
                    html += errors[e][0];
                }
                
                $('#errors').html(html);
                
//                $.get('{{url("home2/errors")}}' + '/', function (data2) {
//                    $('#errors').html(data2);
//                });

            }

        };

        $("#addressForm").ajaxForm(options);
    });
</script>


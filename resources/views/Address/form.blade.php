<!--wyświetlnia wiadomości-->
@if (Session::has('message'))
<div id="message" class="alert alert-info">{{ Session::get('message') }}</div>
@endif
<h1>Add Your New Address</h1>
<div id="errors">  </div>


<form id="addressForm" action="{{route('address2.add')}}" method="post">

    <div class="form-group">
        <label for="street">Street address:</label>
        <input type="text" class="form-control" name="street" id="street">
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
                $('.alert alert-danger').removeClass('alert alert-danger');
                var errors = data.responseJSON.errors;

                var html = '';
                for (var e in errors) {
                    $("input[name='" + e + "']").addClass("alert alert-danger");
                    html += errors[e][0] + '<br>';
                }

                $('#errors').html(html).addClass("alert alert-danger");

            }

        };

        $("#addressForm").ajaxForm(options);
    });
</script>


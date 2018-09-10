
<h1>Add New Colour</h1>
<div id="itemMsg" class="alert alert-info" style="display: none;">
    <span></span>
</div>
<div id="errors"> </div>
<form id="itemForm" action="{{route('item.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="name">colour name:</label>
        <input type="text" class="form-control" name="name" value="{{old('name')}}">
    </div>
    <div class="form-group">
        <label for="price">price:</label>
        <input type="number" min="0.00" max="10000.00" step="0.01" class="form-control" name="price" id="price" value="{{old('price')}}">
    </div>
    <div class="form-group">
        <label for="category">category:</label>
        <select class="form-control" name="category_id" id="category_id">
            @foreach($categories as $cat)
            <option value="{{ $cat->id }}" @if ($cat->id == old('category_id')))
                selected="selected"
                @endif
                >{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        @foreach($tags as $tag)
        <label class="checkbox-inline"><input name="tags[]" type="checkbox" value="{{ $tag->id }}">{{ $tag->name }}</label>
        @endforeach
    </div>
    <div class="form-group">
        <label for="photo">Photo</label>
        <input type="file" class="form-control-file" name="photo_name" id="photo">
    </div>
    <div style="float: right;">
        <button type="submit" class="btn btn-primary">Add</button>
    </div>
</form>


<script>
    $(document).ready(function() {

        var options = {
            success: function(data) {

                $("#itemMsg").show().delay(125).hide(1000).children("span").text("New item added!");

            },

            error: function(data) {
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
        $("#itemForm").ajaxForm(options);
    });

</script>

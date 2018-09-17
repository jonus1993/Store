@extends('layouts.master')
@section('title')
Manage Users
@endsection
@section('content')

<div class="w3-container w3-teal">
    <h1>Zarządzanie użytkownikami</h1>
</div>
@if ($errors->any())
<h4 style="color: red">Something wents wrong... check it!</h4>
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<!--wyświetlnia wiadomości-->
@if (Session::has('message'))
<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif
<table class="table table-hover">
    <tr>
        <th>ID</th>
        <th>NAME</th>
        <th>EMAIL</th>
        <th>ROLE</th>
        <th>DELETE</th>

    </tr>

    @foreach($users as $user)
    <tr>
        <td>{{ $user->id }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>
            <form class="cng" id="form-control" action="{{route('chg.user')}}" method="post">
                <input type="hidden" name="users_id" value="{{ $user->id }}">
                @foreach($roles as $role)

                <label class="checkbox-inline"><input name="roles_id[]" type="checkbox" value="{{ $role->id }}" @foreach($user->roles as $userRole)
                    @if ($role->id == old('form-control', $userRole->id))
                    checked="checked"
                    @endif
                    @endforeach
                    >{{ $role->name }}</label>

                @endforeach

                <input class="btn btn-primary" type="submit" value="MAKE" />
                {{ csrf_field() }}
            </form>
        </td>

        <td><button class="btn btn-danger" onclick="location.href='{{ route ('del.user',$user->id)}}'" {{ $user->deleted_at  ? 'disabled' : '' }}>DELETE</button>
        </td>

    </tr>
    @endforeach



</table>

<div style="float: right;">
    <button id="makeAll" type="button" class="btn btn-dark" disabled>MAKE ALL</button>
</div>
@stop

@push('scripts')
<script src="http://malsup.github.com/jquery.form.js"></script>
<script>
    $(document).ready(function() {

        $('input').on('change', function() {
            $("#makeAll").attr("disabled", false);
        });


        var options = {

            success: function(data) {

                if (state == true) {
                    alert(data);
                    state = false;
                }
            },

            error: function() {
                alert("One of roles has to be checked!");

            }

        };

        $('#makeAll').on('click', function() {
            state = true;
            $("form.cng").each(function() {
                $(this).ajaxSubmit(options);
            });
            state = true;
        });

    });

</script>

@endpush

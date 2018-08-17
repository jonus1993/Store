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
        <td>{{ $user->name  }}</td>
        <td>{{ $user->email }}</td>
        <td>

            <form id="form-control" action="{{route('chg.user', $user->id)}}" method="get">
                @foreach($roles as $role)

                <label class="checkbox-inline"><input name="roles[]" type="checkbox" value="{{ $role->id }}"
                                                      @foreach($user->roles as $userRole)
                                                      @if ($role->id == old('form-control', $userRole->id))
                                                      checked="checked"
                                                      @endif
                                                      @endforeach
                                                      >{{ $role->name }}</label>



                @endforeach
                <button type="submit">MAKE</button>
            </form>
        </td>
        <td><a href="{{ route ('del.user',$user->id)}}">DELETE</a> </td>

    </tr>
    @endforeach
</table>

@endsection
@extends('layouts.master')
@section('title')
Manage Users
@endsection
@section('content')

    <div class="w3-container w3-teal">
        <h1>Zarządzanie użytkownikami</h1>
    </div>
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
            <td>{{ $user['roles']->name }}
            <td><a href="{{ route ('del.user',$user->id)}}"></a> </td>
            
        </tr>
        @endforeach
    </table>

@endsection
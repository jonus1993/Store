@extends('layouts.master')
@section('title')
    Home
@endsection
@section('content')
    <a href="{{ url('/address') }}" class="btn btn-dark">My Address</a>
@endsection

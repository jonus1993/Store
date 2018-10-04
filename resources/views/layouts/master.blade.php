<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Colours - @yield('title')</title>


    
    <link rel="stylesheet" href="{{url('/css/bootstrap.min.css')}}">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="{{url('/js/bootstrap.min.js')}}"></script>


<script src="{{url('/js/jquery-3.3.1.min.js')}}"></script>
    @yield('head')
    <style>
body {background-color: powderblue;}
h1   {color: blue;}

    @yield('styles')
</style>


</head>


<body>
    @include('partials.header')
    @yield('breadcrumb')
    
    @yield('sidebar')
    <div class="container">
        @yield('content')
    </div>


    @stack('scripts')
    @yield('scripts')


</body>

</html>

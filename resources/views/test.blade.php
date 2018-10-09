<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Test</title>



    <link rel="stylesheet" href="{{url('/css/bootstrap.min.css')}}">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="{{url('/js/bootstrap.min.js')}}"></script>
    <script src="{{url('/js/jquery-3.3.1.min.js')}}"></script>





</head>

<body>
    
    <form action="{{ route('sendSMS') }}" method="post">
     @csrf
<div class="form-group">
    <label for="exampleFormControlInput1">Phone no.</label>
    <input type="text" name="phone" class="form-control" id="exampleFormControlInput1" >
  </div> 
  <div class="form-group">
    <label for="exampleFormControlTextarea1">Example textarea</label>
    <textarea class="form-control" name="msg" id="exampleFormControlTextarea1" rows="3"></textarea>
     <button type="submit" class="btn btn-primary mb-2">Send msg</button>
  </div>
        
        
    </form>

    <div id="app">
        <nav-bar></nav-bar>
    </div>

    <h1>TinyMCE Quick Start Guide</h1>
    <form method="post">
        <textarea id="mytextarea">Hello, World!</textarea>
    </form>



    <script src="{{asset('js/app.js')}}"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script>

    <script>
        $(document).ready(function() {
            //            swal({
            //                title: "Good job!",
            //                text: "You clicked the button!",
            //                icon: "error",
            //                buttons: true,
            //                dangerMode: true,
            //            });



        });

        tinymce.init({
            selector: '#mytextarea'
        });

    </script>
</body>

</html>

<!--<nav class="navbar navbar-default">
    <div class="container-fluid">
         Brand and toggle get grouped for better mobile display 
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/items') }}">Items</a>
            <a class="navbar-brand" href="{{ url('/items2') }}">Items2</a>
        </div>

         Collect the nav links, forms, and other content for toggling 
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                @if (Route::has('login'))

                @auth
                <li><a href="{{ url('/cart') }}"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Shopping Cart
                        <span class="badge">{{ Session::has('cart') ? Session::get('cart')->totalQty : '0' }}</span>
                    </a></li>
                <li><a href="{{ route('goToCart2') }}"><i class="fa fa-shopping-cart" aria-hidden="true"></i> DB Shopping Cart

                    </a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user" aria-hidden="true"></i> User Account <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('/home') }}">User Account</a></li>
                        <li role="separator" class="divider"></li>
                        <li> <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a></li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </ul>
                </li>

                @else
                <li> <a href="{{ route('login') }}">Login</a></li>
                <li> <a href="{{ route('register') }}">Register</a></li>
                @endauth

                @endif
            </ul>
        </div> /.navbar-collapse 
    </div> /.container-fluid 
</nav>-->

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="{{url('/')}}">Home</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">



            @if (Route::has('login'))
            
            
            @auth
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/items2') }}">Items</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('goToCart2') }}">Shopping Cart</a>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    UserAccount
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ url('/home') }}">MyAccount</a>
                    <a class="dropdown-item" href="{{ url('/allorders') }}">MyOrders</a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li> 
            @else
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/items') }}">Items2</a>
            </li>
            <!--            <li class="nav-item active">
                            <a class="nav-link" href="{{ url('/items') }}">Items <span class="sr-only">(current)</span></a>
                        </li>-->
            <li class="nav-item"> 
                <a class="nav-link" href="{{ url('/cart') }}"> Shopping Cart
                    <span class="badge">{{ Session::has('cart') ? Session::get('cart')->totalQty : '0' }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">Register</a>
            </li>


            @endauth
            @endif
            <!--      <li class="nav-item">
                    <a class="nav-link disabled" href="{{ url('/items3') }}">Items3</a>
                  </li>-->
        </ul>
        <!--    <form class="form-inline my-2 my-lg-0">
              <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>-->
    </div>
</nav>


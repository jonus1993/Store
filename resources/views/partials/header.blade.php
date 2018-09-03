<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="{{url('/')}}">Home</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">

             <li class="nav-item">
                <a class="nav-link" href="{{ url('/nbp') }}">NBP</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/items') }}">Items</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/items2') }}">ItemsDT</a>
            </li>
            @if(Route::has('login'))
            <!--jeżeli użytkownik autoryzowany-->
            @if(Auth::check())

            @can('moderator-allowed', Auth::user())
            <li class="nav-item">
                <a class="nav-link" href="{{ route('item.create') }}">ADD item</a>
            </li>
            @endcan
            <!--jeżeli użytkownik to admin -->
            @if(auth()->user()->isAdmin())
            <li class="nav-item">
                <a class="nav-link" href="{{ route('manage') }}">Manage Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('manageOrders') }}">Manage Orders</a>
            </li>
            @endif


            <li class="nav-item">
                <a class="nav-link" href="{{ route('goToCart2') }}">Shopping Cart
                   <span id="cartQty" class="badge">{{ $cartQty }}</span>
                </a>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{Auth::user()->name}}
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ url('/home') }}">MyAccount</a>
                           <a class="dropdown-item" href="{{ url('/home2') }}">MyAJAX</a>
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


            <!--jeżeli użytkownik nieautoryzowany-->
            @else
            <li class="nav-item"> 
                <a class="nav-link" href="{{ route('goToCart') }}"> Shopping Cart
                    <span class="badge">{{ Session::has('cart') ? Session::get('cart')->totalQty : '0' }}</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">Register</a>
            </li>
            @endif
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


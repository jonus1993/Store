<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="{{ url('/') }}">Main</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">

            <li class="nav-item">
                <a class="nav-link" href="{{ url('/nbp') }}">NBP</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/nbp/VUEjs') }}">NBPVUE</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('item.index') }}">Items</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('item.datatables') }}">ItemsDT</a>
            </li>

            <!--jeżeli użytkownik autoryzowany-->
            @if(Auth::check())

            <li class="nav-item">
                <a class="nav-link" href="{{ route('goToCart2') }}">Shopping Cart
                    <span id="cartQty" class="badge">{{ $cartQty }}</span>
                </a>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ Auth::user()->name }}
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('home') }}">Home</a>
                    <a class="dropdown-item" href="{{ url('/allorders') }}">MyOrders</a>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                </div>
            </li>
            @can('moderator-allowed', Auth::user())
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Manage
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('item.add') }}">Add Item</a>
                    <a class="dropdown-item" href="{{ route('moderator.panel') }}">Manage Items</a>
                    @if(auth()->user()->isAdmin())
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('manage') }}">Manage Users</a>
                    <a class="dropdown-item" href="{{ route('manageOrders') }}">Manage Orders</a>
                    <a class="dropdown-item" href="{{ route('promo.index') }}">Manage Discounts</a>

                    @endif
                </div>
            </li>
            @endcan

            <!--jeżeli użytkownik nieautoryzowany-->
            @else
            <li class="nav-item">
                <a class="nav-link" href="{{ route('goToCart') }}"> Shopping Cart
                    <span id="cartQty" class="badge">{{ Session::has('cart') ? Session::get('cart')->totalQty : '0' }}</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">Register</a>
            </li>

            @endif

        </ul>
    </div>
</nav>

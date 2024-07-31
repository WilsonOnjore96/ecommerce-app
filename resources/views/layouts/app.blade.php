<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>E-Commerce App</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="d-flex flex-column min-vh-100">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm border-bottom border-warning">
            <div class="container">
                <a class="navbar-brand text-warning" href="{{ url('/') }}">
                    <img src="{{ asset('logo/gadget_store_logo.png') }}" alt="" width="40" height="40"
                        style="border-radius: 50%; "
                        class="d-inline-block align-text-center border border-warning me-5">
                </a>
                <h2 id="store-title-heading" class="text-warning align-text-center m-auto d-inline-block">MCXXIII Store
                </h2>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                            @if (Route::has('store'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('store') }}">{{ __('Store') }}</a>
                                </li>
                            @endif


                            @if (Route::has('cart'))
                                @include('layouts.cartlink')
                            @endif
                        @else
                            @canany(['create-role', 'edit-role', 'delete-role'])
                                <li><a class="nav-link" href="{{ route('roles.index') }}">Manage Roles</a></li>
                            @endcanany
                            @canany(['create-user', 'edit-user', 'delete-user'])
                                <li><a class="nav-link" href="{{ route('users.index') }}">Users</a></li>
                            @endcanany
                            @canany(['create-category', 'edit-category', 'delete-category'])
                                <li><a class="nav-link" href="{{ route('categories.index') }}">Categories</a></li>
                            @endcanany
                            @canany(['create-product', 'edit-product', 'delete-product'])
                                <li><a class="nav-link" href="{{ route('products.index') }}">Products</a></li>
                            @endcanany

                            @canany(['view-order', 'edit-order', 'delete-order'])
                                <li><a class="nav-link" href="{{ route('orders.index') }}">Orders</a></li>
                            @endcanany

                            @canany(['create-payment', 'view-payment', 'edit-payment', 'delete-payment'])
                                <li><a class="nav-link" href="{{ route('payments.index') }}">Payments</a></li>
                            @endcanany

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>

                            <!--------global-cart-link----------->
                            @if (Auth::user()->hasRole('Customer') || Auth::user()->hasRole('Super Admin'))
                                @include('layouts.cartlink')
                            @endif
                        @endguest

                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>{{ $message }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @elseif($message = Session::get('error'))
                            <div class="alert alert-danger text-center " role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
    </div>
    <div id="footer" class="mt-auto">
            <div class="row">
                <div class="col-12 text-center bg-dark">
                    <p class="p-3 text-white">Copyright &#169; @php echo date('Y') @endphp</p>
                </div>
            </div>
    </div>

    @yield('scripts')
</body>

</html>

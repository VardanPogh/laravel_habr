<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="/fonts.gstatic.com">

    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">

    <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">

    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    @yield('css')
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">

        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
            <div class="container">
                <a href="/" class="navbar-brand">
                    <img src="{{asset('dist/img/AdminLTELogo.png')}}" alt="{{ config('app.name', 'Laravel') }}"
                        class="brand-image img-circle elevation-3" style="opacity: .8">
                    <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
                </a>


                <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}" role="button">
                            {{ __('Accesso') }}
                        </a>
                    </li>
                    @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}" role="button">
                            {{ __('Register') }}
                        </a>
                    </li>
                    @endif
                    @else


                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('agent.trasaction') }}">
                                @lang('site.transaction')
                            </a>
                            <a class="nav-link" href="{{ url('logout') }}"
                            >
                                {{ __('Uscita') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                    @endguest
                </ul>
            </div>
        </nav>

        <div id="app" class="pb-5">
            @yield('content')
        </div>

    </div>


    <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>

    <script src="{{asset('/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <script src="{{asset('dist/js/adminlte.min.js')}}"></script>

    <script src="{{asset('plugins/sweetalert2/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('plugins/moment/moment.min.js')}}"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    @yield('script')
</body>

</html>

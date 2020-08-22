<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">

    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">

<link rel="stylesheet" href="{{asset('/plugins/jqvmap/jqvmap.min.css')}}">

    <link rel="stylesheet" href="{{asset('dist/css/adminlte.css')}}">

    <link rel="stylesheet" href="{{asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">

<link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">

    <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.css')}}">

    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">

    <!-- Styles -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">


        <nav class="main-header navbar navbar-expand navbar-white navbar-light">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/admin" class="nav-link">Dashboard</a>
                </li>

            </ul>


            {{-- <form class="form-inline ml-3">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="search" placeholder="Search"
                        aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form> --}}


            <ul class="navbar-nav ml-auto">

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('logout') }}"
                    >
                        {{ __('Logout') }}
                    </a>
                </li>
            </ul>
        </nav>


        <aside class="main-sidebar sidebar-dark-primary elevation-4">

            <a href="{{ url('/admin') }}" class="brand-link">
                <img src="/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">

                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                    </div>
                </div>


                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">

                        <li class="nav-item has-treeview">
                            <a href="/admin" class="nav-link {{Request::segment(2) == '' ? 'active' : ''}}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link {{Request::segment(2) == 'general-categories' ? 'active' : ''}}">
                                <i class="nav-icon fas fa-bookmark"></i>
                                <p>
                                    @lang('site.general') @lang('site.categories')
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/admin/general-categories" class="nav-link {{Request::segment(2) == 'general-categories' && Request::segment(3) == '' ? 'active' : ''}}">
                                        <i class="fas fa-list nav-icon"></i>
                                        <p>@lang('site.general') @lang('site.categories') @lang('site.list')</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link {{Request::segment(2) == 'categories' ? 'active' : ''}}">
                                <i class="nav-icon fas fa-bookmark"></i>
                                <p>
                                    @lang('site.categories')
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/admin/categories" class="nav-link {{Request::segment(2) == 'categories' && Request::segment(3) == '' ? 'active' : ''}}">
                                        <i class="fas fa-list nav-icon"></i>
                                        <p>@lang('site.categories') @lang('site.list')</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview {{Request::segment(2) == 'services' ? 'menu-open' : ''}}">
                            <a href="#" class="nav-link {{Request::segment(2) == 'services' ? 'active' : ''}}">
                                <i class="nav-icon fas fa-server"></i>
                                <p>
                                    @lang('site.services')
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/admin/services" class="nav-link {{Request::segment(2) == 'services' && Request::segment(3) == '' ? 'active' : ''}}">
                                        <i class="fas fa-list nav-icon"></i>
                                        <p>@lang('site.services') @lang('site.list')</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link {{Request::segment(2) == 'agent' ? 'active' : ''}}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    @lang('site.agents')
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/admin/agent" class="nav-link {{Request::segment(2) == 'agent' && Request::segment(3) == '' ? 'active' : ''}}">
                                        <i class="fas fa-list nav-icon"></i>
                                        <p>@lang('site.agents') @lang('site.list')</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview {{Request::segment(2) == 'clients' ? 'menu-open' : ''}}" >
                            <a href="#" class="nav-link {{Request::segment(2) == 'clients' ? 'active' : ''}}">
                                <i class="nav-icon fas fa-user-tie"></i>
                                <p>
                                    @lang('site.client')
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/admin/clients" class="nav-link {{Request::segment(2) == 'client' && Request::segment(3) == '' ? 'active' : ''}}">
                                        <i class="fas fa-list nav-icon"></i>
                                        <p>@lang('site.client') @lang('site.list')</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link {{Request::segment(2) == 'managers' ? 'active' : ''}}">
                                <i class="nav-icon fas fa-tasks"></i>
                                <p>
                                    @lang('site.managers')
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/admin/managers" class="nav-link {{Request::segment(2) == 'managers' && Request::segment(3) == '' ? 'active' : ''}}">
                                        <i class="fas fa-list nav-icon"></i>
                                        <p>@lang('site.managers') @lang('site.list')</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link {{Request::segment(2) == 'trasaction' ? 'active' : ''}}">
                                <i class="nav-icon fas fa-arrows-alt-h"></i>
                                <p>
                                    @lang('site.transaction')
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/admin/transaction" class="nav-link {{Request::segment(2) == 'transaction' && Request::segment(3) == '' ? 'active' : ''}}">
                                        <i class="fas fa-list nav-icon"></i>
                                        <p>@lang('site.transaction') @lang('site.list')</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>

            </div>

        </aside>


        <div id="app" class="content-wrapper">
            @yield('content')
        </div>

    </div>


    <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>

    <script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>

    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>

    <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>

    <script src="{{asset('plugins/sparklines/sparkline.js')}}"></script>

    <script src="{{asset('plugins/jqvmap/jquery.vmap.min.js')}}"></script>
    <script src="{{asset('plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>

    <script src="{{asset('plugins/jquery-knob/jquery.knob.min.js')}}"></script>

    <script src="{{asset('plugins/moment/moment.min.js')}}"></script>
    <script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>

    <script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>

    <script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>

    <script src="{{asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>

    <script src="{{asset('dist/js/adminlte.js')}}"></script>

<script src="{{asset('dist/js/demo.js')}}"></script>
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.admin.partials._head')
    @stack('css')
</head>

<body>

    <div class="header-bg">
        <!-- Navigation Bar-->
        <header id="topnav">

            @include('layouts.admin.partials._nav')

            <!-- MENU Start -->
            <div class="navbar-custom">
                <div class="container-fluid">
                    @include('layouts.admin.partials._navmenu')
                </div>
                <!-- end container -->
            </div>
            <!-- end navbar-custom -->
        </header>
        <!-- End Navigation Bar-->

    </div>
    <!-- header-bg -->

    <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">

                    <div class="col-sm-6">
                        @if (isset($back))
                            <a href="{{ $back }}" class="btn btn-dark mb-3">
                                <i class="mdi mdi-arrow-left"></i>
                                Kembali
                            </a>
                        @endif
                        <h4 class="page-title"></h4>
                    </div>
                    {{-- <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Loop Coffee</a></li>
                            @foreach ($breadcumb as $item)
                            <li class="breadcrumb-item {{ $item['status'] }}"><a href="">{{ $item['name'] }}</a></li>
                    @endforeach
                    </ol>
                </div> --}}
                </div>
                <!-- end row -->
            </div>

            <div class="row">
                @yield('content')
            </div>

        </div>
        <!-- end container-fluid -->
    </div>
    <!-- end wrapper -->

    <!-- Footer -->
    <footer class="footer">
        © {{ date('Y') }} Loop Coffee <span class="d-none d-sm-inline-block"> - Crafted with <i
                class="mdi mdi-heart text-danger"></i> by AbdiCreative</span>.
    </footer>

    <!-- End Footer -->

    @include('layouts.admin.partials._scripts')

    @stack('js')

</body>

</html>

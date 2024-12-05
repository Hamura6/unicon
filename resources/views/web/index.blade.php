<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Unicon</title>
    <link href=" {{asset('lib/animate/animate.min.css')}}" rel="stylesheet">
    <link href=" {{asset('lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">



    <link rel="stylesheet" href="{{asset('fontawesome/css/all.min.css')}} ">
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/web.css')}}  " rel="stylesheet">

</head>

<body>
    @php
    $route;
    if(!isset($route)){
        $route='inicio';
    }
    @endphp
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <div class="container-fluid fixed-top px-0 wow fadeIn" data-wow-delay="0.1s">
        <div class="top-bar text-white-50 row gx-0 align-items-center d-none d-lg-flex">
            <div class="col-lg-6 px-5 text-start">
                <small class="ms-4"><i class="fa fa-envelope me-2"></i>unicon@gmail.com</small>
            </div>
            <div class="col-lg-6 px-5 text-end">
                <small>Siganos:</small>
                <a class="text-white-50 ms-3" href=""><i class="fab fa-facebook-f"></i></a>
                <a class="text-white-50 ms-3" href=""><i class="fab fa-twitter"></i></a>
                <a class="text-white-50 ms-3" href=""><i class="fab fa-whatsapp"></i></a>
                <a class="text-white-50 ms-3" href=""><i class="fab fa-youtube"></i></a>
            </div>
        </div>

        <nav class="navbar navbar-expand-lg navbar-dark py-lg-0 px-lg-5 wow fadeIn" data-wow-delay="0.1s">
            <a href="index.html" class="navbar-brand ms-4 ms-lg-0">
                <h1 class="fw-bold text-white m-0">UNICON <span class="text-primary">S.A.</span></h1>
            </a>
            <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto p-4 p-lg-0">
                    <a href="#" class="nav-item nav-link ">INICIO</a>
                    <a href="#" class="nav-item nav-link ">NOSOTROS</a>
                    <a href="#" class="nav-item nav-link ">PRODUCTOS</a>

                    <a href="#" class="nav-item nav-link ">CONTACTOS</a>
                    <a href="#" class="nav-item nav-link ">COTIZADOR</a>
                    <div class="nav-item nav-link">
                        <a class="btn btn-outline-secondary" href="{{ route('login') }}">
                            <i class="fas fa-wrench"></i> {{ __('Login')}}
                        </a>
                    </div>
                </div>

            </div>
        </nav>
    </div>
    @yield('content')

    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="fas fa-arrow-up"></i></a>

    <script src="{{asset('js/jquery.min.js')}} "></script>
    <script src="{{asset('js/app.js')}} "></script>
    <script src="{{asset('lib/wow/wow.min.js')}} "></script>
    <script src="{{asset('lib/easing/easing.min.js')}} "></script>
    <script src="{{asset('lib/waypoints/waypoints.min.js')}} "></script>
    <script src="{{asset('lib/owlcarousel/owl.carousel.min.js')}} "></script>
    <script src="{{asset('lib/parallax/parallax.min.js')}} "></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>

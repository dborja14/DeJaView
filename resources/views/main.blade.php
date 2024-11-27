<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DeJaVu</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('../Resources/CSS/css.css')}}" />
    <link rel="stylesheet" href="https://code.jquery.com/jquery.reel.css">
    <link rel="icon" type="image/x-icon" href="storage/images/updatedLogo.png">


    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>




    <!--<script src="https://code.jquery.com/jquery.reel.min.js"></script>-->


    <!--<script src="/js/jquery.reel.min.js"></script>-->

    <script src="/js/jquery.reel.js"></script>


</head>




<body style="min-height: 100vh; display: flex; flex-direction: column;">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#"><img src="/storage/Images/updatedLogo.png" width="60" height="60" alt="Logo"></a>

            <!-- Remove the burger menu button (no longer needed) -->
            <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button> -->

            @if(Session::has('loginId'))
            <div class="d-lg-none end-0 m-3" style="z-index: 100;">
                <button class="btn btn-outline-secondary dropdown-toggle icon-lg" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person"></i>
                </button>

                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" href="../account">Account</a></li>
                    <li><a class="dropdown-item" href="../cart">Cart</a></li>
                    <li><a class="dropdown-item" href="../sellProduct">Sell Product</a></li>
                    <li><a class="dropdown-item" href="{{ url('logout') }}">Logout</a></li>
                </ul>
            </div>
            @else
            <div class="d-lg-none end-0 m-3 icon-lg" style="z-index: 100;">
                <a class="btn btn-outline-secondary" href="login">
                    <i class="bi bi-person"></i>
                </a>
            </div>
            @endif


            @if(Session::has('loginId'))

            <div class="navbar-collapse justify-content-center" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::path() == '/' ? 'active' : '' }}" href="/"><i class="bi bi-house" style="font-size: large;"></i><span class="d-none d-sm-inline">Home</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('collection*') ? 'active' : '' }}" href="../../collection"><i class="bi bi-collection" style="font-size: large;"></i><span class="d-none d-sm-inline">Collection</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('contact*') ? 'active' : '' }}" href="../../sellProduct"><i class="bi bi-telephone" style="font-size: large;"></i><span class="d-none d-sm-inline">Contact Us</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('recommendation*') ? 'active' : '' }}" href="../../survey"><i class="bi bi-file-earmark-spreadsheet" style="font-size: large;"></i><span class="d-none d-sm-inline">Recommendation</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../TryItYourself"><i class="bi bi-person-arms-up" style="font-size: large;"></i><span class="d-none d-sm-inline">Try It Yourself</span></a>
                    </li>
                </ul>
            </div>

            @else

            <div class="navbar-collapse justify-content-center" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::path() == '/' ? 'active' : '' }}" href="/"><i class="bi bi-house" style="font-size: large;"></i><span class="d-none d-sm-inline">Home</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('collection*') ? 'active' : '' }}" href="../../collection"><i class="bi bi-collection" style="font-size: large;"></i><span class="d-none d-sm-inline">Collection</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('contact*') ? 'active' : '' }} disabled" href="#"><i class="bi bi-telephone" style="font-size: large;"></i><span class="d-none d-sm-inline">Contact Us</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('recommendation*') ? 'active' : '' }} disabled" href=""><i class="bi bi-file-earmark-spreadsheet" style="font-size: large;"></i><span class="d-none d-sm-inline">Recommendation</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href=""><i class="bi bi-person-arms-up" style="font-size: large;"></i><span class="d-none d-sm-inline">Try It Yourself</span></a>
                    </li>
                </ul>
            </div>

            @endif


            <!-- Regular Login/Logout Section -->
            @if(Session::has('loginId'))
            <div class="d-none d-lg-block">
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        {{ Session::get('user.name') }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="../account">Account</a></li>
                        <li><a class="dropdown-item" href="../cart">Cart</a></li>
                        <li><a class="dropdown-item" href="{{ url('logout') }}">Logout</a></li>
                    </ul>
                </div>
            </div>
            @else
            <div class="d-none d-lg-block">
                <a class="btn btn-outline-secondary" href="login">Login</a>
            </div>
            @endif
        </div>
    </nav>

    @yield('login')
    @yield('home')
    @yield('collection')
    @yield('account')
    @yield('putiton')
    @yield('product')
    @yield('cart')
    @yield('sellProduct')
    @yield('survey')
    @yield('reco')


    <footer class="bg-dark text-light text-center py-3 mt-5" style="bottom:0; width:100%; margin-top: auto !important;">
        <div class="container">
            <p>&copy; Sole Mate PH Est. 2020</p>
        </div>
    </footer>

</body>

<!-- Custom CSS -->
<style>
    .navbar-nav {
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    /* Hide icons by default */
    .navbar-nav .nav-item a i {
        display: inline;
        /* Show icons on small screens */
    }

    /* Hide text and icons on smaller screens (mobile) */
    .navbar-nav .nav-item a span {
        display: none;
    }

    /* Show text only on larger screens */
    @media (min-width: 576px) {

        /* Hide the icons on large screens */
        .navbar-nav .nav-item a i {
            display: none;
            /* Hide icons */
        }

        /* Show the text only on large screens */
        .navbar-nav .nav-item a span {
            display: inline;
            /* Show text */
        }
    }
</style>


</html>

<style>
    .navbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }


    .navbar-collapse {
        flex-grow: 1;
        display: flex;
        justify-content: center;
    }

    .navbar-nav {
        flex-direction: row;
    }

    .navbar-nav .active {
        border: none;
        border-bottom: 1px solid black;
    }



    .navbar-nav .nav-item {
        margin-left: 1rem;
    }

    .dropdown-menu-end {
        right: 0;
        left: auto;
    }

    .navbar-brand {
        margin-right: auto;
    }

    .navbar-toggler {
        margin-left: auto;
    }
</style>
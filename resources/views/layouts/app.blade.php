<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Image Generator') }}</title>

    <!-- Fonts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js">
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.esm.js">
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.js"></script>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href='/resources/css/modal.css' />
    {{-- <link href='/resources/css/custom.css' /> --}}
    {{-- <link href="{{ asset('resources/css/custom.css') }}" rel="stylesheet" /> --}}

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        .navbar-light .navbar-nav .nav-link.active,
        .navbar-light .navbar-nav .show>.nav-link {
            background-color: blue !important;
            color: white !important;
            border-radius: 5px !important;
        }
    </style>

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="#">
                    Image Generator
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>



                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <div class="custom d-flex">
                            <ul class="nav nav-pills mr-auto">
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('listing') ? 'active' : '' }}"
                                        href="{{ url('listing') }}">Listing</a>
                                </li>
                            </ul>
                            <ul class="nav nav-pills ml-auto">
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('home') ? 'active' : '' }}"
                                        href="{{ url('/home') }}">Generator</a>
                                </li>
                            </ul>
                        </div>

                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                            @if (Route::has('register'))
                                {{-- <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li> --}}
                            @endif
                        @else
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
                        @endguest
                </ul>
            </div>

    </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>






</body>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#previewImage').attr('src', e.target.result);
                $('#imageTitle').text($('#postTitle').val() || 'Image Title');
                $('#imageDescription').text($('#postDescription').val() || 'Image Description');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    $('#fileInput').change(function() {
        previewImage(this);
    });



    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#previewImage').attr('src', e.target.result);

                var title = $('#postTitle').val() || 'Image Title';
                var description = $('#postDescription').val() || 'Image Description';

                $('#imageTitle').text(title);
                $('#imageDescription').text(description);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    $('#fileInput').change(function() {
        previewImage(this);
    });

    $('#previewButton').click(function() {
        previewImage($('#fileInput')[0]);
    });

    function previewButtonClickHandler() {
        var title = $('#postTitle').val();
        var description = $('#postDescription').val();
        var fileInput = $('#fileInput')[0].files[0];

        console.log('Title:', title);
        console.log('Description:', description);
        console.log('File:', fileInput);
        // Active Nav bar

        // function toggleActive(link, section) {
        //     const links = document.querySelectorAll(".nav-link");
        //     links.forEach((item) => {
        //         item.classList.remove("active-link");
        //     });

        //     // Add active class to the clicked link
        //     link.classList.add("active-link");

        //     // Perform other actions based on the section if needed
        //     if (section === "listing") {
        //         // Code for the 'Listing' section
        //     } else if (section === "generate") {
        //         // Code for the 'Generator' section
        //     }
        // }

    }


    $('#previewButton').click(previewButtonClickHandler);
</script>

</html>

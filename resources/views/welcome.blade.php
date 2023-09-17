<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <!-- Styles -->
        <style>
            btn btn-primary{
                background-color:'#1546'
                color:'#000'
                border-radius:'15px'
                width:'50%'
                text-decoration:'none'
                justify-content:'center'
                align-items:'center'
                display:'flex'
            }
        </style>
    </head>
    <body class="antialiased">
    <div class="container">
    @if (Route::has('login'))
        <div class="fixed top-0 right-0 px-6 py-4 sm:block">
            @auth
                <a href="{{ url('/home') }}" class="">Home</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary">Log in</a>
            @endauth
        </div>
    @endif

    <div class="text-center">
        <h1 class="text-primary">Welcome to Image Generator</h1>
    </div>
</div>

    </body>
</html>

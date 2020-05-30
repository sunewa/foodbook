<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        
        <!-- Styles -->
        
    </head>
    <body>
    
        <div class="flex-center position-ref full-height" id="app">
            @if (Route::has('login'))
                <div class="top-right links">
                    <a href="{{ url('/') }}">Home</a>
                    <a href="{{ url('/recipe') }}">Recipe</a>
                    <a href="{{ url('/market') }}">Market</a>
                    @auth
                        <a href="{{ url('/manage/dashboard') }}">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <router-view></router-view>
            </div>
        </div>
    
    </body>
    <script src="{{ asset('js/app.js') }}"></script>
</html>

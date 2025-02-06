<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

        <title>{{ env('APP_NAME') }} - @yield("title")</title>
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-2">
            <div class="container">
                <a class="navbar-brand" href="#">{{ env('APP_NAME') }}</a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Advertisements</a>
                        </li>
                    </ul>

                    <ul class="navbar-nav ms-auto">
                        @auth
                            <li class="nav-item dropdown">
                                <button class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                                    {{ auth()->user()->name }}
                                </button>

                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="{{ route('profile') }}">Profile</a>

                                    <div class="dropdown-divider"></div>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf

                                        <button class="dropdown-item">Logout</button>
                                    </form>
                                </div>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('auth.login') }}">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('auth.register') }}">Register</a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>

        <main class="container">
            @yield("content")
        </main>

        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    </body>
</html>

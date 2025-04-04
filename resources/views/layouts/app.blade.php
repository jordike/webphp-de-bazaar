<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        @stack('styles')

        <title>{{ env('APP_NAME') }} - @yield("title")</title>
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-2">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">
                    {{ env('APP_NAME') }}
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">
                                {{ __('layout.nav.home') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('advertisement.index') }}">
                                {{ __('layout.nav.advertisements') }}
                            </a>
                        </li>

                        @auth
                            @if (auth()->user()->isAdmin())
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('companies.index') }}">
                                        {{ __('layout.nav.companies') }}
                                    </a>
                                </li>
                            @endif
                        @endauth
                    </ul>

                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="locale-dropdown" role="button" data-bs-toggle="dropdown">
                                {{ __('localization.' . session()->get('locale', 'en')) }}
                            </a>

                            <div id="locale-dropdown" class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('locale.switch', 'en') }}">English</a>
                                <a class="dropdown-item" href="{{ route('locale.switch', 'nl') }}">Nederlands</a>
                            </div>
                        </li>

                        @auth
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown">
                                    {{ auth()->user()->name }}
                                </a>

                                <div id="profile-dropdown" class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">
                                        {{ __('layout.profile-dropdown.profile') }}
                                    </a>

                                    @isset (auth()->user()->company_id)
                                        <a class="dropdown-item" href="{{ route('company.edit', auth()->user()->company) }}">
                                            {{ __('layout.profile-dropdown.company') }}
                                        </a>
                                    @else
                                        <a class="dropdown-item" href="{{ route('company.create') }}">
                                            {{ __('layout.profile-dropdown.create-company') }}
                                        </a>
                                    @endisset

                                    <div class="dropdown-divider"></div>

                                    <form id="logout-form" class="d-none" action="{{ route('logout') }}" method="POST">
                                        @csrf
                                    </form>

                                    <button class="dropdown-item" type="submit" form="logout-form">
                                        {{ __('layout.profile-dropdown.logout') }}
                                    </button>
                                </div>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">
                                    {{ __('auth.login.login') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">
                                    {{ __('auth.registration.register') }}
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>

        <main class="container">
            @yield("content")
        </main>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @stack('scripts')
    </body>
</html>

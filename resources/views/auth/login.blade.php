@extends("layouts.app")

@section("title", "Login")

@section("content")
    <div class="col-12 col-md-6 col-lg-4">
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <h1 class="mb-3">Login</h1>

            <div class="form-group mb-3">
                <label for="email" class="mb-1">E-mailadres</label>
                <input type="email" class="form-control" id="email" name="email" required autofocus>
            </div>

            <div class="form-group mb-3">
                <label for="password" class="mb-1">Wachtwoord</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <div class="form-group form-check mb-3">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">Mij onthouden</label>
            </div>

            <button type="submit" class="btn btn-primary mb-3">Inloggen</button>
            <p class="text-muted">Nog geen account? <a href="{{ route("register") }}">Maak er hier een aan.</a></p>
        </form>
    </div>
@endsection

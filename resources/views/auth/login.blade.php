@extends("layouts.app")

@section("title", "Login")

@section("content")
    <div class="col-12 col-md-6 col-lg-4">
        <h1 class="mb-3">
            {{ __('auth.login.login') }}
        </h1>

        <x-error-message />

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <div class="form-group mb-3">
                <label for="email" class="mb-1">
                    {{ __('auth.fields.email') }}
                </label>
                <input type="email" class="form-control" id="email" name="email" required autofocus>

                @error("email")
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="password" class="mb-1">
                    {{ __('auth.fields.password') }}
                </label>
                <input type="password" class="form-control" id="password" name="password" required>

                @error("password")
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group form-check mb-3">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">
                    {{ __('auth.fields.remember') }}
                </label>
            </div>

            <button type="submit" class="btn btn-primary mb-3">
                {{ __('auth.login.login') }}
            </button>
            <p class="text-muted">
                {{ __('auth.login.no_account') }}
                <a href="{{ route("register") }}">
                    {{ __('auth.login.create_account') }}
                </a>
            </p>
        </form>
    </div>
@endsection

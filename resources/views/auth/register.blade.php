@extends("layouts.app")

@section("title", "Registreren")

@section("content")
    <div class="col-12 col-md-6 col-lg-4">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <h1 class="mb-3">
                {{  __('auth.registration.register') }}
            </h1>

            <x-error-message />

            <div class="form-group mb-3">
                <label for="name" class="mb-1">
                    {{ __('auth.fields.name') }}
                </label>
                <input type="text" class="form-control" id="name" name="name" required autofocus>

                @error("name")
                    <p class="text-danger">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="email" class="mb-1">
                    {{ __('auth.fields.email') }}
                </label>
                <input type="email" class="form-control" id="email" name="email" required>

                @error("email")
                    <p class="text-danger">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="password" class="mb-1">
                    {{  __('auth.fields.password') }}
                </label>
                <input type="password" class="form-control" id="password" name="password" required>

                @error("password")
                    <p class="text-danger">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="password_confirmation" class="mb-1">
                    {{ __('auth.fields.password_confirmation') }}
                </label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>

                @error("password_confirmation")
                    <p class="text-danger">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="role" class="mb-1">
                    {{ __('auth.registration.role.register_as') }}
                </label>

                <select class="form-control" id="role" name="role" required>
                    <option value="">
                        -- {{ __('auth.registration.role.select_role') }} --
                    </option>

                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>

                @error("role")
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary mb-3">
                {{ __('auth.registration.register') }}
            </button>
            <p class="text-muted">
                {{ __('auth.registration.already_account') }}
                <a href="{{ route("login") }}">
                    {{ __('auth.registration.login') }}
                </a>
            </p>
        </form>
    </div>
@endsection

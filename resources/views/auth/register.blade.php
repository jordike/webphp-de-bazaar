@extends("layouts.app")

@section("title", "Registreren")

@section("content")
    <div class="col-12 col-md-6 col-lg-4">
        <form method="POST" action="{{ route('auth.register') }}">
            @csrf

            <h1 class="mb-3">Registreren</h1>

            <div class="form-group mb-3">
                <label for="name" class="mb-1">Naam</label>
                <input type="text" class="form-control" id="name" name="name" required autofocus>
            </div>

            <div class="form-group mb-3">
                <label for="email" class="mb-1">E-mailadres</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="form-group mb-3">
                <label for="password" class="mb-1">Wachtwoord</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <div class="form-group mb-3">
                <label for="password_confirmation" class="mb-1">Bevestig Wachtwoord</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            </div>

            <div class="form-group mb-3">
                <label for="role" class="mb-1">Registreren als</label>

                <select class="form-control" id="role" name="role" required>
                    <option value="">-- Selecteer een rol --</option>
                    <option value="1">Gebruiker</option>
                    <option value="2">Particuliere Adverteerder</option>
                    <option value="3">Zakelijke Adverteerder</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary mb-3">Registreren</button>
            <p class="text-muted">Al een account? <a href="{{ route("auth.login") }}">Log hier in.</a></p>
        </form>
    </div>
@endsection

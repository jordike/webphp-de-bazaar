@if (session()->has('error'))
    <div class="alert alert-danger mb-3">
        {{ session('error') }}
    </div>
@endif

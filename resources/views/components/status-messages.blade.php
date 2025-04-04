@if (session()->has('error'))
    <div class="alert alert-danger mb-3">
        {{ session('error') }}
    </div>
@endif

@if (session()->has('success'))
    <div class="alert alert-success mb-3">
        {{ session('success') }}
    </div>
@endif

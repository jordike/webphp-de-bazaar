@extends("layouts.app")

@section("title", "Advertisements")

@section("content")
    <x-status-messages />

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Your Advertisements</h1>

        <div>
            <a class="btn btn-primary" href="advertisement/create">+ Create</a>
            <form action="{{ route('advertisement.uploadCsv') }}" method="POST" enctype="multipart/form-data" class="d-inline">
                @csrf
                <label for="csvFile" class="btn btn-secondary">Upload CSV</label>
                <input type="file" id="csvFile" name="csvFile" accept=".csv" class="d-none" onchange="this.form.submit()">
            </form>
        </div>
    </div>

    {{-- FOR RENT --}}
    <h3 class="mb-3">For Rent ({{ $forRent->count() }}/4)</h3>
    <div class="row g-4">
        @forelse ($forRent as $ad)
            <div class="col-md-4">
                <a href="{{ url('/advertisement/' . $ad->id) }}" class="text-decoration-none text-dark">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden transition" style="transition: all 0.3s ease;">
                        @if ($ad->photo)
                            <img src="{{ Storage::url($ad->photo) }}" class="card-img-top object-fit-cover" style="height: 200px;" alt="{{ $ad->title }}">
                        @else
                            <img src="https://via.placeholder.com/400x200.png?text=No+Image" class="card-img-top" alt="No image available">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title fw-semibold">{{ $ad->title }}</h5>
                            <p class="card-text text-muted small">{{ Str::limit($ad->description, 100) }}</p>
                            <p class="card-text fw-bold text-primary">€{{ number_format($ad->price, 2) }}</p>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <p class="text-muted">No advertisements for rent.</p>
        @endforelse
    </div>

    {{-- FOR SALE --}}
    <h3 class="mb-3 mt-5">For Sale ({{ $forSale->count() }}/4)</h3>
    <div class="row g-4">
        @forelse ($forSale as $ad)
            <div class="col-md-4">
                <a href="{{ url('/advertisement/' . $ad->id) }}" class="text-decoration-none text-dark">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden transition" style="transition: all 0.3s ease;">
                        @if ($ad->photo)
                            <img src="{{ Storage::url($ad->photo) }}" class="card-img-top object-fit-cover" style="height: 200px;" alt="{{ $ad->title }}">
                        @else
                            <img src="https://via.placeholder.com/400x200.png?text=No+Image" class="card-img-top" alt="No image available">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title fw-semibold">{{ $ad->title }}</h5>
                            <p class="card-text text-muted small">{{ Str::limit($ad->description, 100) }}</p>
                            <p class="card-text fw-bold text-success">€{{ number_format($ad->price, 2) }}</p>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <p class="text-muted">No advertisements for sale.</p>
        @endforelse
    </div>
@endsection

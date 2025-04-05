@extends("layouts.app")

@section("title", "Advertisements")

@section("content")
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Your Advertisements</h1>
        <a class="btn btn-primary" href="advertisement/create">+ Create</a>
    </div>

    {{-- FOR RENT --}}
    <h3 class="mb-3">For Rent {{ $forRent->count() }}/4</h3>
    <div class="row">
        @forelse ($forRent as $ad)
            <div class="col-md-4 mb-4">
                <a href="/advertisement/{{ $ad['id'] }}" class="text-decoration-none">
                    <div class="card h-100 shadow-sm">
                        @if ($ad->photo)
                            <img src="{{ Storage::url($ad->photo) }}" class="card-img-top" alt="{{ $ad->title }}">
                        @else
                            <img src="https://via.placeholder.com/300x200.png?text=No+Image" class="card-img-top" alt="No image available">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $ad->title }}</h5>
                            <p class="card-text text-truncate">{{ $ad->description }}</p>
                            <p class="card-text"><strong>Price:</strong> €{{ $ad->price ?? 'N/A' }}</p>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <p class="text-muted">No advertisements for rent.</p>
        @endforelse
    </div>

    {{-- FOR SALE --}}
    <h3 class="mb-3 mt-5">For Sale {{ $forSale->count() }}/4    </h3>
    <div class="row">
        @forelse ($forSale as $ad)
            <div class="col-md-4 mb-4">
                <a href="/advertisement/{{ $ad['id'] }}" class="text-decoration-none">
                    <div class="card h-100 shadow-sm">
                        @if ($ad->photo)
                            <img src="{{ Storage::url($ad->photo) }}" class="card-img-top" alt="{{ $ad->title }}">
                        @else
                            <img src="https://via.placeholder.com/300x200.png?text=No+Image" class="card-img-top" alt="No image available">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $ad->title }}</h5>
                            <p class="card-text text-truncate">{{ $ad->description }}</p>
                            <p class="card-text"><strong>Price:</strong> €{{ $ad->price ?? 'N/A' }}</p>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <p class="text-muted">No advertisements for sale.</p>
        @endforelse
    </div>
@endsection

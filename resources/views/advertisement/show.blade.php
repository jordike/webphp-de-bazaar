@extends('layouts.app')

@section('title', $advertisement->title)

@section('content')
<div class="container my-5">
    <div class="card shadow-sm">
        <div class="row g-0">
            @if($advertisement->photo)
                <div class="col-md-5">
                    <img src="{{ Storage::url($advertisement->photo) }}" class="img-fluid rounded-start w-100 h-100 object-fit-cover" alt="{{ $advertisement->title }}">
                </div>
            @endif
            <div class="col-md-7">
                <div class="card-body">
                    <h1 class="card-title h3 fw-bold">{{ $advertisement->title }}</h1>
                    <p class="card-text mt-3 text-muted">{{ $advertisement->description }}</p>
                    <p class="card-text mt-3"><strong>Price:</strong> €{{ number_format($advertisement->price, 2) }}</p>
                    <p class="card-text">
                        <strong>Status:</strong>
                        <span class="badge bg-{{ $advertisement->is_for_rent ? 'primary' : 'success' }}">
                            {{ $advertisement->is_for_rent ? 'For Rent' : 'For Sale' }}
                        </span>
                    </p>

                    <a href="/advertisement/{{ $advertisement->id }}/edit" class="btn btn-outline-primary mt-4">✏️ Edit Advertisement</a>
                    <h5 class="mb-2 mt-2">Share this ad:</h5>
                    <img src="{{ $qrCodeDataUrl }}" alt="QR Code" class="img-fluid" style="max-width: 160px;">
                </div>
            </div>
        </div>
    </div>

    @if($advertisement->relatedAdvertisements->count())
        <div class="mt-5">
            <h4 class="mb-4">Related Advertisements</h4>
            <div class="row">
                @foreach($advertisement->relatedAdvertisements as $relatedAd)
                    <div class="col-md-3 mb-4">
                        <div class="card">
                            @if($relatedAd->photo)
                                <img src="{{ Storage::url($relatedAd->photo) }}" class="card-img-top" alt="{{ $relatedAd->title }}">
                            @else
                                <img src="https://via.placeholder.com/300x200.png?text=No+Image" class="card-img-top" alt="No image available">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $relatedAd->title }}</h5>
                                <p class="card-text text-truncate">{{ $relatedAd->description }}</p>
                                <p class="card-text">
                                    <strong>Price:</strong> €{{ number_format($relatedAd->price, 2) }}
                                </p>
                                <a href="/advertisement/{{ $relatedAd->id }}" class="btn btn-outline-secondary btn-sm">View</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <p class="mt-4">No related advertisements found.</p>
    @endif
</div>
@endsection

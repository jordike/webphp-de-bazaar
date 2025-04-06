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
</div>
@endsection

@extends('layouts.app')

@section('title', $advertisement->title)

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title">{{ $advertisement->title }}</h1>
            </div>
            <div class="card-body">
                @if($advertisement->photo)
                    <div class="mb-3">
                        <img src="{{ Storage::url($advertisement->photo) }}" alt="Photo" class="img-fluid rounded">
                    </div>
                @endif

                <p class="card-text">{{ $advertisement->description }}</p>
                <p class="card-text"><strong>Price:</strong> €{{ number_format($advertisement->price, 2) }}</p>
                <p class="card-text"><strong>Status:</strong> {{ $advertisement->is_for_rent ? 'For Rent' : 'For Sale' }}</p>
            </div>
            <div class="card-footer text-end">
                <a href="/advertisement/{{ $advertisement->id }}/edit" class="btn btn-primary">Edit Job</a>
            </div>
        </div>
    </div>
@endsection

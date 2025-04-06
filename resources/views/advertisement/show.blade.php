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
                        <img src="{{ $advertisement->getPhotoUrl() }}" alt="Photo" class="img-fluid rounded" style="max-width: 200px">
                    </div>
                @endif

                <p class="card-text">{{ $advertisement->description }}</p>
                <p class="card-text"><strong>Price:</strong> €{{ number_format($advertisement->price, 2) }}</p>
                <p class="card-text"><strong>Status:</strong> {{ $advertisement->is_for_rent ? 'For Rent' : 'For Sale' }}</p>
            </div>
            <div class="card-footer text-end">
                <a href="{{ route('advertisement.bid.show-bids', $advertisement) }}" class="btn btn-secondary">View bids</a>

                @if ($advertisement->user_id === auth()->id())
                    <a href="{{ route('advertisement.edit', $advertisement) }}" class="btn btn-primary">Edit</a>

                    <form action="{{ route('advertisement.destroy', $advertisement) }}" method="POST" class="d-inline delete-form">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger delete-button">Delete</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection

@if ($advertisement->user_id === auth()->id())
    @push('scripts')
        <script src="{{ asset('js/deleteConfirmation.js') }}"></script>
    @endpush
@endif

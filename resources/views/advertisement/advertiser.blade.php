@extends('layouts.app')

@section('content')
    <div class="container">
        <x-status-messages />

        <h1>{{ $advertiser->name }}</h1>

        <section>
            <h2>Advertisements</h2>

            @if($advertisements->isEmpty())
                <p>No advertisements found for this advertiser.</p>
            @else
                <div class="d-flex flex-wrap gap-3">
                    @foreach($advertisements as $advertisement)
                        <x-advertisement :advertisement="$advertisement" />
                    @endforeach
                </div>
            @endif
        </section>

        <section>
            <h2>Reviews</h2>

            @if(auth()->check())
                <form action="{{ route('advertisement.advertiser.review', $advertiser->id) }}" method="POST" class="mb-3">
                    @csrf

                    <div class="mb-3">
                        <label for="rating" class="form-label">Rating (1-5)</label>
                        <input type="number" name="rating" id="rating" class="form-control" min="1" max="5" step="1" placeholder="Enter a rating (1-5)" required>
                    </div>

                    <div class="mb-3">
                        <label for="comment" class="form-label">Comment</label>
                        <textarea name="comment" id="comment" class="form-control" rows="3" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-success">Submit Review</button>
                </form>
            @else
                <p class="text-muted">You must be logged in to leave a review.</p>
            @endif

            <hr />

            @forelse ($advertiser->reviews as $review)
                <div class="card mb-2">
                    <div class="card-body">
                        <h5 class="card-title">Rating: {{ $review->rating }}/5</h5>
                        <p class="card-text">{{ $review->comment }}</p>
                        <p class="card-text"><small class="text-muted">By {{ $review->user->name }} on {{ $review->created_at->format('d-m-Y') }}</small></p>

                        @if(auth()->check() && auth()->id() === $review->user_id)
                            <form action="{{ route('advertisement.advertiser.review.delete', ['advertiser' => $advertiser->id, 'review' => $review ]) }}" method="POST" class="mt-2 delete-form">
                                @csrf

                                <button type="submit" class="btn btn-danger btn-sm delete-button">Delete</button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-muted">No reviews yet.</p>
            @endforelse
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/deleteConfirmation.js') }}"></script>
@endpush

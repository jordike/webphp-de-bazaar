@extends('layouts.app')

@section('title', 'Advertiser')

@section('content')
    <div class="container">
        <x-status-messages />

        <h1>{{ $advertiser->name }}</h1>

        <section>
            <h2>{{ __('advertisements.advertisements') }}</h2>

            @if($advertisements->isEmpty())
                <p>{{ __('advertisements.advertiser.no_advertisements') }}</p>
            @else
                <div class="d-flex flex-wrap gap-3">
                    @foreach($advertisements as $advertisement)
                        <x-advertisement :advertisement="$advertisement" />
                    @endforeach
                </div>
            @endif
        </section>

        <section>
            <h2>{{ __('reviews.reviews') }}</h2>

            @if(auth()->check())
                <form action="{{ route('advertisement.advertiser.review', $advertiser->id) }}" method="POST" class="mb-3">
                    @csrf

                    <div class="mb-3">
                        <label for="rating" class="form-label">
                            {{ __('reviews.rating') }}
                        </label>
                        <input type="number" name="rating" id="rating" class="form-control" min="1" max="5" step="1" placeholder="{{ __('reviews.rating_placeholder') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="comment" class="form-label">
                            {{ __('reviews.comment') }}
                        </label>
                        <textarea name="comment" id="comment" class="form-control" rows="3" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-success">
                        {{ __('reviews.submit') }}
                    </button>
                </form>
            @else
                <p class="text-muted">
                    {{ __('reviews.login_to_review') }}
                </p>
            @endif

            <hr />

            @forelse ($advertiser->reviews as $review)
                <div class="card mb-2">
                    <div class="card-body">
                        <h5 class="card-title">
                            {{ __('reviews.review_card.rating') }}:
                            {{ $review->rating }}/5
                        </h5>
                        <p class="card-text">{{ $review->comment }}</p>
                        <p class="card-text"><small class="text-muted">{{ __('reviews.review_card.by') }} {{ $review->user->name }} {{ __('reviews.review_card.on') }} {{ $review->created_at->format('d-m-Y') }}</small></p>

                        @if(auth()->check() && auth()->id() === $review->user_id)
                            <form action="{{ route('advertisement.advertiser.review.delete', ['advertiser' => $advertiser->id, 'review' => $review ]) }}" method="POST" class="mt-2 delete-form">
                                @csrf

                                <button type="submit" class="btn btn-danger btn-sm delete-button">
                                    {{ __('reviews.delete') }}
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-muted">
                    {{ __('reviews.no_reviews') }}
                </p>
            @endforelse
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/deleteConfirmation.js') }}"></script>
@endpush

@extends('layouts.app')

@section('title', $advertisement->title)

@section('content')
    <div class="container mt-4">
        <div class="card mb-3">
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
                <p class="card-text">
                    <strong>{{ __('advertisements.form.price') }}:</strong>
                    € {{ number_format($advertisement->price, 2) }}
                </p>
                <p class="card-text">
                    <strong>{{ __('advertisements.form.status') }}:</strong>
                    {{ $advertisement->is_for_rent ? __('advertisements.overview.for_rent') : __('advertisements.overview.for_sale') }}
                </p>
                <p class="card-text">
                    <strong>{{ __('advertisements.by') }}<strong>
                    <a href="{{ route('advertisement.advertiser', $advertisement->user_id) }}">
                        {{ $advertisement->user->name }}
                    </a>
                </p>
            </div>
            <div class="card-footer text-end">
                <a href="{{ route('advertisement.bid.show-bids', $advertisement) }}" class="btn btn-secondary">
                    {{ __('advertisements.view_bids') }}
                </a>

                @if ($advertisement->user_id === auth()->id())
                    <a href="{{ route('advertisement.edit', $advertisement) }}" class="btn btn-primary">
                        {{ __('advertisements.edit.edit') }}
                    </a>

                    <form action="{{ route('advertisement.destroy', $advertisement) }}" method="POST" class="d-inline delete-form">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger delete-button">
                            {{ __('advertisements.edit.delete') }}
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <hr />

        <div class="mb-3">
            <h2>{{ __('advertisements.related_advertisements.label') }}</h2>
            <div class="d-flex flex-wrap gap-3">
                @forelse ($advertisement->relatedAdvertisements as $related)
                    <x-advertisement :advertisement="$related" />
                @empty
                    <p>{{ __('advertisements.related_advertisements.none') }}</p>
                @endforelse
            </div>
        </div>

        <hr />

        <div class="mb-3">
            <h2>{{ __('reviews.reviews') }}</h2>

            @if(auth()->check())
                <h3>{{ __('reviews.leave_review') }}</h3>

                <form action="{{ route('advertisement.review', $advertisement) }}" method="POST" class="mb-3">
                    @csrf

                    <div class="mb-3">
                        <label for="rating" class="form-label">
                            {{ __('reviews.rating_label') }}
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

            <h3>{{ __('reviews.all_reviews') }}</h3>

            @forelse ($reviews as $review)
                <div class="card mb-2">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('reviews.review_card.rating') }}: {{ $review->rating }}/5</h5>
                        <p class="card-text">{{ $review->comment }}</p>
                        <p class="card-text"><small class="text-muted">{{ __('reviews.by') }} {{ $review->user->name }} {{ __('reviews.on') }} {{ $review->created_at->format('d-m-Y') }}</small></p>

                        @if(auth()->check() && auth()->id() === $review->user_id)
                            <form action="{{ route('advertisement.advertiser.review.delete', ['advertiser' => $advertisement->user_id, 'review' => $review ]) }}" method="POST" class="mt-2 delete-form">
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
                    {{ __('reviews.no_reviews_yet') }}
                </p>
            @endforelse

            {{ $reviews->links() }}
        </div>
    </div>
@endsection

@if ($advertisement->user_id === auth()->id())
    @push('scripts')
        <script src="{{ asset('js/deleteConfirmation.js') }}"></script>
    @endpush
@endif

<a href="{{ route('advertisement.show', $advertisement) }}" class="text-decoration-none text-black">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">{{ $advertisement->title }}</h5>
        </div>

        <div class="card-body">
            <div class="text-center mb-3">
                <img src="{{ asset('storage/' . $advertisement->photo) }}" alt="Image" class="img-fluid rounded shadow-sm" style="max-height: 100px" />
            </div>

            <p class="card-text text-truncate">{{ $advertisement->description }}</p>
            <p class="card-text"><strong>Price:</strong> €{{ number_format($advertisement->price ?? 0, 2, ',', '.') }}</p>
        </div>

        <div class="card-footer text-center">
            <a href="{{ route('favorites.favorite', $advertisement) }}">
                @if ($advertisement->isFavorite())
                    Remove from favorites
                @else
                    Add to favorites
                @endif
            </a>
        </div>
    </div>
</a>

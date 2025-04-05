@extends("layouts.app")

@section("title", "Home")

@section("content")
    <h1>De Bazaar</h1>

    <hr />

    <section>
        <h2 class="mb-2">Latest advertisements</h2>

        <div class="d-flex flex-row gap-3 flex-wrap">
            @foreach ($latestAdvertisements as $advertisement)
                <a href="{{ route('advertisement.show', $advertisement) }}" class="text-decoration-none">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">{{ $advertisement->title }}</h5>
                        </div>

                        <div class="card-body">
                            <div class="text-center mb-3">
                                <img src="{{ asset('storage/' . $advertisement->photo) }}" alt="Image" class="img-fluid rounded shadow-sm" style="max-height: 100px" />
                            </div>

                            <p class="card-text text-truncate">{{ $advertisement->description }}</p>
                            <p class="card-text"><strong>Price:</strong> €{{ $advertisement->price ?? 'N/A' }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
@endsection

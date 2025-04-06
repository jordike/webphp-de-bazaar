@extends("layouts.app")

@section("title", "Advertisements Overview")

@section("content")
    <x-status-messages />

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ __('advertisements.advertisements') }}</h1>

        @can('create', App\Models\Advertisement::class)
            <a class="btn btn-primary" href="{{ route('advertisement.create') }}">
                {{ __('advertisements.overview.create') }}
            </a>
        @endcan
    </div>

    <hr />

    {{-- FOR RENT --}}
    <section class="mb-3">
        <h3 class="mb-3">{{ __('advertisements.overview.for_rent') }}</h3>

        <div class="d-flex flex-row gap-3 flex-wrap">
            @forelse ($forRent as $ad)
                <x-advertisement :advertisement="$ad" />
            @empty
                <p class="text-muted">{{ __('advertisements.overview.none_for_rent') }}</p>
            @endforelse

            {{ $forRent->links() }}
        </div>
    </section>

    <hr />

    {{-- FOR SALE --}}
    <section>
        <h3 class="mb-3">{{ __('advertisements.overview.for_sale') }}</h3>

        <div class="d-flex flex-row gap-3 flex-wrap mb-3">
            @forelse ($forSale as $ad)
                <x-advertisement :advertisement="$ad" />
            @empty
                <p class="text-muted">{{ __('advertisements.overview.none_for_sale') }}</p>
            @endforelse

            {{ $forSale->links() }}
        </div>
    </section>
@endsection

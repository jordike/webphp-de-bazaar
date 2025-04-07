@extends("layouts.app")

@section("title", "Advertisements")

@section("content")
    <x-status-messages />

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ __('advertisements.my_advertisements') }}</h1>

        <div>
            <a class="btn btn-primary" href="{{ route('advertisement.create') }}">
                {{ __('advertisements.overview.create') }}
            </a>

            <form action="{{ route('advertisement.uploadCsv') }}" method="POST" enctype="multipart/form-data" class="d-inline">
                @csrf

                <label for="csvFile" class="btn btn-secondary">
                    {{ __('advertisements.overview.upload_csv') }}
                </label>
                <input type="file" id="csvFile" name="csvFile" accept=".csv" class="d-none" onchange="this.form.submit()">
            </form>
        </div>
    </div>

    <hr />

    {{-- FOR RENT --}}
    <section class="mb-3">
        <h3 class="mb-3">
            {{ __('advertisements.overview.for_rent') }}
            <span class="text-muted">({{ $forRent->count() }}/4)</span>
        </h3>

        <div class="d-flex flex-row gap-3 flex-wrap">
            @forelse ($forRent as $ad)
                <x-advertisement :advertisement="$ad" />
            @empty
                <p class="text-muted">
                    {{ __('advertisements.overview.none_for_rent') }}
                </p>
            @endforelse

            {{ $forRent->links() }}
        </div>
    </section>

    <hr />

    {{-- FOR SALE --}}
    <section>
        <h3 class="mb-3">
            {{ __('advertisements.overview.for_sale') }}
            <span class="text-muted">({{ $forSale->count() }}/4)</span>
        </h3>
        <div class="d-flex flex-row gap-3 flex-wrap mb-3">
            @forelse ($forSale as $ad)
                <x-advertisement :advertisement="$ad" />
            @empty
                <p class="text-muted">
                    {{ __('advertisements.overview.none_for_sale') }}
                </p>
            @endforelse

            {{ $forSale->links() }}
        </div>
    </section>
@endsection

@extends("layouts.app")

@section("title", "Advertisements")

@section("content")
    <x-status-messages />

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>My advertisements</h1>

        <div>
            <a class="btn btn-primary" href="advertisement/create">Create</a>

            <form action="{{ route('advertisement.uploadCsv') }}" method="POST" enctype="multipart/form-data" class="d-inline">
                @csrf

                <label for="csvFile" class="btn btn-secondary">Upload CSV</label>
                <input type="file" id="csvFile" name="csvFile" accept=".csv" class="d-none" onchange="this.form.submit()">
            </form>
        </div>
    </div>

    <hr />

    {{-- FOR RENT --}}
    <section class="mb-3">
        <h3 class="mb-3">
            For rent
            <span class="text-muted">({{ $forRent->count() }}/4)</span>
        </h3>

        <div class="d-flex flex-row gap-3 flex-wrap">
            @forelse ($forRent as $ad)
                <x-advertisement :advertisement="$ad" />
            @empty
                <p class="text-muted">No advertisements for rent.</p>
            @endforelse

            {{ $forRent->links() }}
        </div>
    </section>

    <hr />

    {{-- FOR SALE --}}
    <section>
        <h3 class="mb-3">
            For sale
            <span class="text-muted">({{ $forSale->count() }}/4)</span>
        </h3>
        <div class="d-flex flex-row gap-3 flex-wrap mb-3">
            @forelse ($forSale as $ad)
                <x-advertisement :advertisement="$ad" />
            @empty
                <p class="text-muted">No advertisements for sale.</p>
            @endforelse

            {{ $forSale->links() }}
        </div>
    </section>
@endsection

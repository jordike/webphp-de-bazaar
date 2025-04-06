@extends("layouts.app")

@section("title", "Home")

@section("content")
    <h1>De Bazaar</h1>

    <hr />

    <section>
        <h2 class="mb-2">Latest advertisements</h2>

        <div class="d-flex flex-row gap-3 flex-wrap">
            @foreach ($latestAdvertisements as $advertisement)
                <x-advertisement :advertisement="$advertisement" />
            @endforeach
        </div>
    </section>
@endsection

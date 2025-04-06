@extends("layouts.app")

@section("title", "Home")

@section("content")
    <h1>De Bazaar</h1>

    <hr />

    <section>
        <h2 class="mb-3">Latest advertisements</h2>

        <div class="d-flex flex-row gap-3 flex-wrap">
            @foreach ($latestAdvertisements as $advertisement)
                <x-advertisement :advertisement="$advertisement" />
            @endforeach
        </div>
    </section>

    <hr />

    <section>
        <h2 class="mb-3">Your rented products</h2>

        <table class="table table-striped table-bordered table-hover table-responsive">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Start date</th>
                    <th>End date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rentedProducts as $rentedProduct)
                    <tr>
                        <td>{{ $rentedProduct->advertisement->title }}</td>
                        <td>{{ $rentedProduct->advertisement->description }}</td>
                        <td>€{{ number_format($rentedProduct->advertisement->price, 2, ',', '.') }}</td>
                        <td>{{ $rentedProduct->start_date->format('d-m-Y') }}</td>
                        <td>{{ $rentedProduct->end_date->format('d-m-Y') }}</td>
                        <td>
                            <form action="{{ route('advertisement.rent.return', $rentedProduct) }}" method="POST" class="d-inline">
                                @csrf
                                @method('POST')

                                <button type="submit" class="btn btn-secondary btn-sm">Return</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
@endsection

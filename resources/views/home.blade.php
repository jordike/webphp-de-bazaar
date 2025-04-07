@extends("layouts.app")

@section("title", __("home.title"))

@section("content")
    <h1>{{ __("home.heading") }}</h1>

    <x-status-messages />

    <hr />

    <section>
        <h2 class="mb-3">{{ __("home.latest_advertisements") }}</h2>

        <div class="d-flex flex-row gap-3 flex-wrap">
            @if ($latestAdvertisements->isEmpty())
                <p class="text-muted">{{ __("home.no_advertisements") }}</p>
            @else
                @foreach ($latestAdvertisements as $advertisement)
                    <x-advertisement :advertisement="$advertisement" />
                @endforeach
            @endif
        </div>
    </section>

    @auth
        <hr />

        <section>
            <h2 class="mb-3">{{ __("home.your_rented_products") }}</h2>

            <table class="table table-striped table-bordered table-hover table-responsive">
                <thead>
                    <tr>
                        <th>{{ __("home.table.title") }}</th>
                        <th>{{ __("home.table.description") }}</th>
                        <th>{{ __("home.table.price") }}</th>
                        <th>{{ __("home.table.start_date") }}</th>
                        <th>{{ __("home.table.end_date") }}</th>
                        <th>{{ __("home.table.actions") }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($rentedProducts->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center">{{ __("home.no_rented_products") }}</td>
                        </tr>
                    @else
                        @foreach ($rentedProducts as $rentedProduct)
                            <tr>
                                <td>{{ $rentedProduct->advertisement->title }}</td>
                                <td>{{ $rentedProduct->advertisement->description }}</td>
                                <td>€{{ number_format($rentedProduct->price, 2, ',', '.') }}</td>
                                <td>{{ $rentedProduct->start_date->format('d-m-Y') }}</td>
                                <td>{{ $rentedProduct->end_date->format('d-m-Y') }}</td>
                                <td>
                                    @if ($rentedProduct->isReturned())
                                        <span class="badge bg-success">{{ __("home.returned") }}</span>
                                    @else
                                        <a href="{{ route('advertisement.rent.return', $rentedProduct->id) }}" class="btn btn-primary">{{ __("home.return") }}</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

            {{ $rentedProducts->links() }}
        </section>

        <hr />

        <section>
            <h2 class="mb-3">{{ __("home.your_purchased_products") }}</h2>

            <table class="table table-striped table-bordered table-hover table-responsive">
                <thead>
                    <tr>
                        <th>{{ __("home.table.title") }}</th>
                        <th>{{ __("home.table.description") }}</th>
                        <th>{{ __("home.table.price") }}</th>
                        <th>{{ __("home.table.purchase_date") }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($purchasedProducts->isEmpty())
                        <tr>
                            <td colspan="4" class="text-center">{{ __("home.no_purchased_products") }}</td>
                        </tr>
                    @else
                        @foreach ($purchasedProducts as $purchasedProduct)
                            <tr>
                                <td>{{ $purchasedProduct->advertisement->title }}</td>
                                <td>{{ $purchasedProduct->advertisement->description }}</td>
                                <td>€{{ number_format($purchasedProduct->price, 2, ',', '.') }}</td>
                                <td>{{ $purchasedProduct->created_at->format('d-m-Y') }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

            {{ $purchasedProducts->links() }}
        </section>
    @endauth
@endsection

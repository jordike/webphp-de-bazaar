@extends('layouts.app')

@section('title', 'Agenda')

@section('content')
    <h1>Agenda</h1>

    <x-status-messages />

    <hr />

    <section>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Your advertisements</h2>

            <a href="{{ route('advertisement.create') }}" class="btn btn-outline-primary">Create New Advertisement</a>
        </div>

        <table class="table table-striped table-bordered table-hover table-responsive">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Date placed</th>
                    <th>Expiration date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if ($advertisements->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center">No advertisements found.</td>
                    </tr>
                @else
                    @foreach ($advertisements as $advertisement)
                        <tr>
                            <td>{{ $advertisement->title }}</td>
                            <td>{{ $advertisement->description }}</td>
                            <td>{{ number_format($advertisement->price, 2, ',', '.') }}</td>
                            <td>{{ $advertisement->created_at->format('d-m-Y') }}</td>
                            <td>{{ optional($advertisement->expiration_date)->format('d-m-Y') }}</td>
                            <td>
                                <a href="{{ route('advertisement.edit', $advertisement->id) }}" class="btn btn-secondary btn-sm">Edit</a>

                                <form action="{{ route('advertisement.destroy', $advertisement->id) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger btn-sm delete-button">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        {{ $advertisements->links() }}
    </section>

    <hr />

    <section>
        <h2 class="mb-3">Rented products</h2>

        <table class="table table-striped table-bordered table-hover table-responsive">
            <thead>
                <tr>
                    <th>Advertisement</th>
                    <th>Renter</th>
                    <th>Price</th>
                    <th>Start date</th>
                    <th>End date</th>
                    <th>Return date</th>
                    <th>Wear state</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if ($rentedProducts->isEmpty())
                    <tr>
                        <td colspan="8" class="text-center">No rented products found.</td>
                    </tr>
                @else
                    @foreach ($rentedProducts as $rentedProduct)
                        <tr>
                            <td>{{ $rentedProduct->advertisement->title }}</td>
                            <td>{{ $rentedProduct->user->name }}</td>
                            <td>{{ number_format($rentedProduct->price, 2, ',', '.') }}</td>
                            <td>{{ $rentedProduct->start_date->format('d-m-Y') }}</td>
                            <td>{{ $rentedProduct->end_date->format('d-m-Y') }}</td>
                            <td>{{ optional($rentedProduct->return_date)->format('d-m-Y') }}</td>
                            <td>{{ $rentedProduct->getWearState() }}</td>
                            <td>
                                <a href="{{ route('advertisement.rent.edit', [ 'advertisement' => $rentedProduct->advertisement, 'rent' => $rentedProduct ]) }}" class="btn btn-secondary btn-sm">Edit</a>

                                <form action="{{ route('advertisement.rent.destroy', [ 'advertisement' => $rentedProduct->advertisement, 'rent' => $rentedProduct ]) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger btn-sm delete-button">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        {{ $rentedProducts->links() }}
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('js/deleteConfirmation.js') }}"></script>
@endpush

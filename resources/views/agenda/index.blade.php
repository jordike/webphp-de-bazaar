@extends('layouts.app')

@section('title', 'Agenda')

@section('content')
    <h1>Agenda</h1>

    <x-status-messages />

    <hr />

    <section>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>{{ __('advertisements.your_advertisements') }}</h2>

            <a href="{{ route('advertisement.create') }}" class="btn btn-outline-primary">{{ __('advertisements.create.create') }}</a>
        </div>

        <table class="table table-striped table-bordered table-hover table-responsive">
            <thead>
                <tr>
                    <th>{{ __('advertisements.form.title') }}</th>
                    <th>{{ __('advertisements.form.description') }}</th>
                    <th>{{ __('advertisements.form.price') }}</th>
                    <th>{{ __('advertisements.form.date_placed') }}</th>
                    <th>{{ __('advertisements.form.expiration_date') }}</th>
                    <th>{{ __('advertisements.form.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @if ($advertisements->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center">
                            {{ __('advertisements.overview.no_advertisements') }}
                        </td>
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
                                <a href="{{ route('advertisement.edit', $advertisement->id) }}" class="btn btn-secondary btn-sm">
                                    {{ __('advertisements.edit.edit') }}
                                </a>

                                <form action="{{ route('advertisement.destroy', $advertisement->id) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger btn-sm delete-button">
                                        {{ __('advertisements.edit.delete') }}
                                    </button>
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
        <h2 class="mb-3">{{ __('advertisements.rented_products.title') }}</h2>

        <table class="table table-striped table-bordered table-hover table-responsive">
            <thead>
                <tr>
                    <th>{{ __('advertisements.advertisement') }}</th>
                    <th>{{ __('advertisements.renter') }}</th>
                    <th>{{ __('advertisements.form.price') }}</th>
                    <th>{{ __('advertisements.form.start_date') }}</th>
                    <th>{{ __('advertisements.form.end_date') }}</th>
                    <th>{{ __('advertisements.form.return_date') }}</th>
                    <th>{{ __('advertisements.form.wear_state') }}</th>
                </tr>
            </thead>
            <tbody>
                @if ($rentedProducts->isEmpty())
                    <tr>
                        <td colspan="8" class="text-center">{{ __('advertisements.rented_products.no_rented_products') }}</td>
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

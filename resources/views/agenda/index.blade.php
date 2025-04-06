@extends('layouts.app')

@section('title', 'Agenda')

@section('content')
    <h1>Agenda</h1>

    <x-status-messages />

    <hr />

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
        </tbody>
    </table>

    {{ $advertisements->links() }}

    <hr />

    <h2>Rented products</h2>
@endsection

@push('scripts')
    <script src="{{ asset('js/deleteConfirmation.js') }}"></script>
@endpush

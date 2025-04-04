@extends('layouts.app')

@section('title', 'Manage companies')

@section('content')
    <h1>Companies</h1>

    <x-status-messages />

    @if($companies->isEmpty())
        <p>No companies available.</p>
    @else
        <table class="table table-striped table-responsive table-bordered table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($companies as $company)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $company->name }}</td>
                        <td>{{ $company->email }}</td>
                        <td>
                            <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-secondary btn-sm">Edit</a>

                            <form action="{{ route('companies.destroy', $company->id) }}" method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger btn-sm delete-button">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $companies->links() }}
    @endif
@endsection

@push('scripts')
    <script src="{{ asset('js/deleteConfirmation.js') }}"></script>
@endpush

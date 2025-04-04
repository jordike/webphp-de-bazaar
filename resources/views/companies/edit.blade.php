@extends('layouts.app')

@section('title', 'Manage ' . $company->name)

@section('content')
    <div class="container">
        <h1>Edit Company</h1>

        <x-status-messages />

        <div class="row">
            <div class="col">
                <h2>Company Details</h2>

                <form action="{{ route('companies.update', $company->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <label for="name" class="mb-1">Company Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $company->name) }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="email" class="mb-1">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $company->email) }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="phone" class="mb-1">Phone</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $company->phone) }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="address" class="mb-1">Address</label>
                        <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $company->address) }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="city" class="mb-1">City</label>
                        <input type="text" name="city" id="city" class="form-control" value="{{ old('city', $company->city) }}" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Company</button>
                    <a href="{{ route('companies.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>

            <div class="col">
                <h2>Contracts</h2>

                <table class="table table-striped table-bordered table-hover table-responsive">
                    <thead>
                        <tr>
                            <th>Contract Nr.</th>
                            <th>Is signed</th>
                            <th>Start date</th>
                            <th>End date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contracts as $contract)
                            <tr>
                                <td>{{ $contract->id }}</td>
                                <td>{{ $contract->is_signed ? 'Yes' : 'No' }}</td>
                                <td>{{ $contract->start_date->format('Y-m-d') }}</td>
                                <td>{{ $contract->end_date->format('Y-m-d') }}</td>
                                <td>
                                    <a href="{{ route('contracts.edit', $contract->id) }}" class="btn btn-sm btn-primary">Edit</a>

                                    <form action="{{ route('contracts.destroy', $contract->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-danger delete-button">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        @if ($contracts->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center text-muted">No contracts found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                {{ $contracts->links() }}
            </div>
        </div>
    </div>
@endsection

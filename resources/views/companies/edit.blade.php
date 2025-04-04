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
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="email" class="mb-1">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $company->email) }}" required>
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="phone" class="mb-1">Phone</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $company->phone) }}" required>
                        @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="address" class="mb-1">Address</label>
                        <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $company->address) }}" required>
                        @error('address')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="city" class="mb-1">City</label>
                        <input type="text" name="city" id="city" class="form-control" value="{{ old('city', $company->city) }}" required>
                        @error('city')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Update Company</button>
                    <a href="{{ route('companies.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>

            <div class="col">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2>Contracts</h2>

                    <a href="{{ route('contracts.create', $company) }}" class="btn btn-outline-success">Create Contract</a>
                </div>

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
                                <td>{{ $contract->start_date->format('d-m-Y') }}</td>
                                <td>{{ $contract->end_date->format('d-m-Y') }}</td>
                                <td>
                                    <a href="{{ route('contracts.edit', [ 'contract' => $contract, 'company' => $company ]) }}" class="btn btn-sm btn-secondary">
                                        @if ($contract->is_signed)
                                            View
                                        @else
                                            Edit
                                        @endif
                                    </a>
                                    <a href="{{ route('contracts.download', [ 'contract' => $contract, 'company' => $company ]) }}" class="btn btn-sm btn-secondary">Download</a>

                                    @if (!$contract->is_signed)
                                        <form action="{{ route('contracts.destroy', [ 'contract' => $contract, 'company' => $company ]) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-danger delete-button">Delete</button>
                                        </form>
                                    @endif
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

@push('scripts')
    <script src="{{ asset('js/deleteConfirmation.js') }}"></script>
@endpush

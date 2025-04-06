@extends('layouts.app')

@section('title', 'Manage ' . $company->name)

@section('content')
    <div class="container">
        <h1>{{ __('companies.edit_company') }}</h1>

        <x-status-messages />

        <div class="row">
            <div class="col">
                <h2>{{ __('companies.company_details') }}</h2>

                <form action="{{ route('companies.update', $company->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <label for="name" class="mb-1">{{ __('companies.company_name') }}</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $company->name) }}" required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="email" class="mb-1">{{ __('companies.email') }}</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $company->email) }}" required>
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="phone" class="mb-1">{{ __('companies.phone') }}</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $company->phone) }}" required>
                        @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="address" class="mb-1">{{ __('companies.address') }}</label>
                        <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $company->address) }}" required>
                        @error('address')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="city" class="mb-1">{{ __('companies.city') }}</label>
                        <input type="text" name="city" id="city" class="form-control" value="{{ old('city', $company->city) }}" required>
                        @error('city')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">{{ __('companies.update_company') }}</button>
                    <a href="{{ route('companies.index') }}" class="btn btn-secondary">{{ __('companies.cancel') }}</a>
                </form>
            </div>

            <div class="col">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2>{{ __('companies.contracts') }}</h2>

                    <a href="{{ route('contracts.create', $company) }}" class="btn btn-outline-success">{{ __('companies.create_contract') }}</a>
                </div>

                <table class="table table-striped table-bordered table-hover table-responsive">
                    <thead>
                        <tr>
                            <th>{{ __('companies.contract_nr') }}</th>
                            <th>{{ __('companies.is_signed') }}</th>
                            <th>{{ __('companies.start_date') }}</th>
                            <th>{{ __('companies.end_date') }}</th>
                            <th>{{ __('companies.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contracts as $contract)
                            <tr>
                                <td>{{ $contract->id }}</td>
                                <td>
                                    <span class="{{ $contract->is_signed ? 'text-success' : 'text-danger' }}">
                                        <strong>{{ $contract->is_signed ? __('companies.yes') : __('companies.no') }}</strong>
                                    </span>
                                </td>
                                <td>{{ $contract->start_date->format('d-m-Y') }}</td>
                                <td>{{ $contract->end_date->format('d-m-Y') }}</td>
                                <td>
                                    <a href="{{ route('contracts.edit', [ 'contract' => $contract, 'company' => $company ]) }}" class="btn btn-sm btn-secondary">
                                        @if ($contract->is_signed)
                                            {{ __('companies.view') }}
                                        @else
                                            {{ __('companies.edit') }}
                                        @endif
                                    </a>
                                    <a href="{{ route('contracts.download', [ 'contract' => $contract, 'company' => $company ]) }}" class="btn btn-sm btn-secondary">{{ __('companies.download') }}</a>

                                    @if (!$contract->is_signed)
                                        <form action="{{ route('contracts.destroy', [ 'contract' => $contract, 'company' => $company ]) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-danger delete-button">{{ __('companies.delete') }}</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        @if ($contracts->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center text-muted">{{ __('companies.no_contracts_available') }}</td>
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

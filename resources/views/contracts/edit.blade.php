@extends('layouts.app')

@section('title', __('contracts.edit.title'))

@section('content')
    <div class="col-12 col-md-6 col-lg-4">
        <h1>{{ __('contracts.edit.title') }}</h1>

        <x-status-messages />

        <form action="{{ route('contracts.update', [ $company, $contract ]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="start_date" class="form-label">{{ __('contracts.edit.start_date') }}</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date', $contract->start_date->format('Y-m-d')) }}" required @if ($contract->is_signed) disabled @endif>
                @error('start_date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="end_date" class="form-label">{{ __('contracts.edit.end_date') }}</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date', $contract->end_date->format('Y-m-d')) }}" required @if ($contract->is_signed) disabled @endif>
                @error('end_date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="contract_pdf" class="form-label">{{ __('contracts.edit.upload_pdf') }}</label>
                <input type="file" name="contract_pdf" id="contract_pdf" class="form-control" accept="application/pdf" @if ($contract->is_signed) disabled @endif>
                @error('contract_pdf')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <input type="checkbox" name="signed" id="signed" class="form-check-input" {{ $contract->signed ? 'checked' : '' }} @if ($contract->is_signed) disabled @endif>
                <label class="form-check-label" for="signed">{{ __('contracts.edit.signed') }}</label>
                @error('signed')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            @if ($contract->is_signed)
                <a href="{{ route('companies.edit', $company) }}" class="btn btn-secondary">{{ __('contracts.edit.go_back_button') }}</a>
            @else
                <button type="submit" class="btn btn-primary">{{ __('contracts.edit.update_button') }}</button>
                <a href="{{ route('companies.edit', $company) }}" class="btn btn-secondary">{{ __('contracts.edit.cancel_button') }}</a>
            @endif

        </form>
    </div>
@endsection

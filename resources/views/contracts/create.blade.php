@extends('layouts.app')

@section('title', __('contracts.create.title'))

@section('content')
    <div class="col-12 col-md-6 col-lg-4">
        <h1>{{ __('contracts.create.title') }}</h1>

        <x-status-messages />

        <form action="{{ route('contracts.store', $company) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="start_date" class="form-label">{{ __('contracts.create.start_date') }}</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date') }}" required>
                @error('start_date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="end_date" class="form-label">{{ __('contracts.create.end_date') }}</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date') }}" required>
                @error('end_date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">{{ __('contracts.create.create_button') }}</button>
            <a href="{{ route('companies.edit', $company) }}" class="btn btn-secondary">{{ __('contracts.create.cancel_button') }}</a>
        </form>
    </div>
@endsection

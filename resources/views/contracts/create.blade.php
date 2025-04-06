@extends('layouts.app')

@section('title', 'Create contract')

@section('content')
    <div class="col-12 col-md-6 col-lg-4">
        <h1>Create contract</h1>

        <x-status-messages />

        <form action="{{ route('contracts.store', $company) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date') }}" required>
                @error('start_date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date') }}" required>
                @error('end_date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Create Contract</button>
            <a href="{{ route('companies.edit', $company) }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Manage companies')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Companies</h1>

        <div class="mb-3">
            <a href="{{ route('company.create') }}" class="btn btn-primary">Create Company</a>
        </div>
    </div>

    <div class="d-flex flex-row flex-wrap gap-3">
        @foreach ($companies as $company)
            <div class="card">
                <div class="card-header">
                    {{ $company->name }}
                </div>

                <div class="card-body">
                    <p class="card-text">Email: {{ $company->email }}</p>
                    <p class="card-text">Phone: {{ $company->phone }}</p>
                    <p class="card-text">Address: {{ $company->address }}</p>
                </div>

                <div class="card-footer">
                    <a href="{{ route('company.edit', $company->id) }}" class="btn btn-secondary">Edit</a>

                    <form action="{{ route('company.destroy', $company->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Manage ' . $company->name)

@section('content')
    <div class="container">
        <h1>Edit Company</h1>

        <x-status-messages />

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
                <label for="address" class="mb-1">Address</label>
                <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $company->address) }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="phone" class="mb-1">Phone</label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $company->phone) }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Company</button>
            <a href="{{ route('companies.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection

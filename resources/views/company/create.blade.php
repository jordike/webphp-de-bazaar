@extends('layouts.app')

@section('title', 'Create Company')

@section('content')
    <div class="col-12 col-md-6 col-lg-4">
        <form action="{{ route('company.store') }}" method="POST">
            @csrf

            <h1 class="mb-3">
                {{ __('company.company') }}
            </h1>

            <x-status-messages />

            <div class="form-group mb-3">
                <label for="name" class="mb-1">
                    {{ __('company.fields.name') }}
                </label>
                <input type="text" class="form-control" id="name" name="name" required autofocus>

                @error('name')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="email" class="mb-1">
                    {{ __('company.fields.email') }}
                </label>
                <input type="email" class="form-control" id="email" name="email" required>

                @error('email')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="phone" class="mb-1">
                    {{ __('company.fields.phone') }}
                </label>
                <input type="text" class="form-control" id="phone" name="phone" required>

                @error('phone')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="address" class="mb-1">
                    {{ __('company.fields.address') }}
                </label>
                <input type="text" class="form-control" id="address" name="address" required>

                @error('address')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="city" class="mb-1">
                    {{ __('company.fields.city') }}
                </label>
                <input type="text" class="form-control" id="city" name="city" required>

                @error('city')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary mb-3">
                {{ __('company.create') }}
            </button>

            <a href="{{ route('company.index') }}" class="btn btn-secondary mb-3">
                {{ __('company.cancel') }}
            </a>
        </form>
    </div>
@endsection

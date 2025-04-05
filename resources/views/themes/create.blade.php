@extends('layouts.app')

@section('title', 'Create Theme')

@section('content')
    <div class="col-12 col-md-6 col-lg-4">
        <form action="{{ route('theme.store', $company) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <h1 class="mb-3">
                Create theme
            </h1>

            <x-status-messages />

            <div class="form-group mb-3">
                <label for="name" class="mb-1 fw-bold">
                    Name <span class="text-danger">*</span>
                </label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter theme name" required>

                @error('name')
                    <p class="text-danger small">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="description" class="mb-1 fw-bold">
                    Description
                </label>
                <textarea class="form-control" id="description" name="description" placeholder="Enter theme description" rows="3"></textarea>

                @error('description')
                    <p class="text-danger small">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="primary_color" class="mb-1 fw-bold">
                    Primary Color
                </label>
                <input type="color" class="form-control form-control-color" id="primary_color" name="primary_color" value="#000000" title="Choose primary color">

                @error('primary_color')
                    <p class="text-danger small">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="secondary_color" class="mb-1 fw-bold">
                    Secondary Color
                </label>
                <input type="color" class="form-control form-control-color" id="secondary_color" name="secondary_color" value="#FFFFFF" title="Choose secondary color">

                @error('secondary_color')
                    <p class="text-danger small">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="background_color" class="mb-1 fw-bold">
                    Background Color
                </label>
                <input type="color" class="form-control form-control-color" id="background_color" name="background_color" value="#F0F0F0" title="Choose background color">

                @error('background_color')
                    <p class="text-danger small">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="text_color" class="mb-1 fw-bold">
                    Text Color
                </label>
                <input type="color" class="form-control form-control-color" id="text_color" name="text_color" value="#000000" title="Choose text color">

                @error('text_color')
                    <p class="text-danger small">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="font_family" class="mb-1 fw-bold">
                    Font Family
                </label>
                <input type="text" class="form-control" id="font_family" name="font_family" placeholder="e.g., Arial, sans-serif" value="Arial, sans-serif">

                @error('font_family')
                    <p class="text-danger small">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="font_size" class="mb-1">
                    <span class="fw-bold">Font Size</span>
                    <span class="text-muted small">(in pixels)</span>
                </label>
                <input type="text" class="form-control" id="font_size" name="font_size" placeholder="e.g., 16" value="16">

                @error('font_size')
                    <p class="text-danger small">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="logo_path" class="mb-1 fw-bold">
                    Logo
                </label>
                <input type="file" class="form-control" id="logo_path" name="logo_path" accept="image/*">

                @error('logo_path')
                    <p class="text-danger small">{{ $message }}</p>
                @enderror
            </div>

            <div class="d-flex gap-2 mb-3">
                <button type="submit" class="btn btn-primary">
                    Create
                </button>

                <a href="{{ route('company.edit', $company) }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection

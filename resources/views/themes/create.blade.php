@extends('layouts.app')

@section('title', __('theme.create_theme'))

@section('content')
    <div class="col-12 col-md-6 col-lg-4">
        <form action="{{ route('theme.store', $company) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <h1 class="mb-3">
                {{ __('theme.create_theme') }}
            </h1>

            <x-status-messages />

            <div class="form-group mb-3">
                <label for="name" class="mb-1 fw-bold">
                    {{ __('theme.name') }} <span class="text-danger">*</span>
                </label>
                <input type="text" class="form-control" id="name" name="name" placeholder="{{ __('theme.name_placeholder') }}" required>

                @error('name')
                    <p class="text-danger small">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="description" class="mb-1 fw-bold">
                    {{ __('theme.description') }}
                </label>
                <textarea class="form-control" id="description" name="description" placeholder="{{ __('theme.description_placeholder') }}" rows="3"></textarea>

                @error('description')
                    <p class="text-danger small">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="primary_color" class="mb-1 fw-bold">
                    {{ __('theme.primary_color') }}
                </label>
                <input type="color" class="form-control form-control-color" id="primary_color" name="primary_color" value="#000000" title="{{ __('theme.choose_primary_color') }}">

                @error('primary_color')
                    <p class="text-danger small">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="secondary_color" class="mb-1 fw-bold">
                    {{ __('theme.secondary_color') }}
                </label>
                <input type="color" class="form-control form-control-color" id="secondary_color" name="secondary_color" value="#FFFFFF" title="{{ __('theme.choose_secondary_color') }}">

                @error('secondary_color')
                    <p class="text-danger small">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="background_color" class="mb-1 fw-bold">
                    {{ __('theme.background_color') }}
                </label>
                <input type="color" class="form-control form-control-color" id="background_color" name="background_color" value="#F0F0F0" title="{{ __('theme.choose_background_color') }}">

                @error('background_color')
                    <p class="text-danger small">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="text_color" class="mb-1 fw-bold">
                    {{ __('theme.text_color') }}
                </label>
                <input type="color" class="form-control form-control-color" id="text_color" name="text_color" value="#000000" title="{{ __('theme.choose_text_color') }}">

                @error('text_color')
                    <p class="text-danger small">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="font_family" class="mb-1 fw-bold">
                    {{ __('theme.font_family') }}
                </label>
                <input type="text" class="form-control" id="font_family" name="font_family" placeholder="{{ __('theme.font_family_placeholder') }}" value="Arial, sans-serif">

                @error('font_family')
                    <p class="text-danger small">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="font_size" class="mb-1">
                    <span class="fw-bold">{{ __('theme.font_size') }}</span>
                    <span class="text-muted small">(px)</span>
                </label>
                <input type="text" class="form-control" id="font_size" name="font_size" placeholder="{{ __('theme.font_size_placeholder') }}" value="16">

                @error('font_size')
                    <p class="text-danger small">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="logo_path" class="mb-1 fw-bold">
                    {{ __('theme.logo') }}
                </label>
                <input type="file" class="form-control" id="logo_path" name="logo_path" accept="image/*">

                @error('logo_path')
                    <p class="text-danger small">{{ $message }}</p>
                @enderror
            </div>

            <div class="d-flex gap-2 mb-3">
                <button type="submit" class="btn btn-primary">
                    {{ __('theme.create') }}
                </button>

                <a href="{{ route('company.edit', $company) }}" class="btn btn-secondary">
                    {{ __('theme.cancel') }}
                </a>
            </div>
        </form>
    </div>
@endsection

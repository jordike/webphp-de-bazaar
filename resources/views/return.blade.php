@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ __('return.title') }}</h1>

    <x-status-messages />

    <form method="POST" action="{{ route('advertisement.rent.storeReturn', $rentedProduct->id) }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group mb-3">
            <label for="condition" class="mb-2">{{ __('return.condition_label') }}</label>
            <select name="condition" id="condition" class="form-control">
                <option value="excellent" {{ old('condition') == 'excellent' ? 'selected' : '' }}>{{ __('return.condition_options.excellent') }}</option>
                <option value="good" {{ old('condition') == 'good' ? 'selected' : '' }}>{{ __('return.condition_options.good') }}</option>
                <option value="fair" {{ old('condition') == 'fair' ? 'selected' : '' }}>{{ __('return.condition_options.fair') }}</option>
                <option value="poor" {{ old('condition') == 'poor' ? 'selected' : '' }}>{{ __('return.condition_options.poor') }}</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="scratches" class="mb-2">{{ __('return.scratches_label') }}</label>
            <select name="scratches" id="scratches" class="form-control">
                <option value="none" {{ old('scratches') == 'none' ? 'selected' : '' }}>{{ __('return.scratches_options.none') }}</option>
                <option value="minor" {{ old('scratches') == 'minor' ? 'selected' : '' }}>{{ __('return.scratches_options.minor') }}</option>
                <option value="major" {{ old('scratches') == 'major' ? 'selected' : '' }}>{{ __('return.scratches_options.major') }}</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="functionality" class="mb-2">{{ __('return.functionality_label') }}</label>
            <select name="functionality" id="functionality" class="form-control">
                <option value="yes" {{ old('functionality') == 'yes' ? 'selected' : '' }}>{{ __('return.functionality_options.yes') }}</option>
                <option value="partially" {{ old('functionality') == 'partially' ? 'selected' : '' }}>{{ __('return.functionality_options.partially') }}</option>
                <option value="no" {{ old('functionality') == 'no' ? 'selected' : '' }}>{{ __('return.functionality_options.no') }}</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="cleanliness" class="mb-2">{{ __('return.cleanliness_label') }}</label>
            <select name="cleanliness" id="cleanliness" class="form-control">
                <option value="clean" {{ old('cleanliness') == 'clean' ? 'selected' : '' }}>{{ __('return.cleanliness_options.clean') }}</option>
                <option value="dirty" {{ old('cleanliness') == 'dirty' ? 'selected' : '' }}>{{ __('return.cleanliness_options.dirty') }}</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="product_image" class="mb-2">{{ __('return.product_image_label') }}</label>
            <input type="file" name="product_image" id="product_image" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">{{ __('return.submit_button') }}</button>
        <a href="{{ route('home') }}" class="btn btn-secondary">{{ __('return.cancel_button') }}</a>
    </form>
</div>
@endsection

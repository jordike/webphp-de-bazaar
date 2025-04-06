@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Return Product</h1>

    <x-status-messages />

    <form method="POST" action="{{ route('advertisement.rent.storeReturn', $rentedProduct->id) }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group mb-3">
            <label for="condition" class="mb-2">Condition of the product:</label>
            <select name="condition" id="condition" class="form-control">
                <option value="excellent" {{ old('condition') == 'excellent' ? 'selected' : '' }}>Excellent</option>
                <option value="good" {{ old('condition') == 'good' ? 'selected' : '' }}>Good</option>
                <option value="fair" {{ old('condition') == 'fair' ? 'selected' : '' }}>Fair</option>
                <option value="poor" {{ old('condition') == 'poor' ? 'selected' : '' }}>Poor</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="scratches" class="mb-2">Are there any scratches on the product?</label>
            <select name="scratches" id="scratches" class="form-control">
                <option value="none" {{ old('scratches') == 'none' ? 'selected' : '' }}>None</option>
                <option value="minor" {{ old('scratches') == 'minor' ? 'selected' : '' }}>Minor</option>
                <option value="major" {{ old('scratches') == 'major' ? 'selected' : '' }}>Major</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="functionality" class="mb-2">Is the product fully functional?</label>
            <select name="functionality" id="functionality" class="form-control">
                <option value="yes" {{ old('functionality') == 'yes' ? 'selected' : '' }}>Yes</option>
                <option value="partially" {{ old('functionality') == 'partially' ? 'selected' : '' }}>Partially</option>
                <option value="no" {{ old('functionality') == 'no' ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="cleanliness" class="mb-2">Is the product clean?</label>
            <select name="cleanliness" id="cleanliness" class="form-control">
                <option value="clean" {{ old('cleanliness') == 'clean' ? 'selected' : '' }}>Clean</option>
                <option value="dirty" {{ old('cleanliness') == 'dirty' ? 'selected' : '' }}>Dirty</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="product_image" class="mb-2">Upload a picture of the product:</label>
            <input type="file" name="product_image" id="product_image" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Return</button>
        <a href="{{ route('home') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection

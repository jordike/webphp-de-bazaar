@extends('layouts.app')

@section('title', 'Advertisements')

@section('content')
    <x-status-messages />

    <div class="container">
        <h1 class="text-center">Create your advertisement</h1>

        <div class="row">
            <div class="col-lg-7 mx-auto">
                <div class="card mt-2 mx-auto p-3 bg-light mb-3">
                    <div class="card-body bg-light">
                        <form id="advertisement-form" method="POST" action="{{ route('advertisement.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="title" class="form-label">Title:</label>
                                <input id="title" type="text" name="title" class="form-control"
                                    placeholder="Please enter your product title" required value="{{ old('title') }}">
                                @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description:</label>
                                <textarea id="description" name="description" class="form-control" placeholder="Write your Description here."
                                    rows="4" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 form-check">
                                <input type="hidden" name="is_for_rent" value="0">
                                <input class="form-check-input" type="checkbox" id="is_for_rent" name="is_for_rent" value="1">
                                <label class="form-check-label" for="is_for_rent">Is this for rent?</label>
                                @error('is_for_rent')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">Price:</label>
                                <input id="price" type="text" name="price" class="form-control"
                                    placeholder="Please enter your product price" required value="{{ old('price') }}">
                                @error('price')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="photo" class="form-label">Upload Photo:</label>
                                <input type="file" id="photo" name="photo" class="form-control">
                                @error('photo')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success">Create Advertisement</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

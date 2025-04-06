@extends('layouts.app')

@section('title', 'Edit Advertisement')

@section('content')
    <x-status-messages />

    <div class="container">
        <h1 class="text-center">Edit Your Advertisement</h1>

        <div class="row">
            <div class="col-lg-7 mx-auto">
                <div class="card mt-2 mx-auto p-3 bg-light mb-3">
                    <div class="card-body bg-light">
                        <form id="advertisement-form" method="POST" action="{{ route('advertisement.update', $advertisement->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="title" class="form-label">Title:</label>
                                <input id="title" type="text" name="title" class="form-control"
                                    placeholder="Please enter your product title" required value="{{ old('title', $advertisement->title) }}">
                                @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description:</label>
                                <textarea id="description" name="description" class="form-control" placeholder="Write your Description here."
                                    rows="4" required>{{ old('description', $advertisement->description) }}</textarea>
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 form-check">
                                <input type="hidden" name="is_for_rent" value="0">
                                <input class="form-check-input" type="checkbox" id="is_for_rent" name="is_for_rent" value="1"
                                    {{ old('is_for_rent', $advertisement->is_for_rent) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_for_rent">Is this for rent?</label>
                                @error('is_for_rent')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">Price:</label>
                                <input id="price" type="text" name="price" class="form-control"
                                    placeholder="Please enter your product price" required value="{{ old('price', $advertisement->price) }}">
                                @error('price')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="photo" class="form-label">Upload Photo:</label>
                                <input type="file" id="photo" name="photo" class="form-control">
                                @if($advertisement->photo)
                                    <div class="mt-2">
                                        <img src="{{ $advertisement->getPhotoUrl() }}" alt="Advertisement Photo" class="img-thumbnail" width="150">
                                    </div>
                                @endif
                                @error('photo')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="related_ads" class="form-label">Related Advertisements:</label>
                                <select id="related_ads" name="related_ads[]" class="form-select" multiple>
                                    @foreach($allAdvertisements as $advertisement)
                                        <option value="{{ $advertisement->id }}" {{ in_array($advertisement->id, old('related_ads', [])) ? 'selected' : '' }}>
                                            {{ $advertisement->title }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Hold down the Ctrl (Windows) or Command (Mac) button to select multiple options.</small>
                                @error('related_ads')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success">Update Advertisement</button>
                            </div>
                        </form>

                        <div class="mt-4">
                            <form action="{{ route('advertisement.destroy', $advertisement->id) }}" method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger delete-button">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/deleteConfirmation.js') }}"></script>
@endpush

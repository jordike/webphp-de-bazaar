@extends('layouts.app')

@section('title', 'Edit Company')

@section('content')
    <h1>Edit Company</h1>

    <x-status-messages />

    <div class="row">
        <div class="col">
            <h2>Company details</h2>

            <form action="{{ route('company.update', $company) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group mb-3">
                    <label for="name" class="mb-1">
                        {{ __('company.fields.name') }}
                    </label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $company->name) }}" required autofocus>

                    @error('name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="email" class="mb-1">
                        {{ __('company.fields.email') }}
                    </label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $company->email) }}" required>

                    @error('email')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="phone" class="mb-1">
                        {{ __('company.fields.phone') }}
                    </label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $company->phone) }}" required>

                    @error('phone')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="address" class="mb-1">
                        {{ __('company.fields.address') }}
                    </label>
                    <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $company->address) }}" required>

                    @error('address')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="city" class="mb-1">
                        {{ __('company.fields.city') }}
                    </label>
                    <input type="text" class="form-control" id="city" name="city" value="{{ old('city', $company->city) }}" required>

                    @error('city')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary mb-3">
                    Update
                </button>

                <a href="{{ route('company.index') }}" class="btn btn-secondary mb-3">
                    Cancel
                </a>
            </form>
        </div>

        <div class="col">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Themes</h2>

                <a href="{{ route('themes.create', $company) }}" class="btn btn-primary">Add Theme</a>
            </div>

            <div class="accordion" id="themesAccordion">
                @foreach ($company->themes as $theme)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{ $theme->id }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $theme->id }}" aria-expanded="false" aria-controls="collapse{{ $theme->id }}">
                                {{ $theme->name }}
                            </button>
                        </h2>
                        <div id="collapse{{ $theme->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $theme->id }}" data-bs-parent="#themesAccordion">
                            <div class="accordion-body">
                                <p><strong>Description:</strong> {{ $theme->description }}</p>
                                <p><strong>Primary Color:</strong> <span style="color: {{ $theme->primary_color }}">{{ $theme->primary_color }}</span></p>
                                <p><strong>Secondary Color:</strong> <span style="color: {{ $theme->secondary_color }}">{{ $theme->secondary_color }}</span></p>
                                <p><strong>Background Color:</strong> <span style="color: {{ $theme->background_color }}">{{ $theme->background_color }}</span></p>
                                <p><strong>Text Color:</strong> <span style="color: {{ $theme->text_color }}">{{ $theme->text_color }}</span></p>
                                <p><strong>Font Family:</strong> {{ $theme->font_family }}</p>
                                <p><strong>Font Size:</strong> {{ $theme->font_size }}</p>
                                @if ($theme->logo_path)
                                    <p><strong>Logo:</strong></p>
                                    <img src="{{ $theme->getLogoPath() }}" alt="Logo" class="img-fluid">
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

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

                <a href="{{ route('theme.create', $company) }}" class="btn btn-outline-primary">Add Theme</a>
            </div>

            @if ($company->themes->isEmpty())
                <div class="alert alert-info" role="alert">
                    No themes available. Please add a theme.
                </div>
            @else
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
                                    <div class="mb-3">
                                        <p><strong>Description:</strong> {{ $theme->description }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <p><strong>Primary Color:</strong>
                                            <span class="badge" style="background-color: {{ $theme->primary_color }}; color: #fff;">
                                                {{ $theme->primary_color }}
                                            </span>
                                        </p>
                                    </div>

                                    <div class="mb-3">
                                        <p><strong>Secondary Color:</strong>
                                            <span class="badge" style="background-color: {{ $theme->secondary_color }}; color: #fff;">
                                                {{ $theme->secondary_color }}
                                            </span>
                                        </p>
                                    </div>

                                    <div class="mb-3">
                                        <p><strong>Background Color:</strong>
                                            <span class="badge" style="background-color: {{ $theme->background_color }}; color: #fff;">
                                                {{ $theme->background_color }}
                                            </span>
                                        </p>
                                    </div>

                                    <div class="mb-3">
                                        <p><strong>Text Color:</strong>
                                            <span class="badge" style="background-color: {{ $theme->text_color }}; color: #fff;">
                                                {{ $theme->text_color }}
                                            </span>
                                        </p>
                                    </div>

                                    <div class="mb-3">
                                        <p><strong>Font Family:</strong> <span style="font-family: {{ $theme->font_family }};">{{ $theme->font_family }}</span></p>
                                    </div>

                                    <div class="mb-3">
                                        <p><strong>Font Size:</strong> <span style="font-size: {{ $theme->font_size }}px;">{{ $theme->font_size }}px</span></p>
                                    </div>

                                    @if ($theme->logo_path)
                                        <div class="mb-3">
                                            <p><strong>Logo:</strong></p>
                                            <img src="{{ $theme->getLogoPath() }}" alt="Logo" class="img-fluid rounded shadow-sm">
                                        </div>
                                    @endif

                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('theme.edit', [$company, $theme]) }}" class="btn btn-outline-secondary btn-sm">Edit</a>

                                        <form action="{{ route('theme.destroy', [$company, $theme]) }}" method="POST" class="ms-2 delete-form">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-outline-danger btn-sm delete-button">Delete</button>
                                        </form>

                                        @if ($company->current_theme_id != $theme->id)
                                            <form action="{{ route('theme.use', [$company, $theme]) }}" method="POST" class="ms-2">
                                                @csrf

                                                <button type="submit" class="btn btn-outline-success btn-sm">Use</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/deleteConfirmation.js') }}"></script>
@endpush

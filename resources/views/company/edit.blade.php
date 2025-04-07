@extends('layouts.app')

@section('title', 'Edit Company')

@section('content')
    <h1>{{ __('company.company_details') }}</h1>

    <x-status-messages />

    <div class="accordion mb-3" id="editCompanyAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingCompanyDetails">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCompanyDetails" aria-expanded="true" aria-controls="collapseCompanyDetails">
                    {{ __('company.company_details') }}
                </button>
            </h2>
            <div id="collapseCompanyDetails" class="accordion-collapse collapse show" aria-labelledby="headingCompanyDetails" data-bs-parent="#editCompanyAccordion">
                <div class="accordion-body">
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
                            {{ __('company.update') }}
                        </button>

                        <a href="{{ route('company.index') }}" class="btn btn-secondary mb-3">
                            {{ __('company.cancel') }}
                        </a>
                    </form>
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThemes">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThemes" aria-expanded="false" aria-controls="collapseThemes">
                    {{ __('company.themes') }}
                </button>
            </h2>
            <div id="collapseThemes" class="accordion-collapse collapse" aria-labelledby="headingThemes" data-bs-parent="#editCompanyAccordion">
                <div class="accordion-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2>{{ __('company.themes') }}</h2>

                        <a href="{{ route('theme.create', $company) }}" class="btn btn-outline-primary">{{ __('company.add_theme') }}</a>
                    </div>

                    @if ($themes->isEmpty())
                        <div class="alert alert-info" role="alert">
                            {{ __('company.no_themes_available') }}
                        </div>
                    @else
                        <div class="accordion" id="themesAccordion">
                            @foreach ($themes as $theme)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading{{ $theme->id }}">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $theme->id }}" aria-expanded="false" aria-controls="collapse{{ $theme->id }}">
                                            {{ $theme->name }}
                                        </button>
                                    </h2>

                                    <div id="collapse{{ $theme->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $theme->id }}" data-bs-parent="#themesAccordion">
                                        <div class="accordion-body">
                                            <div class="mb-3">
                                                <p><strong>{{ __('theme.description') }}:</strong> {{ $theme->description }}</p>
                                            </div>

                                            <div class="mb-3">
                                                <p><strong>{{ __('theme.primary_color') }}:</strong>
                                                    <span class="badge" style="background-color: {{ $theme->primary_color }}; color: #fff;">
                                                        {{ $theme->primary_color }}
                                                    </span>
                                                </p>
                                            </div>

                                            <div class="mb-3">
                                                <p><strong>{{ __('theme.secondary_color') }}:</strong>
                                                    <span class="badge" style="background-color: {{ $theme->secondary_color }}; color: #fff;">
                                                        {{ $theme->secondary_color }}
                                                    </span>
                                                </p>
                                            </div>

                                            <div class="mb-3">
                                                <p><strong>{{ __('theme.background_color') }}:</strong>
                                                    <span class="badge" style="background-color: {{ $theme->background_color }}; color: #fff;">
                                                        {{ $theme->background_color }}
                                                    </span>
                                                </p>
                                            </div>

                                            <div class="mb-3">
                                                <p><strong>{{ __('theme.text_color') }}:</strong>
                                                    <span class="badge" style="background-color: {{ $theme->text_color }}; color: #fff;">
                                                        {{ $theme->text_color }}
                                                    </span>
                                                </p>
                                            </div>

                                            <div class="mb-3">
                                                <p><strong>{{ __('theme.font_family') }}:</strong> <span style="font-family: {{ $theme->font_family }};">{{ $theme->font_family }}</span></p>
                                            </div>

                                            <div class="mb-3">
                                                <p><strong>{{ __('theme.font_size')  }}:</strong> <span style="font-size: {{ $theme->font_size }}px;">{{ $theme->font_size }}px</span></p>
                                            </div>

                                            @if ($theme->logo_path)
                                                <div class="mb-3">
                                                    <p><strong>{{ __('theme.logo') }}:</strong></p>
                                                    <img src="{{ $theme->getLogoPath() }}" alt="Logo" class="img-fluid rounded shadow-sm logo">
                                                </div>
                                            @endif

                                            <div class="d-flex justify-content-end">
                                                <a href="{{ route('theme.edit', [$company, $theme]) }}" class="btn btn-outline-secondary btn-sm">{{ __('theme.edit') }}</a>

                                                <form action="{{ route('theme.destroy', [$company, $theme]) }}" method="POST" class="ms-2 delete-form">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-outline-danger btn-sm delete-button">{{ __('theme.delete') }}</button>
                                                </form>

                                                @if ($company->current_theme_id !== $theme->id)
                                                    <form action="{{ route('theme.use', [$company, $theme]) }}" method="POST" class="ms-2">
                                                        @csrf

                                                        <button type="submit" class="btn btn-outline-success btn-sm">{{ __('theme.use') }}</button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('theme.unuse', [$company, $theme]) }}" method="POST" class="ms-2">
                                                        @csrf

                                                        <button type="submit" class="btn btn-outline-success btn-sm">{{ __('theme.unuse') }}</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            {{ $themes->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="headingLandingPage">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLandingPage" aria-expanded="false" aria-controls="collapseLandingPage">
                    {{ __('landing-page.landing_page') }}
                </button>
            </h2>
            <div id="collapseLandingPage" class="accordion-collapse collapse" aria-labelledby="headingLandingPage" data-bs-parent="#editCompanyAccordion">
                <div class="accordion-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2>{{ __('landing-page.landing_page_components') }}</h2>

                        <form action="{{ route('company.landing-page.add', $company) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="input-group">
                                <select name="type" class="form-select" required>
                                    <option value="text">{{ __('landing-page.text') }}</option>
                                    <option value="image">{{ __('landing-page.image') }}</option>
                                    <option value="highlighted_advertisements">{{ __('landing-page.highlighted_advertisements') }}</option>
                                </select>
                                <input type="text" name="content" class="form-control" placeholder="Content (optional)">
                                <button type="submit" class="btn btn-primary">{{ __('landing-page.add') }}</button>
                            </div>
                        </form>
                    </div>

                    @if ($company->landingPageComponents->isEmpty())
                        <div class="alert alert-info" role="alert">
                            {{ __('landing-page.no_components_available') }}
                        </div>
                    @else
                        <ul class="list-group" id="landingPageComponentsList">
                            @foreach ($company->landingPageComponents->sortBy('order') as $component)
                                <li class="list-group-item d-flex justify-content-between align-items-center" data-id="{{ $component->id }}">
                                    <span>
                                        @if ($component->type === 'image')
                                            {{ __('landing-page.image') }}: <img src="{{ asset('storage/' . $component->content) }}" alt="Image" style="max-width: 100px;">
                                        @elseif ($component->type === 'text')
                                            {{ __('landing-page.text') }}: {{ $component->content }}
                                        @elseif ($component->type === 'highlighted_advertisements')
                                            {{ __('landing-page.highlighted_advertisements') }}
                                        @endif
                                    </span>
                                    <div>
                                        <form action="{{ route('company.landing-page.order', $company) }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $component->id }}">
                                            <input type="hidden" name="direction" value="up">
                                            <button type="submit" class="btn btn-secondary btn-sm">{{ __('landing-page.up') }}</button>
                                        </form>
                                        <form action="{{ route('company.landing-page.order', $company) }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $component->id }}">
                                            <input type="hidden" name="direction" value="down">
                                            <button type="submit" class="btn btn-secondary btn-sm">{{ __('landing-page.down') }}</button>
                                        </form>
                                        <form action="{{ route('company.landing-page.delete', [$company, $component]) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm delete-button">{{ __('landing-page.delete') }}</button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/deleteConfirmation.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const typeSelect = document.querySelector('select[name="type"]');
            const contentInput = document.querySelector('input[name="content"]');
            const fileInput = document.createElement('input');

            fileInput.type = 'file';
            fileInput.name = 'image';
            fileInput.classList.add('form-control');
            fileInput.style.display = 'none';

            typeSelect.addEventListener('change', function () {
                if (typeSelect.value === 'image') {
                    contentInput.style.display = 'none';
                    contentInput.value = '';
                    fileInput.style.display = 'block';
                    contentInput.parentNode.insertBefore(fileInput, contentInput.nextSibling);
                } else if (typeSelect.value === 'highlighted_advertisements') {
                    contentInput.style.display = 'none';
                    contentInput.value = '';
                    fileInput.style.display = 'none';
                    fileInput.value = '';
                } else {
                    contentInput.style.display = 'block';
                    fileInput.style.display = 'none';
                    fileInput.value = '';
                }
            });
        });
    </script>
@endpush

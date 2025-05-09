@extends('layouts.app')

@section('title', 'My company')

@section('content')
    <h1>{{ $company->name }}</h1>

    <div class="landing-page">
        @foreach ($company->landingPageComponents->sortBy('order') as $component)
            <div class="landing-page-component mb-4">
                @if ($component->type === 'text')
                    <div class="text-component">
                        <p class="fs-5">{{ $component->content }}</p>
                    </div>
                @elseif ($component->type === 'image')
                    <div class="image-component text-center">
                        <img src="{{ asset('storage/' . $component->content) }}" alt="Image" class="img-fluid rounded shadow-sm">
                    </div>
                @elseif ($component->type === 'highlighted_advertisements')
                    <div class="highlighted-advertisements bg-light p-3 rounded">
                        <h2 class="text-primary">{{ __('landing-page.highlighted_advertisements') }}</h2>
                        <p class="text-muted">{{ __('landing-page.check_out') }}</p>

                        <div class="d-flex flex-row gap-3 flex-wrap">
                            @foreach ($featuredAdvertisements as $advertisement)
                                <x-advertisement :advertisement="$advertisement" />
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
@endsection

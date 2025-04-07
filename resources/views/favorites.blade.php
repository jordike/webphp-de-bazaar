@extends('layouts.app')

@section('title', 'My Favorites')

@section('content')
    <h1>{{ __('favorites.my_favorites') }}</h1>

    <div class="favorites-list">
        @if ($favorites->isEmpty())
            <p class="text-muted">{{ __('favorites.no_favorites') }}</p>
        @else
            <div class="d-flex flex-row gap-3 flex-wrap">
                @foreach ($favorites as $favorite)
                    <x-advertisement :advertisement="$favorite->advertisement" />
                @endforeach
            </div>

            {{ $favorites->links() }}
        @endif
    </div>
@endsection

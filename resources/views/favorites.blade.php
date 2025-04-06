@extends('layouts.app')

@section('title', 'My Favorites')

@section('content')
    <h1>My Favorites</h1>

    <div class="favorites-list">
        @if ($favorites->isEmpty())
            <p class="text-muted">You have no favorite advertisements.</p>
        @else
            <div class="d-flex flex-row gap-3 flex-wrap">
                @foreach ($favorites as $favorite)
                    <x-advertisement :advertisement="$favorite->advertisement" />
                @endforeach
            </div>
        @endif
    </div>
@endsection

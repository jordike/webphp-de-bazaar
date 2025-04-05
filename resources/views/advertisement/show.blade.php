@extends('layouts.app')

@section('title', $advertisement->title)

@section('content')
<div class="container mx-auto mt-6">
    <div class="bg-white shadow rounded p-6">
        <h1 class="text-2xl font-bold mb-4">{{ $advertisement->title }}</h1>
        <p class="mb-2 text-gray-700">{{ $advertisement->description }}</p>
        <p class="mb-2"><strong>Price:</strong> €{{ number_format($advertisement->price, 2) }}</p>
        <p class="mb-2"><strong>Status:</strong> {{ $advertisement->is_for_rent ? 'For Rent' : 'For Sale' }}</p>

        @if($advertisement->photo)
            <div class="mt-4">
                <img src="{{ Storage::url($advertisement->photo) }}" alt="Photo" class="rounded w-full max-w-md">
            </div>
        @endif
        <div class="mt-4">
            <h3 class="text-lg font-semibold">Share this ad:</h3>
            <img src="{{ $qrCodeDataUrl }}" alt="QR Code" class="mt-2">
        </div>
    </div>
</div>
<div class="">
    <a href="/advertisement/{{ $advertisement->id }}/edit">Edit Job</a>
</div>

@endsection

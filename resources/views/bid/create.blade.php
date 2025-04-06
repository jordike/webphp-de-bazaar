@extends('layouts.app')

@section('title', 'Create Bid')

@section('content')
    <x-status-messages />

    <div class="container">
        <h1 class="text-center">{{ __('bid.create_your_bid') }}</h1>

        <div class="row">
            <div class="col-lg-7 mx-auto">
                <div class="card mt-2 mx-auto p-3 bg-light mb-3">
                    <div class="card-body bg-light">
                        <form id="bid-form" method="POST" action="{{ route('advertisement.bid.store', $advertisement) }}" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="amount" class="form-label">{{ __('bid.bid_amount') }}:</label>
                                <input id="amount" type="text" name="amount" class="form-control"
                                    placeholder="{{ __('bid.bid_amount_placeholder') }}" required value="{{ old('amount') }}">
                                @error('amount')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">{{ __('bid.submit_bid') }}</button>
                            <a href="{{ route('advertisement.show', $advertisement) }}" class="btn btn-secondary">{{ __('bid.cancel') }}</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

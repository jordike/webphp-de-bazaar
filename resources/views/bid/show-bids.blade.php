@extends('layouts.app')

@section('title', 'Bid Details')

@section('content')
    <x-status-messages />

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ __('bid.bids_for_advertisement') }}: {{ $advertisement->title }}</h1>

        <div class="d-flex gap-2">
            @if ($advertisement->user_id !== auth()->id())
                <a class="btn btn-secondary" href="{{ route('advertisement.bid.create', $advertisement) }}">
                    {{ __('bid.place_bid') }}
                </a>
            @endif

            <a class="btn btn-primary" href="{{ route('advertisement.show', $advertisement) }}">
                {{ __('bid.back_to_advertisement') }}
            </a>
        </div>
    </div>

    <table class="table table-bordered table-striped table-hover table-responsive">
        <thead>
            <tr>
                <th>{{ __('bid.user') }}</th>
                <th>{{ __('bid.amount') }}</th>
                <th>{{ __('bid.status') }}</th>
                @if ($advertisement->user_id === auth()->id())
                    <th>{{ __('bid.actions') }}</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @if ($bids->isEmpty())
                <tr>
                    <td colspan="{{ $advertisement->user_id === auth()->id() ? 4 : 3 }}" class="text-center text-muted">
                        {{ __('bid.no_bids_available') }}
                    </td>
                </tr>
            @else
                @foreach ($bids as $bid)
                    <tr>
                        <td>{{ $bid->user->name }}</td>
                        <td>${{ number_format($bid->amount, 2) }}</td>
                        <td>
                            <strong>
                                <span class="{{ $bid->status === 'accepted' ? 'text-success' : ($bid->status === 'rejected' ? 'text-danger' : 'text-warning') }}">
                                    {{ ucfirst(__($bid->status)) }}
                                </span>
                            </strong>
                        </td>
                        @if ($advertisement->user_id == auth()->id())
                            <td>
                                @if ($bid->status === 'pending')
                                    <form action="{{ route('advertisement.bid.accept', [ 'advertisement' => $bid->advertisement, 'bid' => $bid ]) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PATCH')

                                        <button type="submit" class="btn btn-success">{{ __('bid.accept') }}</button>
                                    </form>

                                    <form action="{{ route('advertisement.bid.reject', [ 'advertisement' => $bid->advertisement, 'bid' => $bid ]) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PATCH')

                                        <button type="submit" class="btn btn-danger">{{ __('bid.reject') }}</button>
                                    </form>
                                @else
                                    <span class="text-muted">
                                        {{ __('bid.no_actions_available') }}
                                    </span>
                                @endif
                            </td>
                        @endif
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-4">
        {{ $bids->links() }}
    </div>
@endsection

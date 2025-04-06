@extends('layouts.app')

@section('title', 'Bid Details')

@section('content')
    <x-status-messages />

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Bids for advertisement: {{ $advertisement->title }}</h1>

        <div class="d-flex gap-2">
            @if ($advertisement->user_id !== auth()->id())
                <a class="btn btn-secondary" href="{{ route('advertisement.bid.create', $advertisement) }}">
                    Place bid
                </a>
            @endif

            <a class="btn btn-primary" href="{{ route('advertisement.show', $advertisement) }}">
                Back to advertisement
            </a>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>User</th>
                <th>Amount</th>
                <th>Status</th>
                @if ($advertisement->user_id === auth()->id())
                    <th>Actions</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($bids as $bid)
                <tr>
                    <td>{{ $bid->user->name }}</td>
                    <td>${{ number_format($bid->amount, 2) }}</td>
                    <td>
                        <strong>
                            <span class="{{ $bid->status === 'accepted' ? 'text-success' : ($bid->status === 'rejected' ? 'text-danger' : 'text-warning') }}">
                                {{ ucfirst($bid->status) }}
                            </span>
                        </strong>
                    </td>
                    @if ($advertisement->user_id == auth()->id())
                        <td>
                            @if ($bid->status === 'pending')
                                <form action="{{ route('advertisement.bid.accept', [ 'advertisement' => $bid->advertisement, 'bid' => $bid ]) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit" class="btn btn-success">Accept</button>
                                </form>

                                <form action="{{ route('advertisement.bid.reject', [ 'advertisement' => $bid->advertisement, 'bid' => $bid ]) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit" class="btn btn-danger">Reject</button>
                                </form>
                            @else
                                <span class="text-muted">No actions available</span>
                            @endif
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@extends('layouts.app')

@section('title', 'Bid Details')

@section('content')
    <h1>Bids for Advertisement: {{ $advertisement->title }}</h1>

    <table class="table">
        <thead>
            <tr>
                <th>User</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bids as $bid)
                <tr>
                    <td>{{ $bid->user->name }}</td>
                    <td>${{ number_format($bid->amount, 2) }}</td>
                    <td>{{ ucfirst($bid->status) }}</td>
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
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

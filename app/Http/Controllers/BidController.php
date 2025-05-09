<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\Bid;
use App\Models\PurchasedProduct;
use App\Models\RentedProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BidController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Advertisement $advertisement)
    {
        $pendingBids = auth()->user()->bids()->where('status', 'pending')->count();

        if ($pendingBids >= 4) {
            return redirect()->route('advertisement.bid.show-bids', $advertisement)
                ->with('error', __('bid.messages.max_bid_amount'));
        }

        return view('bid.create', [
            'advertisement' => $advertisement,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Advertisement $advertisement)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        $advertisement->bids()->create([
            'advertisement_id' => $advertisement->id,
            'user_id' => auth()->id(),
            'amount' => $request->input('amount'),
        ]);

        return redirect()->route('advertisement.bid.show-bids', $advertisement)
            ->with('success', __('bid.messages.bid_placed'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function showBids(Request $request, Advertisement $advertisement)
    {
        $bids = $advertisement->bids()->paginate(10);

        return view('bid.show-bids', [
            'advertisement' => $advertisement,
            'bids' => $bids,
        ]);
    }

    public function accept(Request $request, Advertisement $advertisement, Bid $bid)
    {
        Gate::authorize('processBid', $bid);

        $bid->status = 'accepted';
        $bid->save();

        if ($bid->advertisement->is_for_rent) {
            RentedProduct::create([
                'advertisement_id' => $bid->advertisement_id,
                'user_id' => $bid->user_id,
                'price' => $bid->amount,
                'start_date' => now(),
                'end_date' => now()->addDays(30),
            ]);
        } else {
            PurchasedProduct::create([
                'advertisement_id' => $bid->advertisement_id,
                'user_id' => $bid->user_id,
                'price' => $bid->amount,
            ]);
        }

        return redirect()->route('advertisement.bid.show-bids', $advertisement)
            ->with('success', __('bid.messages.bid_accepted'));
    }

    public function reject(Request $request, Advertisement $advertisement, Bid $bid)
    {
        Gate::authorize('processBid', $bid);

        $bid->status = 'rejected';
        $bid->save();

        return redirect()->route('advertisement.bid.show-bids', $advertisement)
            ->with('success', __('bid.messages.bid_rejected'));
    }
}

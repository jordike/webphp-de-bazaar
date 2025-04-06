<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;

class HomeController extends Controller
{
    public function __invoke()
    {
        $latestAdvertisements = Advertisement::latest()->take(3)->get();
        $rentedProducts = auth()->user()
            ->rentedProducts()
            ->with('advertisement')
            ->paginate(10);
        $purchasedProducts = auth()->user()
            ->purchasedProducts()
            ->with('advertisement')
            ->paginate(10);

        return view('home', [
            'latestAdvertisements' => $latestAdvertisements,
            'rentedProducts' => $rentedProducts,
            'purchasedProducts' => $purchasedProducts,
        ]);
    }
}

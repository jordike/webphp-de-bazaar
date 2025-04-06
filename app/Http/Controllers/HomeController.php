<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\RentedProduct;

class HomeController extends Controller
{
    public function __invoke()
    {
        $latestAdvertisements = Advertisement::latest()->take(3)->get();
        $rentedProducts = RentedProduct::where('user_id', auth()->id())
            ->paginate(10);

        return view('home', [
            'latestAdvertisements' => $latestAdvertisements,
            'rentedProducts' => $rentedProducts,
        ]);
    }
}

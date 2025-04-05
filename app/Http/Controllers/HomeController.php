<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;

class HomeController extends Controller
{
    public function __invoke()
    {
        $latestAdvertisements = Advertisement::latest()->take(3)->get();

        return view('home', [
            'latestAdvertisements' => $latestAdvertisements,
        ]);
    }
}

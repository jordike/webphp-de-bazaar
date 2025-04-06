<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\RentedProduct;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index()
    {
        $advertisements = Advertisement::where('user_id', auth()->id())
            ->orderByRaw('expiration_date IS NULL ASC')
            ->orderBy('expiration_date', 'asc')
            ->paginate(10);
        $rentedProducts = RentedProduct::where('user_id', auth()->id())
            ->orderByRaw('return_date IS NULL ASC')
            ->orderBy('return_date', 'asc')
            ->paginate(10);

        return view('agenda.index', [
            'advertisements' => $advertisements,
            'rentedProducts' => $rentedProducts,
        ]);
    }
}

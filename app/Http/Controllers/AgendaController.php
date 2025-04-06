<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index()
    {
        $advertisements = Advertisement::where('user_id', auth()->id())
            ->orderByRaw('expiration_date IS NULL ASC')
            ->orderBy('expiration_date', 'asc')
            ->paginate(10);

        return view('agenda.index', [
            'advertisements' => $advertisements,
        ]);
    }
}

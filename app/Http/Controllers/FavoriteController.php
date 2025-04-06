<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index(Request $request)
    {
        $favorites = $request->user()->favorites()->with('advertisement')->paginate(10);

        return view('favorites', [
            'favorites' => $favorites
        ]);
    }

    public function favorite(Advertisement $advertisement)
    {
        $user = auth()->user();
        $favorite = $user->favorites()->where('advertisement_id', $advertisement->id)->first();

        if ($favorite) {
            $favorite->delete();
        } else {
            $user->favorites()->create([
                'advertisement_id' => $advertisement->id
            ]);
        }

        return redirect()->back();
    }
}

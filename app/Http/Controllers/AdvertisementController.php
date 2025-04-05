<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Advertisement;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $forRent = Advertisement::where('user_id', $user->id)
        ->where('is_for_rent', true)
        ->latest()
        ->get();

        $forSale = Advertisement::where('user_id', $user->id)
            ->where('is_for_rent', false)
            ->latest()
            ->get();

    return view('advertisement.index', compact('forRent', 'forSale'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('advertisement.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'is_for_rent' => 'required|boolean',
            'price' => 'required|numeric',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validates image file
        ]);

        // TODO: Ensure user is authenticated (check if user is logged in)
        $userId = Auth::id(); // Get the authenticated user's ID

        // Handle photo upload if it exists
        $photoPath = null;
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $photoPath = $request->file('photo')->store('public/advertisements'); // Store the photo
        }

        Advertisement::create([
            ...$validated,
            'user_id' => $userId,
            'photo' => $photoPath,
        ]);

        return redirect('/advertisement')->with('success', 'Advertisement created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Advertisement $advertisement)
    {
        return view('advertisement.show', compact('advertisement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Advertisement $advertisement)
    {
        return view('advertisement.edit', compact('advertisement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Advertisement $advertisement)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'is_for_rent' => 'required|boolean',
            'price' => 'required|numeric',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        // Update the advertisement with validated data
        $advertisement->update($validated);
    
        // Handle the photo upload if a new one is uploaded
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $photoPath = $request->file('photo')->store('public/advertisements');
            $advertisement->photo = $photoPath;
            $advertisement->save();
        }
    
        return redirect('advertisement.show, $advertisement->id')->with('success', 'Advertisement updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advertisement $advertisement)
    {
        $advertisement->delete();

        return redirect('/advertisment');
    }
}

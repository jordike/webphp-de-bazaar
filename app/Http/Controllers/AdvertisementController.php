<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Advertisement;
use App\Http\Controllers\Controller;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Str;
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
        $user = Auth::user();

    // Get advertisements for the current user (for Rent, you can modify based on your needs)
        $allAdvertisements = Advertisement::all()->where('user_id', $user->id);
        return view('advertisement.create', compact('allAdvertisements'));
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
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'related_ads' => 'nullable|array', 
        ]);

        // TODO: Ensure user is authenticated (check if user is logged in)
        $userId = Auth::id();

        $adCount = Advertisement::where('user_id', $userId)
                            ->where('is_for_rent', $request->is_for_rent)
                            ->count();

        if ($adCount >= 4) {
            return redirect()->back()->with('error', 'You can only create up to 4 advertisements in this category.');
        }

        $photoPath = null;
    if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
        $photo = $request->file('photo');
        $filename = Str::uuid() . '.' . $photo->getClientOriginalExtension();
        $photoPath = $photo->storeAs('advertisements', $filename, 'public');
    }
        $advertisement = Advertisement::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'is_for_rent' => $validated['is_for_rent'],
            'user_id' => $userId,
            'photo' => $photoPath,
        ]);

        if ($request->has('related_ads')) {
            $advertisement->relatedAdvertisements()->sync($request->related_ads); // sync related ads
        }

        return redirect('/advertisement')->with('success', 'Advertisement created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Advertisement $advertisement)
    {
        $adUrl = route('advertisement.show', ['advertisement' => $advertisement->id]);

        $writer = new PngWriter();

        
        $qrCode = new QrCode($adUrl);
        $result = $writer->write($qrCode);

        $qrCodeDataUrl = $result->getDataUri();

    return view('advertisement.show', compact('advertisement', 'qrCodeDataUrl'));    }

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
    
        $userId = Auth::id();

        $adCount = Advertisement::where('user_id', $userId)
        ->where('is_for_rent', $request->is_for_rent)
        ->count();

        if ($adCount >= 4) {
        return redirect()->back()->with('error', 'You can only create up to 4 advertisements in this category.');
        }

        $advertisement->fill($validated);

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $photo = $request->file('photo');
            $filename = Str::uuid() . '.' . $photo->getClientOriginalExtension();
    
            $photoPath = $photo->storeAs('advertisements', $filename, 'public');
    
            $advertisement->photo = $photoPath;
        }
    
        $advertisement->save();
    
        return redirect('/advertisement/' . $advertisement->id)
            ->with('success', 'Advertisement updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advertisement $advertisement)
    {
        $advertisement->delete();

        return redirect('/advertisement');
    }
}

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

        $adCount = Advertisement::where('user_id', $userId)
                            ->where('is_for_rent', $request->is_for_rent)
                            ->count();

        if ($adCount >= 4) {
            return redirect()->back()->with('error', 'You can only create up to 4 advertisements in this category.');
        }

        // Handle photo upload if it exists
        $photoPath = null;
    if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
        $photo = $request->file('photo');
        $filename = Str::uuid() . '.' . $photo->getClientOriginalExtension();

        // Save in storage/app/public/advertisements
        // Store in DB as: advertisements/filename.jpg
        $photoPath = $photo->storeAs('advertisements', $filename, 'public');
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

        // ✅ Handle the photo upload if present
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $photo = $request->file('photo');
            $filename = Str::uuid() . '.' . $photo->getClientOriginalExtension();
    
            // Save to storage/app/public/advertisements
            $photoPath = $photo->storeAs('advertisements', $filename, 'public');
    
            // ✅ Assign stored path to model (not the tmp path!)
            $advertisement->photo = $photoPath;
        }
    
        // ✅ Save updated model
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

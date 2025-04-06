<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Advertisement;
use App\Http\Controllers\Controller;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

        return view('advertisement.index', [
            'forRent' => $forRent,
            'forSale' => $forSale
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $allAdvertisements = Advertisement::all()->where('user_id', auth()->id());

        return view('advertisement.create', [
            'allAdvertisements' => $allAdvertisements,
        ]);
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

        $adCount = Advertisement::where('user_id', auth()->id())
            ->where('is_for_rent', $request->is_for_rent)
            ->count();

        if ($adCount >= 4) {
            return redirect()->back()->with('error', 'You can only create up to 4 advertisements in this category.');
        }

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
            'user_id' => auth()->id(),
            'photo' => $photoPath,
            'expiration_date' => now()->addDays(30),
        ]);

        if ($request->has('related_ads')) {
            $advertisement->relatedAdvertisements()->sync($request->related_ads); // sync related ads
        }

        return redirect()->route('advertisement.index')
            ->with('success', 'Advertisement created successfully!');
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

        return view('advertisement.show', [
            'advertisement' => $advertisement,
            'qrCodeDataUrl' => $qrCodeDataUrl
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Advertisement $advertisement)
    {
        $allAdvertisements = Advertisement::where('user_id', auth()->id())->get();
        $relatedAds = $advertisement->relatedAdvertisements->pluck('id')->toArray();

        return view('advertisement.edit', [
            'advertisement' => $advertisement,
            'allAdvertisements' => $allAdvertisements,
            'relatedAds' => $relatedAds,
        ]);
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

        $adCount = Advertisement::where('user_id', auth()->id())
            ->where('is_for_rent', $request->is_for_rent)
            ->count();

        if ($adCount >= 4) {
            return redirect()->back()
                ->with('error', 'You can only create up to 4 advertisements in this category.');
        }

        $advertisement->fill($validated);

        // Handle the photo upload if a new one is uploaded
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $photo = $request->file('photo');
            $photoPath = $photo->storeAs('advertisements', Str::uuid() . '.' . $photo->getClientOriginalExtension(), 'local');

            $advertisement->photo = $photoPath;
        }

        $advertisement->save();

        if ($request->has('related_ads')) {
            $advertisement->relatedAdvertisements()->sync($request->related_ads); // Sync related ads
        }

        return redirect()->route('advertisement.show', $advertisement->id)
            ->with('success', 'Advertisement updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advertisement $advertisement)
    {
        $advertisement->delete();

        return redirect()->route('advertisement.index')
            ->with('success', 'Advertisement deleted successfully!');
    }

    /**
     * Handle the upload of a CSV file to create multiple advertisements.
     */
    public function uploadCsv(Request $request)
    {
        $request->validate([
            'csvFile' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $data = array_map('str_getcsv', file($request->file('csvFile')->getRealPath()));
        $header = array_shift($data);

        $adCounts = [
            'for_rent' => Advertisement::where('user_id', auth()->id())->where('is_for_rent', true)->count(),
            'for_sale' => Advertisement::where('user_id', auth()->id())->where('is_for_rent', false)->count(),
        ];

        $newAdCounts = collect($data)->reduce(function ($counts, $row) use ($header) {
            $type = isset($row[array_search('type', $header)]) && $row[array_search('type', $header)] === 'for_rent' ? 'for_rent' : 'for_sale';
            $counts[$type]++;
            return $counts;
        }, ['for_rent' => 0, 'for_sale' => 0]);

        foreach (['for_rent', 'for_sale'] as $type) {
            if ($adCounts[$type] + $newAdCounts[$type] > 4) {
                $typeName = $type === 'for_rent' ? 'rental' : 'regular';

                return redirect()->back()
                    ->with('error', "You have reached the limit of 4 {$typeName} advertisements. Please delete an existing advertisement before adding more.");
            }
        }

        foreach ($data as $row) {
            Advertisement::create(array_combine($header, $row) + [
                'user_id' => auth()->id()
            ]);
        }

        return redirect()->route('advertisement.index')
            ->with('success', 'Advertisements created successfully from CSV.');
    }

    public function review(Request $request, Advertisement $advertisement)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $advertisement->reviews()->create([
            'advertisement_id' => $advertisement->id,
            'user_id' => auth()->id(),
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
        ]);

        return redirect()->route('advertisement.show', $advertisement)
            ->with('success', 'Review submitted successfully!');
    }
}

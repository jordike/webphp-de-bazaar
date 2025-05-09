<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Advertisement;
use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\User;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $forRent = Advertisement::where('is_for_rent', true)->latest()->paginate(10);
        $forSale = Advertisement::where('is_for_rent', false)->latest()->paginate(10);

        return view('advertisement.index', [
            'forRent' => $forRent,
            'forSale' => $forSale,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Advertisement::class);

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
        Gate::authorize('create', Advertisement::class);

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
            return redirect()->back()->with('error', __('advertisements.messages.max_four_ads_per_category'));
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
            ->with('success', __('advertisements.messages.advertisement_created'));
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

        $reviews = $advertisement->reviews()->with('user')->latest()->paginate(5);

        return view('advertisement.show', [
            'advertisement' => $advertisement,
            'qrCodeDataUrl' => $qrCodeDataUrl,
            'reviews' => $reviews,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Advertisement $advertisement)
    {
        Gate::authorize('update', $advertisement);

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
        Gate::authorize('update', $advertisement);

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
                ->with('error', __('advertisements.messages.max_four_ads_per_category'));
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
            ->with('success', __('advertisements.messages.advertisement_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advertisement $advertisement)
    {
        Gate::authorize('delete', $advertisement);

        $advertisement->delete();

        return redirect()->route('advertisement.index')
            ->with('success', __('advertisements.messages.advertisement_deleted'));
    }

    /**
     * Handle the upload of a CSV file to create multiple advertisements.
     */
    public function uploadCsv(Request $request)
    {
        Gate::authorize('create', Advertisement::class);

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
                    ->with('error', __('advertisements.messages.max_of_category_reached', ['type' => $typeName]));
            }
        }

        foreach ($data as $row) {
            Advertisement::create(array_combine($header, $row) + [
                'user_id' => auth()->id()
            ]);
        }

        return redirect()->route('advertisement.index')
            ->with('success', __('advertisements.messages.advertisements_created_from_csv'));
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

        return redirect()->back()
            ->with('success', __('reviews.messages.review_submitted'));
    }

    public function advertiser(User $advertiser)
    {
        $advertisements = Advertisement::where('user_id', $advertiser->id)->latest()->get();

        return view('advertisement.advertiser', [
            'advertiser' => $advertiser,
            'advertisements' => $advertisements,
        ]);
    }

    public function reviewAdvertiser(Request $request, User $advertiser)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $advertiser->reviews()->create([
            'user_id' => auth()->id(),
            'advertiser_id' => $advertiser->id,
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
        ]);

        return redirect()->back()
            ->with('success', __('reviews.messages.review_submitted'));
    }

    public function deleteReview(Request $request, User $advertiser, Review $review)
    {
        if ($review->user_id != auth()->id()) {
            return redirect()->back()
                ->with('error', __('reviews.messages.unauthorized_to_delete'));
        }

        $review->delete();

        return redirect()->back()
            ->with('success', __('reviews.messages.review_deleted'));
    }

    public function myAdvertisements()
    {
        Gate::authorize('create', Advertisement::class);

        $user = Auth::user();
        $forRent = Advertisement::where('user_id', $user->id)
            ->where('is_for_rent', true)
            ->latest()
            ->paginate(10);
        $forSale = Advertisement::where('user_id', $user->id)
            ->where('is_for_rent', false)
            ->latest()
            ->paginate(10);

        return view('advertisement.my-advertisements', [
            'forRent' => $forRent,
            'forSale' => $forSale
        ]);
    }
}

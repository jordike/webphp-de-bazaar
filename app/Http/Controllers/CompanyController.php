<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\LandingPageComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Company::class);

        return view('company.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Company::class);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
        ]);

        $company = new Company();
        $company->name = $request->input('name');
        $company->email = $request->input('email');
        $company->phone = $request->input('phone');
        $company->address = $request->input('address');
        $company->city = $request->input('city');
        $company->user_id = auth()->id();
        $company->save();

        return redirect()->route('company.edit', $company)
            ->with('success', __('company.success.company_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        $featuredAdvertisements = $company->advertisements()->inRandomOrder()->take(3)->get();

        return view('company.landing-page', [
            'company' => $company,
            'featuredAdvertisements' => $featuredAdvertisements,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $company = Company::findOrFail($id);

        Gate::authorize('update', $company);

        $themes = $company->themes()->paginate(10);

        return view('company.edit', [
            'company' => $company,
            'themes' => $themes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $company = Company::findOrFail($id);

        Gate::authorize('update', $company);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
        ]);

        $company->name = $request->input('name');
        $company->email = $request->input('email');
        $company->phone = $request->input('phone');
        $company->address = $request->input('address');
        $company->city = $request->input('city');
        $company->save();

        return redirect()->route('company.edit', $company)
            ->with('success', __('company.success.company_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Add a new landing page component.
     */
    public function addLandingPageComponent(Request $request, Company $company)
    {
        Gate::authorize('update', $company);

        $this->validateLandingPageComponent($request);

        $component = new LandingPageComponent();
        $component->company_id = $company->id;
        $component->type = $request->input('type');

        if ($request->input('type') === LandingPageComponent::TYPE_HIGHLIGHTED_ADVERTISEMENTS) {
            $component->content = null; // No content is required for highlighted advertisements
        } elseif ($request->input('type') === LandingPageComponent::TYPE_IMAGE && $request->hasFile('image')) {
            $path = $request->file('image')->store('landing_page_images', 'public');
            $component->content = $path;
        } else {
            $component->content = $request->input('content');
        }

        $component->order = $company->landingPageComponents()->max('order') + 1;
        $component->save();

        return redirect()->route('company.edit', $company)
            ->with('success', __('company.success.landing_page_component_added'));
    }

    /**
     * Validate the request for adding a landing page component.
     */
    private function validateLandingPageComponent(Request $request): void
    {
        $rules = [
            'type' => 'required|in:' . implode(',', LandingPageComponent::getAllowedTypes()),
        ];

        if ($request->input('type') === LandingPageComponent::TYPE_TEXT) {
            $rules['content'] = 'required|string';
        } elseif ($request->input('type') === LandingPageComponent::TYPE_IMAGE) {
            $rules['image'] = 'required|file|mimes:jpeg,png,jpg,gif|max:2048';
        }

        $request->validate($rules);
    }

    /**
     * Update the order of landing page components.
     */
    public function updateLandingPageComponentOrder(Request $request, Company $company)
    {
        Gate::authorize('update', $company);

        $request->validate([
            'id' => 'required|exists:landing_page_components,id',
            'direction' => 'required|in:up,down',
        ]);

        $component = LandingPageComponent::findOrFail($request->input('id'));

        if ($request->input('direction') === 'up') {
            $previousComponent = LandingPageComponent::where('company_id', $company->id)
                ->where('order', '<', $component->order)
                ->orderBy('order', 'desc')
                ->first();

            if ($previousComponent) {
                $tempOrder = $component->order;
                $component->order = $previousComponent->order;
                $previousComponent->order = $tempOrder;

                $component->save();
                $previousComponent->save();
            }
        } elseif ($request->input('direction') === 'down') {
            $nextComponent = LandingPageComponent::where('company_id', $company->id)
                ->where('order', '>', $component->order)
                ->orderBy('order', 'asc')
                ->first();

            if ($nextComponent) {
                $tempOrder = $component->order;
                $component->order = $nextComponent->order;
                $nextComponent->order = $tempOrder;

                $component->save();
                $nextComponent->save();
            }
        }

        return redirect()->route('company.edit', $company)
            ->with('success', __('company.success.component_order_updated'));
    }

    /**
     * Delete a landing page component.
     */
    public function deleteLandingPageComponent(Company $company, LandingPageComponent $component)
    {
        Gate::authorize('update', $company);

        $component->delete();

        return redirect()->route('company.edit', $company)
            ->with('success', __('company.success.landing_page_component_deleted'));
    }
}

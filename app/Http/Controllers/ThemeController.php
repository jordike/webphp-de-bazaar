<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class ThemeController extends Controller
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
    public function create(Company $company)
    {
        Gate::authorize('update', $company);

        return view('themes.create', [
            'company' => $company
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Company $company)
    {
        Gate::authorize('update', $company);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'primary_color' => 'required|string|size:7',
            'secondary_color' => 'required|string|size:7',
            'background_color' => 'required|string|size:7',
            'text_color' => 'required|string|size:7',
            'font_family' => 'required|string|max:255',
            'font_size' => 'required|integer|min:8|max:20',
            'logo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $logo = $request->file('logo_path');

        if ($request->hasFile('logo_path')) {
            $logoPath = $logo->storeAs('logos', Str::uuid() . '.' . $logo->getClientOriginalExtension(), 'local');
        }

        $theme = new Theme();
        $theme->fill([
            'name' => $request->input('name'),
            'company_id' => $company->id,
            'description' => $request->input('description'),
            'primary_color' => $request->input('primary_color'),
            'secondary_color' => $request->input('secondary_color'),
            'background_color' => $request->input('background_color'),
            'text_color' => $request->input('text_color'),
            'font_family' => $request->input('font_family'),
            'font_size' => $request->input('font_size'),
            'logo_path' => isset($logoPath) ? $logoPath : null,
        ]);
        $theme->save();

        return redirect()->route('company.edit', $company)
            ->with('success', __('theme.success_create'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company, Theme $theme)
    {
        Gate::authorize('update', $company);

        return view('themes.edit', [
            'theme' => $theme,
            'company' => $company,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company, Theme $theme)
    {
        Gate::authorize('update', $company);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'primary_color' => 'required|string|size:7',
            'secondary_color' => 'required|string|size:7',
            'background_color' => 'required|string|size:7',
            'text_color' => 'required|string|size:7',
            'font_family' => 'required|string|max:255',
            'font_size' => 'required|integer|min:8|max:20',
            'logo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $logo = $request->file('logo_path');

        if ($request->hasFile('logo_path')) {
            $logoPath = $logo->storeAs('logos', Str::uuid() . '.' . $logo->getClientOriginalExtension(), 'local');
        }

        $theme->fill([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'primary_color' => $request->input('primary_color'),
            'secondary_color' => $request->input('secondary_color'),
            'background_color' => $request->input('background_color'),
            'text_color' => $request->input('text_color'),
            'font_family' => $request->input('font_family'),
            'font_size' => $request->input('font_size'),
            'logo_path' => isset($logoPath) ? $logoPath : null,
        ]);
        $theme->save();

        return redirect()->route('company.edit', $company)
            ->with('success', __('theme.success_update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company, Theme $theme)
    {
        Gate::authorize('update', $company);

        $theme->delete();

        return redirect()->route('company.edit', $company)
            ->with('success', __('theme.success_delete'));
    }

    public function use(Company $company, ?Theme $theme = null)
    {
        Gate::authorize('update', $company);

        if ($theme == null) {
            $company->currentTheme()->dissociate();
        } else {
            $company->currentTheme()->associate($theme);
        }

        $company->save();

        return redirect()->route('company.edit', $company)
            ->with('success', __('theme.success_apply'));
    }

    public function unuse(Company $company, Theme $theme)
    {
        Gate::authorize('update', $company);

        $company->currentTheme()->dissociate($theme);
        $company->save();

        return redirect()->route('company.edit', $company)
            ->with('success', __('theme.success_unapply'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Theme;
use Illuminate\Http\Request;

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
        return view('themes.create', [
            'company' => $company
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Company $company)
    {
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

        $data = $request->except('logo_path');
        $data['company_id'] = $company->id;

        if ($request->hasFile('logo_path')) {
            $data['logo_path'] = $request->file('logo_path')->store('logos', 'public');
        }

        Theme::create($data);

        return redirect()->route('company.edit', $company)
            ->with('success', 'Theme created successfully!');
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
        return view('themes.edit', [
            'theme' => $theme,
            'company' => $company,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
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

        $theme = Theme::findOrFail($id);
        $data = $request->except('logo_path');

        if ($request->hasFile('logo_path')) {
            $data['logo_path'] = $request->file('logo_path')->store('logos', 'public');
        }

        $theme->update($data);

        return redirect()->route('company.edit', $theme->company)
            ->with('success', 'Theme updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company, Theme $theme)
    {
        $theme->delete();

        return redirect()->route('company.edit', $company)
            ->with('success', 'Theme deleted successfully!');
    }

    public function use(Company $company, Theme $theme)
    {
        $company->currentTheme()->associate($theme);
        $company->save();

        return redirect()->route('company.edit', $company)
            ->with('success', 'Theme applied successfully!');
    }
}

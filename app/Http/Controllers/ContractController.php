<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Spatie\LaravelPdf\Facades\Pdf;
use Illuminate\Support\Str;

class ContractController extends Controller
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
        Gate::authorize('create', $company);

        return view('contracts.create', [
            'company' => $company,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Company $company)
    {
        Gate::authorize('create', $company);

        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $company->contracts()->create([
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
        ]);

        return redirect()->route('companies.edit', $company->id)
            ->with('success', __('contracts.messages.success.created'));
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
    public function edit(Company $company, Contract $contract)
    {
        Gate::authorize('update', $contract);

        if ($contract->company_id !== $company->id) {
            return redirect()->route('companies.edit', $company->id)
                ->with('error', __('contracts.messages.error.not_belong'));
        }

        return view('contracts.edit', [
            'company' => $company,
            'contract' => $contract,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company, Contract $contract)
    {
        Gate::authorize('update', $contract);

        if ($contract->company_id !== $company->id) {
            return redirect()->route('companies.edit', $company->id)
                ->with('error', __('contracts.messages.error.not_belong'));
        }

        if ($contract->is_signed) {
            return redirect()->route('companies.edit', $company->id)
                ->with('error', __('contracts.messages.error.signed_update'));
        }

        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'contract_pdf' => 'nullable|file|mimes:pdf|max:2048',
            'signed' => 'nullable',
        ]);

        $pdf = $request->file('contract_pdf');

        if (isset($pdf)) {
            $pdfPath = $pdf->storeAs('contracts', Str::uuid() . '.' . $pdf->getClientOriginalExtension(), 'local');
        }

        $contract->start_date = $request->input('start_date');
        $contract->end_date = $request->input('end_date');
        $contract->is_signed = $request->boolean('signed');
        $contract->pdf_path = isset($pdfPath) ? $pdfPath : $contract->contract_pdf;
        $contract->save();

        return redirect()->route('companies.edit', $company->id)
            ->with('success', __('contracts.messages.success.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company, Contract $contract)
    {
        Gate::authorize('delete', $contract);

        if ($contract->company_id !== $company->id) {
            return redirect()->route('companies.edit', $company->id)
                ->with('error', __('contracts.messages.error.not_belong'));
        }

        if ($contract->is_signed) {
            return redirect()->route('companies.edit', $company->id)
                ->with('error', __('contracts.messages.error.signed_delete'));
        }

        $contract->delete();

        return redirect()->route('companies.edit', $company->id)
            ->with('success', __('contracts.messages.success.deleted'));
    }

    public function download(Company $company, Contract $contract)
    {
        Gate::authorize('download', $contract);

        if ($contract->company_id !== $company->id) {
            return redirect()->route('companies.edit', $company->id)
                ->with('error', __('contracts.messages.error.not_belong'));
        }

        File::ensureDirectoryExists(storage_path('app/contracts'), 0755, true);

        $uuid = Str::uuid();

        Pdf::view('contracts.pdf', [
            'company' => $company,
            'contract' => $contract,
        ])
            ->format('A4')
            ->save(storage_path('app/contracts/' . $uuid . '.pdf'));

        return response()->download(storage_path('app/contracts/' . $uuid . '.pdf'), 'contract.pdf')
            ->deleteFileAfterSend(true);
    }
}

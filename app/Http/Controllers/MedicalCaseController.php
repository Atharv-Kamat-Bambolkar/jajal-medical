<?php

namespace App\Http\Controllers;

use App\Models\MedicalCase;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MedicalCaseController extends Controller
{
    private function authorizeAdmin(): void
    {
        abort_unless(
            request()->user()?->role === 'Admin', 
            403,
            'Unauthorized action.'
        );
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cases = MedicalCase::query()
        ->when($request->filled('search'), function ($query) use ($request) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('case_number', 'like', "%{$search}%")
                ->orWhere('surgeon_name', 'like', "%{$search}%")
                ->orWhere('patient_reference', 'like', "%{$search}%");
            });
        })
        ->when($request->filled('status'), function ($query) use ($request) {
            $query->where('status', $request->status);
        })
        ->when($request->filled('priority'), function ($query) use ($request) {
            $query->where('priority', $request->priority);
        })
        ->latest()
        ->paginate(10)
        ->withQueryString();

        return view('cases.index', compact('cases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorizeAdmin();

        return view('cases.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'case_number' => ['required', 'string', 'max:255', 'unique:medical_cases,case_number'],
            'patient_reference' => ['required', 'string', 'max:255'],
            'surgeon_name' => ['required', 'string', 'max:255'],
            'implant_type' => ['required', 'string', 'max:255'],
            'status' => ['required', Rule::in(['Draft', 'Planning', 'In Review', 'Approved', 'Completed', 'Cancelled',]),],
            'priority' => ['required', Rule::in(['Low', 'Medium', 'High']),],
            'surgery_date' => ['nullable', 'date'],
        ]);

        $validated['created_by'] = $request->user()->id;

        MedicalCase::create($validated);

        return redirect()->route('cases.index')
        ->with('success', 'Medical case created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MedicalCase $case)
    {
        return view('cases.show', compact('case'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MedicalCase $case)
    {
        $this->authorizeAdmin();

        return view('cases.edit', compact('case'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MedicalCase $case)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'case_number' => [
                'required', 'string', 'max:255',
                Rule::unique('medical_cases', 'case_number')->ignore($case->id),
            ],
            'patient_reference' => ['required', 'string', 'max:255'],
            'surgeon_name' => ['required', 'string', 'max:255'],
            'implant_type' => ['required', 'string', 'max:255'],
            'status' => ['required', Rule::in(['Draft', 'Planning', 'In Review', 'Approved', 'Completed', 'Cancelled',]),],
            'priority' => ['required', Rule::in(['Low', 'Medium', 'High']),],
            'surgery_date' => ['nullable', 'date'],
        ]);

        $case->update($validated);

        return redirect()->route('cases.index')
        ->with('success', 'Medical case updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MedicalCase $case)
    {
        $this->authorizeAdmin();

        $case->delete();

        return redirect()->route('cases.index')
        ->with('success', 'Medical case deleted successfully.');
    }
}

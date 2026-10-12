<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MedicalCase;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MedicalCaseApiController extends Controller
{
    private function authorizeAdmin(Request $request): void
    {
        abort_unless($request->user()?->role === 'Admin', 
        403, 'Only Admin users can perform this action.');
    }

    public function index(Request $request)
    {
        $cases = MedicalCase::query()
        ->when($request->filled('search'), 
        function ($query) use ($request) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('case_number', 'like', "%{$search}%")
                ->orWhere('surgeon_name', 'like', "%{$search}%");
            });
        })->when($request->filled('status'), 
        function ($query) use ($request) {
            $query->where('status', $request->input('status'));
        })
        ->latest()->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Medical cases retrieved successfully.',
            'data' => $cases->items(),
            'pagination' => [
                'current_page' => $cases->currentPage(),
                'last_page' => $cases->lastPage(),
                'per_page' => $cases->perPage(),
                'total' => $cases->total(),
            ],
        ], 200);
    }

    public function store(Request $request) 
    {
        $this->authorizeAdmin($request);

        $validated = $request->validate([
            'case_number' => [
                'required', 'string', 'max:255',
                'unique:medical_cases,case_number',
            ],
            'patient_reference' => ['required', 'string', 'max:255'],
            'surgeon_name' => ['required', 'string', 'max:255'],
            'implant_type' => ['required', 'string', 'max:255'],
            'status' => [
                'required',
                Rule::in([
                    'Draft', 'Planning', 'In Review', 
                    'Approved', 'Completed', 'Cancelled',
                ]),
            ],
            'priority' => [
                'required',
                Rule::in(['Low', 'Medium', 'High']),
            ],
            'surgery_date' => ['nullable', 'date'],
        ]);

        $validated['created_by'] = $request->user()->id;

        $case = MedicalCase::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Medical case created successfully.',
            'data' => $case,
        ], 201);
    }

    public function show(string $id) 
    {
        $case = MedicalCase::find($id);

        if (! $case) {
            return response()->json([
                'success' => false,
                'message' => 'Medical case not found.',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Medical case retrieved successfully.',
            'data' => $case,
        ], 200);
    }

    public function update(Request $request, string $id) 
    {
        $this->authorizeAdmin($request);

        $case = MedicalCase::find($id);

        if (! $case) {
            return response()->json([
                'success' => false,
                'message' => 'Medical case not found.',
                'data' => null,
            ], 404);
        }

        $validated = $request->validate([
            'case_number' => [
                'required', 'string', 'max:255', 
                Rule::unique('medical_cases', 'case_number')
                ->ignore($case->id),
            ],
            'patient_reference' => ['required', 'string', 'max:255'],
            'surgeon_name' => ['required', 'string', 'max:255'],
            'implant_type' => ['required', 'string', 'max:255'],
            'status' => [
                'required', 
                Rule::in(['Draft', 'Planning', 'In Review', 
                'Approved', 'Completed', 'Cancelled',]),
            ],
            'priority' => [
                'required', 
                Rule::in(['Low', 'Medium', 'High']),
            ],
            'surgery_date' => ['nullable', 'date'],
        ]);

        $case->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Medical case updated successfully.',
            'data' => $case->fresh(),
        ], 200);
    }

    public function destroy(Request $request, string $id) 
    {
        $this->authorizeAdmin($request);

        $case = MedicalCase::find($id);

        if (! $case) {
            return response()->json([
                'success' => false,
                'message' => 'Medical case not found.',
                'data' => null,
            ], 404);
        }

        $case->delete();

        return response()->json([
            'success' => true,
            'message' => 'Medical case deleted successfully.',
            'data' => null,
        ], 200);
    }
}

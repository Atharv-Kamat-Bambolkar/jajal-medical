<div class="mb-3">
    <label class="form-label">Case Number</label>
    <input type="text" name="case_number" class="form-control" 
    value="{{ old('case_number', $case->case_number ?? "") }}" required>
    @error('case_number') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Patient Reference (dummy code)</label>
    <input type="text" name="patient_reference" class="form-control" 
    value="{{ old('patient_reference', $case->patient_reference ?? "") }}" required>
    @error('patient_reference') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Surgeon Name</label>
    <input type="text" name="surgeon_name" class="form-control" 
    value="{{ old('surgeon_name', $case->surgeon_name ?? "") }}" required>
    @error('surgeon_name') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Implant Type</label>
    <input type="text" name="implant_type" class="form-control" 
    value="{{ old('implant_type', $case->implant_type ?? "") }}" required>
    @error('implant_type') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Status</label>
    @php
        $statuses = [
            "Draft",
            "Planning",
            "In Review",
            "Approved",
            "Completed",
            "Cancelled"
        ];
    @endphp
    <select name="status" class="form-select" required>
        @foreach ($statuses as $status)
            <option value="{{ $status }}"
            {{ old('status', $case->status ?? 'Draft') === $status ? 'selected' : '' }}>
                {{ $status }}
            </option>        
        @endforeach
    </select>
    @error('status') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Priority</label>
    @php $priorities = ["Low", "Medium", "High"]; @endphp

    <select name="priority" class="form-select" required>
        @foreach ($priorities as $priority)
            <option value="{{ $priority }}"
            {{ old('priority', $case->priority ?? 'Medium') === $priority ? 'selected' : '' }}>
                {{ $priority }}
            </option>        
        @endforeach
    </select>
    @error('priority') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Surgery Date (optional)</label>
    <input type="date" name="surgery_date" class="form-control" 
    value="{{ old('surgery_date', isset($case) && $case->surgery_date ? 
    $case->surgery_date->format('Y-m-d') : '') }}">
    @error('surgery_date') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<button type="submit" class="btn btn-primary">{{ $buttonText }}</button>
<a href="{{ route('cases.index') }}" class="btn btn-secondary">Cancel</a>
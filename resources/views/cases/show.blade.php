@extends('layouts.app')

@section('content')

<div class="container py-4">
    <h2 class="mb-4">Medical Case Details</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <tr><th>Case Number</th><td>{{ $case->case_number }}</td></tr>
        <tr><th>Patient Reference</th><td>{{ $case->patient_reference }}</td></tr>
        <tr><th>Surgeon Name</th><td>{{ $case->surgeon_name }}</td></tr>
        <tr><th>Implant Type</th><td>{{ $case->implant_type }}</td></tr>
        <tr><th>Status</th><td>{{ $case->status }}</td></tr>
        <tr><th>Priority</th><td>{{ $case->priority }}</td></tr>
        <tr><th>Surgery Date</th><td>{{ $case->surgery_date ? $case->surgery_date->format('d M Y') : 'Not set' }}</td></tr>
        <tr><th>Created At</th><td>{{ $case->created_at ? $case->created_at->format('d M Y H:i') : 'Not Available' }}</td></tr>
        <tr><th>Updated At</th><td>{{ $case->created_at ? $case->updated_at->format('d M Y H:i') : 'Not Available' }}</td></tr>
        <tr><th>Created By</th><td>{{ $case->creator?->name ?? 'Unknown' }}</td></tr>
    </table>

    @if (auth()->user()->role === 'Admin')
        <a href="{{ url('/cases/' . $case->id . '/edit') }}" class="btn btn-warning">Edit</a>
    @endif

    <a href="{{ route('cases.index') }}" class="btn btn-secondary">Back</a>

</div>
@endsection
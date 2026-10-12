@extends('layouts.app')

@section('content')

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Medical Cases</h2>

        @if (auth()->user()->role === 'Admin')
            <a href="{{ route('cases.create') }}" class="btn btn-primary">
                + Create Case
            </a>
        @endif
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="get" action="{{ route('cases.index') }}" 
    class="card card-body mb-3">
        <div class="row g-2">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" 
                placeholder="Search case number or surgeon" 
                value="{{ request('search') }}">
            </div>

            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All statuses</option>
                    @foreach ( ['Draft', 'Planning', 'In Review', 
                    'Approved', 'Completed', 'Cancelled'] as $status )
                        <option value="{{ $status }}" 
                        @selected(request('status') === $status)>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <select name="priority" class="form-select">
                    <option value="">All priorities</option>
                    @foreach ( ['Low', 'Medium', 'High'] as $priority )
                        <option value="{{ $priority }}" 
                        @selected(request('priority') === $priority)>
                            {{ $priority }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <button class="btn btn-dark w-100">Search</button>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Case Number</th>
                    <th>Patient Reference</th>
                    <th>Surgeon</th>
                    <th>Implant Type</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($cases as $case)
                    <tr>
                        <td>{{ $case->case_number }}</td>
                        <td>{{ $case->patient_reference }}</td>
                        <td>{{ $case->surgeon_name }}</td>
                        <td>{{ $case->implant_type }}</td>
                        <td>{{ $case->status }}</td>
                        <td>{{ $case->priority }}</td>
                        <td class="text-nowrap">
                            <a href="{{ route('cases.show', ['case' => $case->id]) }}" 
                            class="btn btn-sm btn-info">View</a>

                            @if (auth()->user()->role === 'Admin')
                                <a href="{{ route('cases.edit', ['case' => $case->id]) }}" 
                                class="btn btn-sm btn-warning">Edit</a>

                                <form method="post" 
                                action="{{ route('cases.destroy', $case) }}" 
                                class="d-inline" 
                                onsubmit="return confirm('Delete this case?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No cases found.</td>
                        </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $cases->links() }}

</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container py-4">

    <h2 class="mb-4">Medical Case Dashboard</h2>

    <div class="row g-3">

        <div class="col-md-4">
            <div class="card shadow-sm border-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Cases</h5>
                    <h2>{{ $counts['total'] }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-warning">
                <div class="card-body">
                    <h5 class="card-title">Planning</h5>
                    <h2>{{ $counts['planning'] }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-info">
                <div class="card-body">
                    <h5 class="card-title">In Review</h5>
                    <h2>{{ $counts['in_review'] }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-success">
                <div class="card-body">
                    <h5 class="card-title">Approved</h5>
                    <h2>{{ $counts['approved'] }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-secondary">
                <div class="card-body">
                    <h5 class="card-title">Completed</h5>
                    <h2>{{ $counts['completed'] }}</h2>
                </div>
            </div>
        </div>

    </div>

    <div class="mt-4">
        <a href="{{ route('cases.index') }}" class="btn btn-primary">
            View All Medical Cases
        </a>
    </div>
    
</div>
@endsection

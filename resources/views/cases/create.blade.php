@extends('layouts.app')

@section('content')

<div class="container py-4">
    <h2 class="mb-4">Create Medical Case</h2>

    <form action="{{ route('cases.store') }}" method="post">
        @csrf
        @include('cases._form', ['buttonText' => 'Create Case'])
    </form>
    
</div>
@endsection
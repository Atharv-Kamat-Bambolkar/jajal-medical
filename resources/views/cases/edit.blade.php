@extends('layouts.app')

@section('content')

<div class="container py-4">
    <h2 class="mb-4">Edit Medical Case</h2>

    <form action="{{ url('/cases/' . $case->id) }}" method="post">
        @csrf
        @method('PUT')
        @include('cases._form', ['buttonText' => 'Save Changes'])
    </form>

</div>
@endsection
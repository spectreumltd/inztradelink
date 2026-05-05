@extends('backend_layouts.app')

@section('content')
<div class="container py-4">
    <h2>Supplier Profile</h2>

    <ul class="list-group">
        <li class="list-group-item"><strong>Name:</strong> {{ auth()->user()->name }}</li>
        <li class="list-group-item"><strong>Email:</strong> {{ auth()->user()->email }}</li>
        <li class="list-group-item"><strong>Phone:</strong> {{ auth()->user()->phone ?? '-' }}</li>
    </ul>

    <a class="btn btn-outline-primary mt-3" href="{{ route('supplier.dashboard') }}">Back to Dashboard</a>
</div>
@endsection

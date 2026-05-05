@extends('backend_layouts.app')

@section('content')
<div class="container py-4">
    <h2>Supplier Dashboard</h2>
    <p>Welcome, {{ auth()->user()->name }}.</p>

    <a class="btn btn-outline-primary" href="{{ route('supplier.profile') }}">View Profile</a>

    <form class="d-inline-block ms-2" method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-outline-danger">Logout</button>
    </form>
</div>
@endsection

@extends('backend_layouts.app')

@section('content')
<div class="container py-4">
    <h2>Admin Dashboard</h2>
    <p>Welcome admin, {{ auth()->user()->name }}.</p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-outline-danger">Logout</button>
    </form>
</div>
@endsection

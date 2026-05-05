@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Supplier Sign Up</h2>

    <form method="POST" action="{{ route('supplier-sign-up.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="first_name" class="form-label">First Name *</label>
            <input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" class="form-control @error('first_name') is-invalid @enderror" required>
            @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name *</label>
            <input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}" class="form-control @error('last_name') is-invalid @enderror" required>
            @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email *</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password *</label>
            <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password *</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="mobile" class="form-label">Mobile</label>
            <input id="mobile" type="text" name="mobile" value="{{ old('mobile') }}" class="form-control @error('mobile') is-invalid @enderror">
            @error('mobile') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input id="image" type="file" name="image" class="form-control @error('image') is-invalid @enderror">
            @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Create Supplier Account</button>
    </form>
</div>

@endsection


@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

<script>
    if ($("#supplier_form").length > 0)
    {
        $("#supplier_form").validate({
          rules: {
              first_name: {
                  required: true
              },
              last_name: {
                  required: true
              },
              email: {
                  required: true
              },
              password: {
                  required: true
              },
              password_confirmation: {
                  required: true
              },
          },
          messages: {
            first_name: 'Please Enter First Name.',
            last_name: 'Please Enter Last Name.',
            email: 'Please Enter Email.',
            password: 'Please Enter Password.',
            password_confirmation: 'Please Enter Confirm Password.',
            },
        });
    }
</script>
@endsection
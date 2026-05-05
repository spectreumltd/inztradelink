@extends('layouts.app')

@section('content')
<!-- <style>
    .supplier-page {
        background: #ffffff;
    }

    .supplier-hero {
        background: linear-gradient(90deg, #c90707 0%, #f31616 100%);
        color: #fff;
        padding: 40px 0;
        margin-bottom: 40px;
    }

    .supplier-hero h1 {
        margin: 0;
        font-size: 38px;
        font-weight: 700;
        letter-spacing: .3px;
    }

    .supplier-card {
        border: 0;
        border-radius: 12px;
        box-shadow: 0 8px 28px rgba(0, 0, 0, .08);
        margin-bottom: 40px;
    }

    .supplier-card .card-body {
        padding: 36px 34px;
    }

    .supplier-title {
        font-size: 34px;
        text-align: center;
        font-weight: 700;
        margin-bottom: 28px;
    }

    .supplier-form label {
        font-weight: 600;
        margin-bottom: 6px;
        color: #202020;
    }

    .supplier-form .required {
        color: #d31a1a;
    }

    .supplier-form .form-control {
        border-radius: 7px;
        border: 1px solid #c9ced6;
        min-height: 46px;
    }

    .supplier-form .form-control:focus {
        border-color: #f31616;
        box-shadow: 0 0 0 .2rem rgba(243, 22, 22, .15);
    }

    .upload-box {
        border: 1px dashed #d4d8de;
        border-radius: 10px;
        padding: 24px 20px;
        text-align: center;
        background: #fafbfd;
    }

    .upload-hint {
        margin-top: 10px;
        font-size: 13px;
        color: #70757f;
    }

    .btn-supplier {
        background: #f31616;
        border-color: #f31616;
        color: #fff;
        min-width: 180px;
        min-height: 46px;
        border-radius: 8px;
        font-weight: 600;
    }

    .btn-supplier:hover {
        background: #d70f0f;
        border-color: #d70f0f;
        color: #fff;
    }
</style>

<div class="supplier-page">
    <section class="supplier-hero">
        <div class="container">
            <h1>Supplier Sign Up</h1>
        </div>
    </section>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card supplier-card">
                    <div class="card-body">
                        <h2 class="supplier-title">Supplier Sign Up</h2>

                        <form class="supplier-form" action="{{ route('supplier-sign-up') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="first_name">First Name <span class="required">*</span></label>
                                    <input type="text" id="first_name" name="first_name" class="form-control" placeholder="Enter first name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="last_name">Last Name <span class="required">*</span></label>
                                    <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Enter last name" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email">Email <span class="required">*</span></label>
                                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter email address" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="password">Password <span class="required">*</span></label>
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter password" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation">Confirm Password <span class="required">*</span></label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirm password" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="mobile">Mobile <span class="required">*</span></label>
                                    <input type="text" id="mobile" name="mobile" class="form-control" placeholder="Enter mobile number" required>
                                </div>

                                <div class="col-12 mb-4">
                                    <label for="image">Image</label>
                                    <div class="upload-box">
                                        <input type="file" id="image" name="image" class="form-control">
                                        <p class="upload-hint mb-0">PNG/JPG recommended, max 5MB for best performance.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-supplier">Create Account</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->
Supplier Sign Up Page
@endsection

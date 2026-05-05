@php
    $flashMessage = Session::get('flash_message');
    $flashType = Session::get('flash_type'); // expected: success|error|danger

    $flashBootstrapType = $flashType === 'success'
        ? 'success'
        : (($flashType === 'danger' || $flashType === 'error') ? 'danger' : 'info');

    $flashIconClass = $flashBootstrapType === 'success'
        ? 'fa-solid fa-circle-check'
        : ($flashBootstrapType === 'danger'
            ? 'fa-solid fa-triangle-exclamation'
            : 'fa-solid fa-circle-info');
@endphp

<style>
    .admin-alert-stack { max-width: 820px; margin-left: auto; margin-right: auto; }
    .admin-alert-card {
        border-radius: 16px;
        border: 1px solid rgba(0,0,0,.06);
        box-shadow: 0 10px 30px rgba(0,0,0,.06);
        backdrop-filter: blur(10px);
        padding: 10px 14px;
    }
    .admin-alert-card .admin-alert-icon-badge {
        width: 34px;
        height: 34px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 auto;
    }
    .admin-alert-card.success {
        background: linear-gradient(90deg, rgba(34,197,94,.15), rgba(34,197,94,.03));
        border-left: 6px solid #22c55e;
    }
    .admin-alert-card.success .admin-alert-icon-badge { background: rgba(34,197,94,.14); color: #16a34a; }

    .admin-alert-card.danger {
        background: linear-gradient(90deg, rgba(220,53,69,.15), rgba(220,53,69,.03));
        border-left: 6px solid #dc3545;
    }
    .admin-alert-card.danger .admin-alert-icon-badge { background: rgba(220,53,69,.14); color: #dc3545; }

    .admin-alert-card.info {
        background: linear-gradient(90deg, rgba(14,165,233,.15), rgba(14,165,233,.03));
        border-left: 6px solid #0ea5e9;
    }
    .admin-alert-card.info .admin-alert-icon-badge { background: rgba(14,165,233,.14); color: #0284c7; }

    .admin-alert-text { font-size: 14px; }
</style>

@if (count($errors) > 0 || session()->has('success') || session()->has('error') || session()->has('flash_message'))
<div class="row mb-2">
    <div class="col-12 admin-alert-stack">
        @if (session()->has('success'))
        <div class="admin-alert-card success alert alert-success alert-dismissible fade show mb-2" role="alert">
            <div class="d-flex align-items-start gap-2">
                <div class="admin-alert-icon-badge">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div class="flex-grow-1 admin-alert-text">
                    {{ session('success') ?: 'Success message example' }}
                </div>
                <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        @endif
        @if (session()->has('error'))

        <div class="admin-alert-card danger alert alert-danger alert-dismissible fade show mb-2" role="alert">
            <div class="d-flex align-items-start gap-2">
                <div class="admin-alert-icon-badge">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div class="flex-grow-1 admin-alert-text">
                    {{ session('error') ?: 'Error message example' }}
                </div>
                <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        @endif
        @if (session()->has('flash_message'))

        <div class="admin-alert-card {{ $flashBootstrapType }} alert alert-{{ $flashBootstrapType }} alert-dismissible fade show mb-2" role="alert">
            <div class="d-flex align-items-start gap-2">
                <div class="admin-alert-icon-badge">
                    <i class="{{ $flashIconClass }}"></i>
                </div>
                <div class="flex-grow-1 admin-alert-text">
                    {{ $flashMessage ?: 'Info message example' }}
                </div>
                <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        @endif
        @if (count($errors) > 0)
        <div class="admin-alert-card danger alert alert-danger alert-dismissible fade show mb-2" role="alert">
            <div class="d-flex align-items-start gap-2">
                <div class="admin-alert-icon-badge">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div class="flex-grow-1 admin-alert-text">
                    <div class="fw-semibold mb-1">Please fix the following:</div>
                    <ul class="mb-0">
                        @forelse ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @empty
                            <li>Validation error example</li>
                        @endforelse
                    </ul>
                </div>
                <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        @endif
    </div>
</div>
@endif

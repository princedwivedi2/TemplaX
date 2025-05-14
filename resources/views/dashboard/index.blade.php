@extends('layouts.app-dashboard')

@section('title', 'Dashboard')

@section('content')
<!-- Welcome Section -->
<div class="mb-4">
    <h2 class="fw-bold">Welcome, {{ Auth::user()->name }}!</h2>
    <p class="text-muted">Manage your business cards with TemplaX</p>
</div>

<!-- Stats Section -->
<div class="row g-4 mb-4">
    <div class="col-md-6 col-lg-4">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body d-flex align-items-center">
                <div class="flex-shrink-0 me-3 bg-primary bg-opacity-10 p-3 rounded-circle">
                    <i class="bi bi-credit-card-2-front fs-3 text-primary"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-0">{{ $userCards ?? 0 }}</h3>
                    <p class="text-muted mb-0">My Cards</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Action Cards Section -->
<h4 class="fw-bold border-bottom pb-2 mb-4">Quick Actions</h4>
<div class="row g-4 mb-5">
    <div class="col-sm-12 col-md-6 col-lg-4">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                        <i class="bi bi-plus-circle fs-4 text-primary"></i>
                    </div>
                    <h5 class="card-title fw-bold mb-0">Create Business Card</h5>
                </div>
                <p class="card-text text-muted mb-4">Create a new business card with your information</p>
                <a href="{{route('cards.create')}}" class="btn btn-primary">Create Card</a>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-4">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-info bg-opacity-10 p-3 rounded-circle me-3">
                        <i class="bi bi-credit-card-2-front fs-4 text-info"></i>
                    </div>
                    <h5 class="card-title fw-bold mb-0">Manage My Cards</h5>
                </div>
                <p class="card-text text-muted mb-4">View and manage your existing business cards</p>
                <a href="{{ route('cards.index') }}" class="btn btn-outline-primary">View Cards</a>
            </div>
        </div>
    </div>
</div>




<script>
    document.addEventListener('DOMContentLoaded', function() {
        const testButton = document.getElementById('test-sweetalert');
        if (testButton) {
            testButton.addEventListener('click', function() {
                Swal.fire({
                    title: 'Success!',
                    text: 'Card created successfully!',
                    icon: 'success',
                    confirmButtonColor: '#0d6efd'
                });
            });
        }
    });
</script>
@endsection

@extends('layouts.app')

@section('content')
<section class="vh-100" style="background-color: #f8f9fa;">
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-lg-8 mb-4 mb-lg-0">
                <div class="card mb-3" style="border-radius: 1rem; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                    <div class="row g-0">
                        <!-- Sidebar Profil -->
                        <div class="col-md-4 gradient-custom text-center text-white" style="border-top-left-radius: 1rem; border-bottom-left-radius: 1rem;border-top-right-radius: 1rem; border-bottom-right-radius: 1rem; background: linear-gradient(to bottom, #6a11cb, #2575fc);">
                            <div class="my-5">
                                @if($user->photo)
                                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Profile Photo" class="img-fluid rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 100px; height: 100px; margin: 0 auto;">
                                        <i class="fas fa-user text-dark" style="font-size: 50px;"></i>
                                    </div>
                                @endif
                                <h5 class="mt-3">{{ $user->name }}</h5>
                                <p class="text-muted">Member since {{ $user->created_at->format('M Y') }}</p>
                                <a href="{{ route('account.editprofile') }}" class="btn btn-outline-light btn-sm">
                                    <i class="fas fa-edit me-2"></i>Edit Profile
                                </a>
                            </div>
                        </div>
                        <!-- Informasi Profil -->
                        <div class="col-md-8">
                            <div class="card-body p-4">
                                <h6 class="mb-4">Account Information</h6>
                                <hr class="mt-0 mb-4">
                                <div class="row pt-1">
                                    <div class="col-6 mb-3">
                                        <h6>Email</h6>
                                        <p class="text-muted">{{ $user->email }}</p>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <h6>Name</h6>
                                        <p class="text-muted">{{ $user->name }}</p>
                                    </div>
                                </div>
                                <!-- Tombol Logout -->
                                <div class="d-flex justify-content-end">
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
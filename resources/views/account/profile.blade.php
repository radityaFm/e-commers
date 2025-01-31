<!-- resources/views/profile/show.blade.php -->

@extends('layouts.app')

@section('content')
<section class="vh-100" style="background-color: #f4f5f7;">
    <div class="container py-5 h-100">
        <div class="d-flex justify-content-center align-items-center h-100">
            <div class="col col-lg-8 mb-4 mb-lg-0">
                <div class="card mb-3" style="border-radius: .5rem;">
                    <div class="row g-0">
                        <div class="col-md-4 gradient-custom text-center text-white" style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                            <img src="" alt="" class="img-fluid my-5" style="width: 80px;" />
                            <h5>{{ $user->name }}</h5>
                            <i class="far fa-edit mb-5"></i>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body p-4">
                                <h6>Information account user</h6>
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
                                <!-- Edit Button -->
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('account.editprofile') }}" class="btn btn-warning">Edit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

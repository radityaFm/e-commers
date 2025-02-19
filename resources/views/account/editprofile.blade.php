@extends('layouts.app')

@section('content')
<section class="vh-100" style="background-color: #f8f9fa;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-lg-8 mb-4 mb-lg-0">
                <div class="card mb-3" style="border-radius: 1rem; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                    <div class="row g-0">
                        <!-- Sidebar Profil -->
                        <div class="col-md-4 gradient-custom text-center text-white "  
                            style="border-top-left-radius: 1rem; border-bottom-left-radius: 1rem; background: linear-gradient(to bottom, #6a11cb, #2575fc); padding: 20px;">
                            <img src="{{ asset('storage/' . $user->photo) }}" 
                                alt="Profile Photo" 
                                class="img-fluid rounded-circle" 
                                style="width: 100px; height: 100px; object-fit: cover; margin-top:90px;">
                            <h5 class="mt-3">{{ $user->name }}</h5>
                            <p class="text-muted">Edit your profile</p>
                        </div>
                        <!-- Form Edit Profil -->
                        <div class="col-md-8">
                            <div class="card-body p-4">
                                <h6 class="mb-4">Edit Account Information</h6>
                                <hr class="mt-0 mb-4">
                                <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <!-- Email (read-only) -->
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" value="{{ $user->email }}" readonly>
                                    </div>

                                    <!-- Name (editable) -->
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                    </div>

                                    <!-- Upload Foto Profil -->
                                    <div class="mb-3 mt-3">
                                        <label for="photo" class="form-label">Profile Photo</label>
                                        <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                                        @if($user->photo)
                                           <b><small class="text-muted mt-3">Lihat foto : <a href="{{ asset('storage/' . $user->photo) }}" target="_blank" style="text-decoration:none;">Lihat</a></small><b>
                                        @endif
                                    </div>

                                    <!-- Tombol Simpan dan Batal -->
                                    <button type="submit" class="btn btn-success me-2">
                                        <i class="fas fa-save me-2"></i>Save Changes
                                    </button>
                                    <a href="{{ route('account.profile') }}" class="btn btn-secondary">
                                        <i class="fas fa-times me-2"></i>Cancel
                                    </a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Alert Script -->
@if(session('success'))
    <script>
        alert('{{ session('success') }}');
    </script>
@endif

@if($errors->any())
    <script>
        alert('{{ $errors->first() }}');
    </script>
@endif
@endsection
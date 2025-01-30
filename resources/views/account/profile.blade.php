@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card user-profile-card">
        <div class="card-body text-center">
            <img src="{{ $user->photo ? asset('storage/profile/' . $user->photo) : asset('default-profile.png') }}" alt="Profile Picture" class="profile-img">
            <h5 class="card-title">{{ $user->username }}</h5>
            <p class="card-text">{{ $user->email }}</p>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            {{-- Form Ganti Username --}}
            <form action="{{ route('profile.update.username') }}" method="POST">
                @csrf
                <input type="text" name="username" class="form-control mt-2" value="{{ $user->username }}" required>
                <button class="btn btn-primary btn-sm mt-2" type="submit">Update Username</button>
            </form>

            {{-- Form Ganti Password --}}
            <form action="{{ route('profile.update.password') }}" method="POST">
                @csrf
                <input type="password" name="current_password" class="form-control mt-2" placeholder="Password Lama" required>
                <input type="password" name="new_password" class="form-control mt-2" placeholder="Password Baru" required>
                <input type="password" name="new_password_confirmation" class="form-control mt-2" placeholder="Konfirmasi Password" required>
                <button class="btn btn-warning btn-sm mt-2" type="submit">Update Password</button>
            </form>

            {{-- Form Ganti Foto Profil --}}
            <form action="{{ route('profile.update.photo') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="photo" class="form-control mt-2" required>
                <button class="btn btn-info btn-sm mt-2" type="submit">Update Foto</button>
            </form>

            {{-- Tombol Hapus Akun --}}
            <form action="{{ route('profile.delete') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini secara permanen?');">
                @csrf
                <button class="btn btn-danger btn-sm mt-3" type="submit">Hapus Akun</button>
            </form>
        </div>
    </div>
</div>

<style>
.user-profile-card {
    max-width: 400px;
    margin: auto;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    padding: 20px;
    text-align: center;
}

.profile-img {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 10px;
}
</style>
@endsection

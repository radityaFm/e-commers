@extends('layouts.app')

@section('content')
<section class="vh-100" style="background-color: #f4f5f7;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-lg-6 mb-4 mb-lg-0">
                <div class="card mb-3" style="border-radius: .5rem;">
                    <div class="row g-0">
                        <div class="col-md-12 gradient-custom text-center text-white" style="border-radius: .5rem;">
                            <img src="" alt="" class="img-fluid my-5" style="width: 100px;" />
                            <h5>{{ $user->name }}</h5>
                        </div>
                        <div class="col-md-12">
                            <div class="card-body p-4">
                                <h6>Edit Information account user</h6>
                                <hr class="mt-0 mb-4">
                                <form action="{{ route('profil.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <!-- Email (hanya bisa dilihat, tidak bisa diubah) -->
                                    <div class="col-12 mb-3">
                                        <h6>Email</h6>
                                        <p class="form-control-plaintext">{{ $user->email }}</p>
                                    </div>

                                    <!-- Name (editable, input field) -->
                                    <div class="col-12 mb-3">
                                        <h6>Name</h6>
                                        <input class="form-control" type="text" name="name" value="{{ old('name', $user->name) }}" required>
                                    </div>

                                    <button class="btn btn-success" type="submit">Save Changes</button>
                                    <a href="{{ route('account.profile') }}" class="btn btn-secondary">Cancel</a>
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

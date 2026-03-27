@extends('layouts.app')

@section('content')
<div class="row justify-content-center mt-3 mt-md-5">
    <div class="col-12 col-md-8 col-lg-6">
        <h2 class="fw-bold text-gray-800 mb-4 ps-2 ps-md-0 fs-3">Profil Saya</h2>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="card border-0 shadow-sm rounded-4 mb-5 mx-auto" style="max-width: 600px;">
            <div class="card-body p-4">
                <form action="{{ route('user.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                        <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3">
                            <i class="fas fa-user-circle fs-5 text-primary"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0 text-primary">Informasi Akun</h6>
                            <small class="text-muted" style="font-size: 0.8rem;">Perbarui detail personal Anda di sini</small>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="name" class="form-label text-muted fw-bold small">Nama Lengkap</label>
                        <input type="text" class="form-control rounded-3" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    </div>

                    <div class="mb-5">
                        <label for="email" class="form-label text-muted fw-bold small">Alamat Email</label>
                        <input type="email" class="form-control rounded-3" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="d-flex align-items-center mb-4 pb-3 border-bottom mt-5">
                        <div class="bg-warning bg-opacity-10 p-2 rounded-circle me-3">
                            <i class="fas fa-key fs-5 text-warning"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0 text-warning">Ubah Password</h6>
                            <small class="text-muted" style="font-size: 0.8rem;">Biarkan kosong jika Anda tidak ingin mengubah password.</small>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="current_password" class="form-label text-muted fw-bold small">Password Saat Ini</label>
                        <input type="password" class="form-control rounded-3" id="current_password" name="current_password" placeholder="Masukkan password lama">
                    </div>

                    <div class="row g-3">
                        <div class="col-12 col-md-6 mb-3">
                            <label for="password" class="form-label text-muted fw-bold small">Password Baru</label>
                            <input type="password" class="form-control rounded-3" id="password" name="password" minlength="6" placeholder="Minimal 6 karakter">
                        </div>
                        <div class="col-12 col-md-6 mb-4">
                            <label for="password_confirmation" class="form-label text-muted fw-bold small">Konfirmasi Password</label>
                            <input type="password" class="form-control rounded-3" id="password_confirmation" name="password_confirmation" placeholder="Ketik ulang password">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4 pt-4 border-top">
                        <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill fw-bold shadow-sm">
                            <i class="fas fa-save me-2"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@push('styles')
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Inter', sans-serif;
        }

        .login-container {
            min-height: calc(100vh - 56px);
            /* Adjusting for navbar if present */
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .login-card {
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            border: none;
        }

        .login-header {
            background: linear-gradient(135deg, #7c3aed 0%, #a78bfa 100%);
            color: white;
            padding: 3rem 2rem;
            text-align: center;
        }

        .login-header h2 {
            font-weight: 700;
            letter-spacing: 1px;
        }

        .login-body {
            padding: 3rem 2.5rem;
        }

        .form-control {
            padding: 0.8rem 1rem;
            border-radius: 10px;
            border: 1px solid #e3e6f0;
        }

        .form-control:focus {
            border-color: #7c3aed;
            box-shadow: 0 0 0 0.2rem rgba(124, 58, 237, 0.25);
        }

        .input-group-text {
            background-color: #f8f9fc;
            border: 1px solid #e3e6f0;
            border-right: none;
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
            color: #b7b9cc;
        }

        .input-group .form-control {
            border-left: none;
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }

        .btn-login {
            border-radius: 10px;
            padding: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            background-color: #7c3aed;
            border-color: #7c3aed;
            transition: all 0.3s;
        }

        .btn-login:hover {
            background-color: #6d28d9;
            border-color: #6d28d9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(124, 58, 237, 0.4);
        }

        @media (max-width: 576px) {
            .login-body {
                padding: 2rem 1.5rem;
            }

            .login-header {
                padding: 2rem 1rem;
            }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
@endpush

@section('content')
    <div class="login-container">
        <div class="row w-100 justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card login-card">
                    <div class="login-header">
                        <i class="fas fa-file-signature fa-3x mb-3 text-white-50"></i>
                        <h2>SIP-PB</h2>
                        <p class="mb-0 text-white-50">Sistem Informasi Peraturan Putra Batam</p>
                    </div>

                    <div class="login-body bg-white">
                        <h5 class="text-center mb-4 text-gray-800 fw-bold">Selamat Datang kembali!</h5>

                        <form id="loginForm" action="{{ route('login.post') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="email" class="form-label text-muted small fw-bold text-uppercase">Email
                                    Address</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" name="email" class="form-control" id="email" required
                                        autofocus placeholder="Masukkan email anda...">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="password"
                                    class="form-label text-muted small fw-bold text-uppercase">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" name="password" class="form-control" id="password" required
                                        placeholder="Masukkan password...">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="captcha"
                                    class="form-label text-muted small fw-bold text-uppercase">Captcha</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-primary fw-bold"
                                        style="font-size: 1.1rem; letter-spacing: 2px; width: 80px; justify-content: center;">{{ $num1 }}
                                        + {{ $num2 }}</span>
                                    <input type="number" name="captcha" class="form-control" id="captcha" required
                                        placeholder="Jawab soal di samping..." autocomplete="off">
                                </div>
                            </div>

                            <div class="d-grid mt-5">
                                <button type="submit" class="btn btn-primary btn-login" id="btnLogin">
                                    Login Sekarang <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Styling focus states for input groups
            $('.form-control').on('focus', function() {
                $(this).parent().find('.input-group-text').css('border-color', '#7c3aed');
                $(this).parent().find('.input-group-text').css('color', '#7c3aed');
            }).on('blur', function() {
                $(this).parent().find('.input-group-text').css('border-color', '#e3e6f0');
                $(this).parent().find('.input-group-text').css('color', '#b7b9cc');
            });

            $('#loginForm').on('submit', function() {
                $('#btnLogin').html('<i class="fas fa-spinner fa-spin me-2"></i> Sedang Memuat...').prop(
                    'disabled', true);
            });
        });
    </script>
@endpush

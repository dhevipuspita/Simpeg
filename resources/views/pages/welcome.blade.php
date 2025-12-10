<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Kepegawaian</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="{{ url('assets/img/logo-pondok.jpg') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.4), transparent);
            top: -200px;
            left: -200px;
            border-radius: 50%;
            animation: float 8s ease-in-out infinite;
        }

        body::after {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(240, 147, 251, 0.3), transparent);
            bottom: -150px;
            right: -150px;
            border-radius: 50%;
            animation: float 10s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(30px, 30px); }
        }

        .auth-wrapper {
            width: 100%;
            max-width: 960px;
            padding: 20px;
            position: relative;
            z-index: 1;
        }

        .auth-card {
            display: grid;
            grid-template-columns: 1fr 1fr;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 
                0 25px 50px rgba(102, 126, 234, 0.3),
                0 10px 25px rgba(118, 75, 162, 0.2);
            backdrop-filter: blur(10px);
        }

        .auth-left {
            padding: 48px 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 24px;
            position: relative;
        }

        .auth-left::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="20" height="20" patternUnits="userSpaceOnUse"><path d="M 20 0 L 0 0 0 20" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
        }

        .auth-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #ffffff;
            width: fit-content;
            position: relative;
            z-index: 1;
        }

        .auth-badge i {
            font-size: 8px;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .auth-left h1 {
            font-size: 32px;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.3;
            position: relative;
            z-index: 1;
        }

        .auth-left p {
            font-size: 15px;
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.6;
            position: relative;
            z-index: 1;
        }

        .auth-logo {
            margin-top: 30px;
            display: flex;
            align-items: center;
            gap: 16px;
            position: relative;
            z-index: 1;
        }

        .auth-logo img {
            height: 70px;
            width: 70px;
            border-radius: 16px;
            object-fit: cover;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            border: 3px solid rgba(255, 255, 255, 0.3);
        }

        .auth-logo-text {
            font-size: 14px;
            color: #ffffff;
            line-height: 1.5;
        }

        .auth-logo-text strong {
            font-size: 18px;
            display: block;
            margin-bottom: 4px;
        }

        .auth-meta {
            margin-top: auto;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.7);
            position: relative;
            z-index: 1;
        }

        .auth-right {
            padding: 48px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #ffffff;
        }

        .auth-right-header {
            margin-bottom: 32px;
        }

        .auth-right-header h2 {
            font-size: 28px;
            margin-bottom: 8px;
            color: #1e293b;
            font-weight: 700;
        }

        .auth-right-header span {
            font-size: 14px;
            color: #64748b;
        }

        form.auth-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group label {
            font-size: 14px;
            color: #334155;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-group label i {
            font-size: 14px;
            color: #667eea;
        }

        .form-control {
            padding: 14px 16px;
            border-radius: 12px;
            border: 2px solid #e2e8f0;
            background: #f8fafc;
            color: #1e293b;
            font-size: 15px;
            outline: none;
            transition: all 0.2s ease;
        }

        .form-control::placeholder {
            color: #94a3b8;
        }

        .form-control:focus {
            border-color: #667eea;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .form-extra {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
            margin-top: -8px;
        }

        .remember-me {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #64748b;
            cursor: pointer;
            transition: color 0.2s;
        }

        .remember-me:hover {
            color: #334155;
        }

        .remember-me input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #667eea;
            cursor: pointer;
        }

        #passwordButton {
            border: none;
            background: transparent;
            color: #667eea;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            transition: color 0.2s;
        }

        #passwordButton:hover {
            color: #764ba2;
        }

        .btn-submit {
            margin-top: 8px;
            padding: 14px 24px;
            border-radius: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: #ffffff;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
            transition: all 0.2s ease;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(102, 126, 234, 0.4);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-submit i {
            font-size: 16px;
        }

        .auth-footer {
            margin-top: 24px;
            font-size: 12px;
            color: #94a3b8;
            text-align: center;
            padding-top: 24px;
            border-top: 1px solid #e2e8f0;
        }

        @media (max-width: 768px) {
            .auth-card {
                grid-template-columns: 1fr;
            }

            .auth-left {
                padding: 32px 24px;
            }

            .auth-left h1 {
                font-size: 24px;
            }

            .auth-right {
                padding: 32px 24px;
            }

            .auth-right-header h2 {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-left">
                <div class="auth-badge">
                    <i class="fa-solid fa-circle"></i> SIMPEG
                </div>

                <h1>Sistem Informasi Kepegawaian<br>Lembaga Pendidikan Islam Al-Azhaar</h1>

                <div class="auth-logo">
                    <img src="{{ url('assets/img/logo-pondok.jpg') }}" alt="Logo Pondok">
                    <div class="auth-logo-text">
                        <strong>Al-Azhaar</strong>
                        Aplikasi Kepegawaian 
                    </div>
                </div>

                <div class="auth-meta">
                    &copy; {{ date('Y') }} Lembaga Pendidikan Islam Al-Azhaar. All rights reserved.
                </div>
            </div>

            <div class="auth-right">
                <div class="auth-right-header">
                    <h2>Masuk ke Akun</h2>
                    <span>Gunakan username dan password yang telah terdaftar</span>
                </div>

                <form method="POST" action="{{ route('login') }}" class="auth-form">
                    @csrf

                    <div class="form-group">
                        <label for="username">
                            <i class="fa-regular fa-user"></i> Username
                        </label>
                        <input id="username" type="text" name="username" class="form-control"
                               placeholder="Masukkan username"
                               value="{{ old('username') }}">
                    </div>

                    <div class="form-group">
                        <label for="password">
                            <i class="fa-solid fa-lock"></i> Password
                        </label>
                        <input id="password" type="password" name="password" class="form-control"
                               placeholder="Masukkan password">
                    </div>

                    <div class="form-extra">
                        <label class="remember-me">
                            <input type="checkbox" name="remember">
                            <span>Ingat saya</span>
                        </label>
                        <button type="button" id="passwordButton">
                            Lupa password?
                        </button>
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="fa-solid fa-right-to-bracket"></i>
                        <span>Sign In</span>
                    </button>

                    <div class="auth-footer">
                        Hubungi admin jika mengalami kendala saat login.
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).on("click", "#passwordButton", function() {
            Swal.fire({
                title: "Masukkan username anda yang terdaftar",
                input: "text",
                inputAttributes: {
                    autocapitalize: "off"
                },
                showCancelButton: true,
                confirmButtonText: "Ajukan",
                cancelButtonText: "Batal",
                confirmButtonColor: '#667eea',
                showLoaderOnConfirm: true,
                preConfirm: (username) => {
                    if (!username) {
                        Swal.showValidationMessage("Username tidak boleh kosong");
                    }
                    return username;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/changePassword/" + result.value,
                        type: 'PUT',
                        data: {
                            _token: $("input[name=_token]").val(),
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                confirmButtonColor: '#667eea'
                            })
                        },
                        error: function(err) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: err.responseJSON?.message ?? 'Terjadi kesalahan',
                                confirmButtonColor: '#667eea'
                            })
                        }
                    });
                }
            });
        })
    </script>

    {{-- VALIDATION & SESSION ALERTS --}}
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '{{ $error }}',
                    confirmButtonColor: '#667eea'
                })
            </script>
        @endforeach
    @endif

    @if (session('auth.success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('auth.success') }}',
                confirmButtonColor: '#667eea'
            })
        </script>
    @endif

    @if (session('auth.error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('auth.error') }}',
                confirmButtonColor: '#667eea'
            })
        </script>
    @endif
</body>

</html>
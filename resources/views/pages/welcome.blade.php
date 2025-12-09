<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ url('assets/css/style.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ url('assets/img/logo-pondok.jpg') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Aplikasi Absensi Digital</title>
</head>

<body>

    <div class="container" id="container">
        <div class="form-container sign-in">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <h1>Sign In</h1>
                <span style="margin: 20px 0px 20px 0px">gunakan username dan password yang terdaftar</span>
                <input type="text" placeholder="Username" name="username">
                <input type="password" placeholder="Password" name="password">
                <a role="button" id="passwordButton" type="button" style="cursor: pointer;">Forget Your Password?</a>
                <button type="submit">Sign In</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-right">
                    <h1>Sistem Informasi Kepegawaian</h1>
                    <div class="d-block">
                        <img src="{{ url('assets/img/logo-pondok.jpg') }}" alt="Logo Pondok"
                            style="margin: 10px 0px 10px 0px; max-height:100px">
                    </div>
                    <p> Untuk Aplikasi Sistem Informasi Kepegawaian Lembaga Pendidikan Islam Al-Azhaar</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
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
                showLoaderOnConfirm: true,
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
                                title: 'Success...',
                                text: response.message,
                            })
                        },
                        error: function(err) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: err.responseJSON.message,
                            })
                        }
                    });
                }
            });
        })
    </script>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '{{ $error }}',
                })
            </script>
        @endforeach
    @endif
    @if (session('auth.success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success...',
                text: '{{ session('auth.success') }}',
            })
        </script>
    @endif
    @if (session('auth.error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('auth.error') }}',
            })
        </script>
    @endif
</body>

</html>

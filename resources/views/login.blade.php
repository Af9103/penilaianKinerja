<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIPEKA</title>
    <link rel="icon" href="../img/mwt.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #218838, #7dd67d);
            font-family: 'Poppins', sans-serif;
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-card {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 450px;
            text-align: center;
        }

        .login-card img {
            width: 120px;
            margin-bottom: 15px;
        }

        .form-control {
            border-radius: 20px;
        }

        .btn-login {
            width: 100%;
            border-radius: 20px;
            background: #28a745;
            border: 2px solid #28a745;
            color: #fff;
            padding: 10px;
            font-size: 16px;
            transition: 0.3s;
        }

        .btn-login:hover {
            background: #fff;
            color: #28a745;
            border: 2px solid #28a745;
        }

        .password-toggle {
            cursor: pointer;
        }

        .marquee-container {
    width: 100%;
    overflow: hidden;
    position: relative;
    height: 30px; /* Sesuaikan dengan tinggi teks */
}

.marquee-text {
    position: absolute;
    white-space: nowrap;
    font-weight: bold;
    font-size: large;
    text-align: center;
    animation: marquee 12s linear infinite;
    transform: translateX(0); /* Langsung muncul tanpa delay */
}

@keyframes marquee {
    0% {
        transform: translateX(60%);
    }
    100% {
        transform: translateX(-100%);
    }
}

    .custom-link {
        text-decoration: none;
        color: #28a745;
        font-size: 0.875rem;
    }

    .custom-link:hover {
        text-decoration: underline;
    }

    .row.text-center.mt-2 {
        position: relative;
        margin-bottom: -16px;
    }

    .row.text-center.mt-2::before {
        content: "|";
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #28a745;
        font-weight: bold;
    }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-card">
            {{-- <img src="../img/mwt.png" alt="SILASI Logo"> --}}
            <h4><div class="marquee-container">
                <div class="marquee-text">Selamat Datang di Sistem Informasi Penilaian Kinerja (SI PEKA)</div>
            </div></h4>

            @if(session('loginError'))
            <div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 1050;">
                <div id="loginToast" class="toast border-0 shadow-lg fade" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong class="me-auto">Gagal Login!</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body text-start">
                        {{ session('loginError') }}
                    </div>
                </div>
            </div>
            @endif

            <form action="/login" method="post">
                @csrf
                <div class="mb-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                        <input type="text" class="form-control @error('nip') is-invalid @enderror" name="nip" placeholder="Nomor Induk Pegawai" value="{{ old('nip') }}">
                        @error('nip')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Password">
                        <span class="input-group-text password-toggle" onclick="togglePassword()">
                            <i class="bi bi-eye-fill" id="toggle-icon"></i>
                        </span>
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                
                <button type="submit" class="btn btn-login">Login</button>
                {{-- <div class="row text-center mt-2">
                    <div class="col-6">
                        <a href="view" class="custom-link d-block">Lihat Riwayat Laporan</a>
                    </div>
                    <div class="col-6">
                        <a href="/produktivitas" class="custom-link d-block">Lihat Produktivitas Part</a>
                    </div>
                </div>                 --}}
                
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        function togglePassword() {
            const passwordInput = document.getElementById("password");
            const toggleIcon = document.getElementById("toggle-icon");
            
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.remove("bi-eye-fill");
                toggleIcon.classList.add("bi-eye-slash-fill");
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.remove("bi-eye-slash-fill");
                toggleIcon.classList.add("bi-eye-fill");
            }
        }
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var toastElement = document.getElementById('loginToast');
        if (toastElement) {
            var toast = new bootstrap.Toast(toastElement, { delay: 5000 }); // Tampil selama 5 detik
            toast.show();
        }
    });
</script>


</body>

</html>
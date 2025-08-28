<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>SI PEKA - Sistem Informasi Penilaian Kinerja</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/logo.png" rel="icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- Bootstrap -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

  <style>
    body,
    html {
      height: 100%;
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #f8f9fa;
    }

    .bg-image {
      background-image: url('img/office-bg.jpg'); /* ganti sesuai gambar latar */
      height: 100%;
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
      position: relative;
    }

    .overlay {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(135deg, rgba(0, 128, 0, 0.7), rgba(0, 0, 0, 0.7));
      z-index: 1;
    }

    .content {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      text-align: center;
      color: white;
      z-index: 2;
      padding: 20px;
      animation: fadeInUp 1.2s ease-out;
    }

    .content h1 {
      font-size: 3.2rem;
      font-weight: 700;
      margin-bottom: 15px;
      animation: zoomIn 1.5s ease-out;
    }

    .content h2 {
      font-size: 1.5rem;
      font-weight: 400;
      margin-bottom: 40px;
      opacity: 0.9;
    }

    .btn-login {
      padding: 12px 25px;
      font-size: 1.3rem;
      border-radius: 50px;
      transition: all 0.3s ease;
      background: #28a745;
      border: none;
      color: #fff;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
    }

    .btn-login:hover {
      background-color: #fff;
      color: #28a745;
      transform: scale(1.07);
    }

    .logo-container {
      position: absolute;
      top: 30px;
      left: 50%;
      transform: translateX(-50%); /* posisi tetap di tengah */
      display: flex;
      align-items: center;
      z-index: 3;
    }

    /* Animasi zoom hanya ke span */
    .logo-container span {
      color: white;
      font-size: 4rem;
      font-weight: bold;
      display: inline-block; /* perlu agar transform bekerja */
      animation: zoomIn 1.2s ease-out;
    }

    .logo-container img.logo {
      width: 80px;
      margin-right: 15px;
    }

    .logo-container span {
      color: white;
      font-size: 4rem;
      font-weight: bold;
    }

    .footer {
      color: white;
      text-align: center;
      padding: 15px 0;
      position: absolute;
      bottom: 0;
      width: 100%;
      z-index: 3;
      font-size: 0.9rem;
      opacity: 0.9;
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translate(-50%, -40%);
      }

      to {
        opacity: 1;
        transform: translate(-50%, -50%);
      }
    }

    @keyframes zoomIn {
      from {
        transform: scale(0.7);
        opacity: 0;
      }

      to {
        transform: scale(1);
        opacity: 1;
      }
    }

  @keyframes zoomIn {
    from {
      transform: scale(0.5); /* mulai kecil */
      opacity: 0;
    }
    to {
      transform: scale(1);   /* ukuran normal */
      opacity: 1;
    }
  }
  </style>
</head>

<body>
  <div class="bg-image"></div>
  <div class="overlay"></div>

  <!-- Logo -->
  <div class="logo-container">

    <span>SI PEKA</span>
  </div>

  <!-- Content -->
  <div class="content container">
  <div class="row align-items-center">
    
    <!-- Kolom kiri (teks) -->
    <div class="col-md-6 text-center text-md-start mb-4 mb-md-0">
      <h1>Selamat Datang</h1>
      <h2>Sistem Informasi Penilaian Kinerja (SI PEKA)</h2>
      <a href="login" class="btn btn-login">Masuk ke Sistem</a>
    </div>

    <!-- Kolom kanan (gambar) -->
    <div class="col-md-6 text-center">
      <img src="assets/img/okeee.png" alt="Gambar SI PEKA">
    </div>

  </div>
</div>


  <!-- Footer -->
  <div class="footer">
    <p>&copy; 2025  All rights reserved.</p>
  </div>
</body>

</html>

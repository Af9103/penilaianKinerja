<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>{{ $tittle }}</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicons -->
    <link href="assets/img/logo.png" rel="icon">
    <link href="assets/img/logo.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="/assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="/assets/vendor/simple-datatables/style.css" rel="stylesheet">
    <link href="/assets/DataTables-2.0.1/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="/assets/slim-select/selectize.bootstrap5.min.css" rel="stylesheet">
    <link href="/assets/jQuery/jquery-ui-1.13.2.custom/jquery-ui.css" rel="stylesheet">
    <link href="/assets/select2/css/select2.min.css" rel="stylesheet">
    <link href="/assets/select2/css/select2-bootstrap4.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="/assets/css/style.css" rel="stylesheet">

    <link href="/style.css" rel="stylesheet">
    

    <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Nov 17 2023 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

@include('layout.header')

    </header><!-- End Header -->

    <main id="main" class="main">
        @yield("isi")
    </main>
    
        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
                class="bi bi-arrow-up-short"></i></a>
    
        <!-- Vendor JS Files -->

        <script src="/assets/vendor/apexcharts/apexcharts.min.js"></script>
        <script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="/assets/vendor/chart.js/chart.umd.js"></script>
        <script src="/assets/vendor/echarts/echarts.min.js"></script>
        <script src="/assets/vendor/quill/quill.min.js"></script>
        <script src="/assets/vendor/simple-datatables/simple-datatables.js"></script>
        <script src="/assets/vendor/tinymce/tinymce.min.js"></script>
        <script src="/assets/vendor/php-email-form/validate.js"></script>
        <script src="/assets/jQuery/jquery-3.6.0.min.js"></script>
        <script src="/assets/DataTables/js/datatables.min.js"></script>
        <script src="/assets/sweetalert3/package/dist/sweetalert2.all.min.js"></script>
        <script src="/assets/select2/js/select2.full.min.js"></script>
    
        <script src="/assets/bootstrap-4.5.3-dist/js/bootstrap.min.js"></script>
        <script src="/assets/DataTables-2.0.1/js/dataTables.bootstrap4.min.js"></script>
        <script src="/assets/jQuery/jquery-ui-1.13.2.custom/jquery-ui.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
        
        

            <!-- Template Main JS File -->
    <script src="/assets/js/main.js"></script>

    <script src="/assets/slim-select/selectize.min.js"></script>
    
    
        <!-- Template Main JS File -->
        <script src="/assets/js/main.js"></script>
        @yield('scripts')
    
        <footer id="footer" class="footer">
            @include('layout.footer')
        </footer><!-- End Footer -->
        

        <script>
            function updateTime() {
                var currentTime = new Date();
                var hours = currentTime.getHours();
                var minutes = currentTime.getMinutes();
    
                // Menambahkan leading zero jika angka kurang dari 10
                hours = (hours < 10 ? "0" : "") + hours;
                minutes = (minutes < 10 ? "0" : "") + minutes;
    
                var formattedTime = hours + ":" + minutes;
    
                document.getElementById("current-time").innerText = formattedTime;
            }
    
            // Memanggil updateTime setiap detik
            setInterval(updateTime, 1000);
    
            // Panggil updateTime setelah halaman dimuat
            updateTime();
            
        </script>


 
    </body>
    
    </html>
    

    <style>
        .custom-nav {
            margin-left: 10px;
            /* Adjust this value to move the navbar right or left */
            margin-right: 10px;
            /* Adjust this value to move the navbar left or right */
        }
    
        .logo span {
            margin-left: 30px;
        }
    
        .nav-link.active {
            color: green !important;
            /* Ensures the color overrides default styles */
        }

        /* Show dropdown on hover */
            /* .nav-item.dropdown:hover .dropdown-menu {
                display: block;
            } */

            /* Optional: Delay the dropdown showing for a smoother experience */
            .nav-item.dropdown {
                position: relative;
            }

            .dropdown-menu {
                display: none;
                position: absolute;
                top: 100%;
                left: 10;
                z-index: 1000;
            }

            .nav-item .dropdown-menu .dropdown-item:hover {
        background-color: #218838; /* Darker green background on hover */
        color: white; /* Change text color to white on hover */
    }

    .nav-item .dropdown-menu .dropdown-item.active {
        background-color: #218838; /* Darker green background for the active item */
        color: white; /* White text color for active item */
    }

    </style>
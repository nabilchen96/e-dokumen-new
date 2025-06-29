<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>PANDU Pengelolaan Kepegawaian Terpadu</title>

    <!-- Favicon -->
    <link href="{{ url('ilanding/assets/img/pandu2.png') }}" rel="icon">
    <link href="{{ url('ilanding/assets/img/pandu2.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to bottom right, #fbe9e9, #f7dada);
        }

        .hero {
            padding: 80px 0;
        }

        .hero h1 {
            font-size: 2.8rem;
            font-weight: 700;
            color: #333;
        }

        .hero h1 span {
            color: #d11a1a;
        }

        .hero p {
            font-size: 1.1rem;
            color: #444;
        }

        .hero-buttons .btn-danger {
            padding: 10px 30px;
        }

        .logo-kabupaten {
            max-height: 400px;
            margin-bottom: 20px;
        }

        .logo-pandu {
            max-height: 80px;
        }

        .logo1 {
            max-height: 120px;
            margin-bottom: 10px;
        }

        .logo2 {
            max-height: 45px;
            margin-bottom: 10px;
        }

        .logo3 {
            max-height: 40px;
            margin-bottom: 10px;
        }
    </style>
</head>
@php
$s3 = DB::table('pegawai_imports')
->where('tingkat_pendidikan', 'S-3/Doktor')
->where('status_input', 'Import')
->count();

$s2 = DB::table('pegawai_imports')
->where('tingkat_pendidikan', 'S-2')
->where('status_input', 'Import')
->count();

$s1 = DB::table('pegawai_imports')
->where('tingkat_pendidikan', 'S-1/Sarjana')
->where('status_input', 'Import')
->count();


$d1 = DB::table('pegawai_imports')
->where('tingkat_pendidikan', 'Diploma I')
->where('status_input', 'Import')
->count();

$d2 = DB::table('pegawai_imports')
->where('tingkat_pendidikan', 'Diploma II')
->where('status_input', 'Import')
->count();

$d3 = DB::table('pegawai_imports')
->where('tingkat_pendidikan', 'Diploma III/Sarjana Muda')
->where('status_input', 'Import')
->count();

$d4 = DB::table('pegawai_imports')
->where('tingkat_pendidikan', 'Diploma IV')
->where('status_input', 'Import')
->count();

$sma = DB::table('pegawai_imports')
->where('tingkat_pendidikan', 'SLTA')
->orwhere('tingkat_pendidikan', 'SLTA Kejuruan')
->where('status_input', 'Import')
->count();
@endphp

<body>
    <main>
        <section class="hero">
            <div class="container">
                <div class="row align-items-start">
                    <!-- Kiri: Teks dan tombol -->
                    <div class="col-md-7 text-start">
                        <img src="{{ url('ilanding/assets/img/pandu2.png') }}" alt="Logo PANDU" class="logo-pandu mb-4">
                        <h1>Pengelolaan Kepegawaian Terpadu <br><span>Bengkulu Utara</span></h1>
                        <p class="mt-3">
                            Aplikasi pengumpulan dokumen dan kelengkapan mandiri data ASN Bengkulu Utara.
                            Segera Lengkapi Data Diri Anda dan Jadikan Aplikasi ini Menjadi Alat Bantu Yang Baik.
                        </p>
                        <div class="hero-buttons mt-4">
                            <a href="{{ url('login') }}" class="btn btn-danger me-3">Login</a>
                            <a href="{{ url('register') }}" class="btn btn-link">
                                <i class="bi bi-play-circle me-1"></i> Registrasi
                            </a>
                        </div>
                    </div>

                    <!-- Kanan: Logo Kabupaten dan 3 logo kecil -->
                    <div class="col-md-5 text-center">
                        <img src="{{ url('ilanding/assets/img/BU.png') }}" alt="Logo Kabupaten" class="logo-kabupaten">
                        <div>
                            <img src="{{ url('ilanding/assets/img/berakhlak.png') }}" alt="BerAKHLAK" class="logo1">
                            <img src="{{ url('ilanding/assets/img/bangga.png') }}" alt="Bangga Melayani Bangsa"
                                class="logo2">
                            <img src="{{ url('ilanding/assets/img/MAHABA3.png') }}" alt="MAHABBAH" class="logo3">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- Vendor JS Files -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ url('ilanding/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('ilanding/assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ url('ilanding/assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ url('ilanding/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ url('ilanding/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ url('ilanding/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ url('ilanding/assets/js/main.js') }}"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://unpkg.com/axios@0.27.2/dist/axios.min.js"></script>
    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
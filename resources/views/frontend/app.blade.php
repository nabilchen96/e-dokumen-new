<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>PANDU Pengelolaan Kepegawaian Terpadu</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="{{ url('pandu.jpeg') }}" rel="icon">
  <link href="{{ url('pandu.jpeg') }}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ url('ilanding/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ url('ilanding/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{ url('ilanding/assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ url('ilanding/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ url('ilanding/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ url('ilanding/assets/css/main.css') }}" rel="stylesheet">

  <style>
    .stat-item {
      text-align: center;
      /* Pusatkan konten */
    }

    .stat-icon {
      font-size: 2rem;
      margin-bottom: 10px;
    }

    .stat-content {
      margin-top: 10px;
    }

    /* Media Query untuk perangkat dengan lebar layar di bawah 768px */
    @media (max-width: 768px) {
      .stat-item {
        display: flex;
        flex-direction: column;
        /* Ubah arah menjadi vertikal */
        align-items: center;
      }

      .stat-icon {
        margin-bottom: 10px;
      }
    }

    .header .logo img {
      max-height: 60px !important;
    }
  </style>
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div style="border-radius: 0px !important;"
      class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center me-auto me-xl-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1 class="sitename">
          <img src="{{ url('pandu.jpeg') }}" alt="">

        </h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{ url('/') }}" class="active">Home</a></li>
          <!-- <li><a href="#about">About</a></li> -->
          <li><a href="{{ url('login') }}">Login</a></li>
          <li><a href="{{ url('register') }}">Register</a></li>
          <!-- <li><a href="#pricing">Pricing</a></li>
          <li class="dropdown"><a href="#"><span>Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="#">Dropdown 1</a></li>
              <li class="dropdown"><a href="#"><span>Deep Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                <ul>
                  <li><a href="#">Deep Dropdown 1</a></li>
                  <li><a href="#">Deep Dropdown 2</a></li>
                  <li><a href="#">Deep Dropdown 3</a></li>
                  <li><a href="#">Deep Dropdown 4</a></li>
                  <li><a href="#">Deep Dropdown 5</a></li>
                </ul>
              </li>
              <li><a href="#">Dropdown 2</a></li>
              <li><a href="#">Dropdown 3</a></li>
              <li><a href="#">Dropdown 4</a></li>
            </ul>
          </li>
          <li><a href="#contact">Contact</a></li> -->
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <!-- <a class="btn-getstarted" href="index.html#about">Get Started</a> -->

    </div>
  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row align-items-center">
          <div class="col-lg-6">
            <div class="hero-content" data-aos="fade-up" data-aos-delay="200">
              <!-- <div class="company-badge mb-4">
                <i class="bi bi-gear-fill me-2"></i>
                Panduan Aplikasi
              </div> -->
              <h2>Aplikasi <span class="text-danger">PANDU</span></h2>
              <h1 style="font-size: 3.5rem !important;" class="mb-4">
                Pengelolaan Kepegawaian Terpadu <br>
                <span class="accent-text">Bengkulu Utara</span>
              </h1>

              <p class="mb-4 mb-md-5">
                Aplikasi pengumpulan dokumen dan kelengkapan mandiri data non ASN Bengkulu Utara.
                Segera Lengkapi Data Diri Anda dan Jadikan Aplikasi ini Menjadi Alat Bantu Yang Baik
              </p>

              <div class="hero-buttons">
                <a href="{{ url('login') }}" class="btn btn-primary me-0 me-sm-2 mx-1">Login</a>
                <a href="{{ url('register') }}" class="btn btn-link mt-2 mt-sm-0">
                  <i class="bi bi-play-circle me-1"></i>
                  Registrasi
                </a>
              </div>
            </div>
          </div>

          <div class="col-lg-6 mb-4">
            <div class="hero-image" data-aos="zoom-out" data-aos-delay="300">
              <img src="{{ url('ilanding/assets/img/illustration-1.webp') }}" alt="Hero Image" class="img-fluid">

              <!-- <div class="customers-badge">
                <div class="customer-avatars">
                  <img src="assets/img/avatar-1.webp" alt="Customer 1" class="avatar">
                  <img src="assets/img/avatar-2.webp" alt="Customer 2" class="avatar">
                  <img src="assets/img/avatar-3.webp" alt="Customer 3" class="avatar">
                  <img src="assets/img/avatar-4.webp" alt="Customer 4" class="avatar">
                  <img src="assets/img/avatar-5.webp" alt="Customer 5" class="avatar">
                  <span class="avatar more">12+</span>
                </div>
                <p class="mb-0 mt-2">12,000+ lorem ipsum dolor sit amet consectetur adipiscing elit</p>
              </div> -->
            </div>
          </div>
        </div>

        <div class="d-none d-sm-block mt-5">
          <iframe class="contact" data-aos="fade-up" data-aos-delay="300"
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3982.6424613861236!2d102.19920717501995!3d-3.436870196537618!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e315b9e7801b9b1%3A0x300cd9e67330acf3!2sKantor%20Bupati%20Bengkulu%20Utara!5e0!3m2!1sid!2sid!4v1732679905033!5m2!1sid!2sid"
            width="100%" height="500" style="border:0; border-radius: 8px;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
          <!-- <div class="row stats-row mb-5 gy-4 mt-5"> -->
          <!-- @php

        $data = DB::table('dokumens')
          ->join('jenis_dokumens', 'dokumens.id_dokumen', '=', 'jenis_dokumens.id')
          ->select(
          'jenis_dokumens.jenis_dokumen',
          DB::raw('COUNT(dokumens.id) as total')
          )
          ->groupBy('jenis_dokumens.jenis_dokumen')
          ->limit(4)
          ->get();

        @endphp

            @foreach ($data as $d) -->


          <!-- <div class="col-lg-3 col-6 col-md-6"> -->
          <!-- <div class="stat-item">
                <div class="stat-icon">
                  <i class="bi bi-briefcase"></i>
                </div>
                <div class="stat-content">
                  <h4>{{ $d->jenis_dokumen }}</h4>
                  <p class="mb-0">{{ $d->total }} Dokumen</p>
                </div>
              </div> -->
          <!-- </div> -->

          <!-- @endforeach -->


          <!-- </div> -->
        </div>
      </div>

    </section><!-- /Hero Section -->

    <!-- Features Cards Section -->

    <!-- /Features Cards Section -->

    <!-- Contact Section -->
    <!-- <section > -->

    <!-- Section Title -->
    <!-- <div class="container section-title" data-aos="fade-up">
        <h2>Contact</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div> -->
    <!-- End Section Title -->

    <!-- <div class="container" data-aos="fade-up" data-aos-delay="100">
      </div> -->

    <!-- <iframe class="contact" data-aos="fade-up" data-aos-delay="300"
      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3982.6424613861236!2d102.19920717501995!3d-3.436870196537618!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e315b9e7801b9b1%3A0x300cd9e67330acf3!2sKantor%20Bupati%20Bengkulu%20Utara!5e0!3m2!1sid!2sid!4v1732679905033!5m2!1sid!2sid"
      width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy"
      referrerpolicy="no-referrer-when-downgrade"></iframe> -->

    <!-- </section> -->
    <!-- /Contact Section -->

  </main>

  <footer id="footer" class="footer">

    <!-- <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.html" class="logo d-flex align-items-center">
            <span class="sitename">iLanding</span>
          </a>
          <div class="footer-contact pt-3">
            <p>A108 Adam Street</p>
            <p>New York, NY 535022</p>
            <p class="mt-3"><strong>Phone:</strong> <span>+1 5589 55488 55</span></p>
            <p><strong>Email:</strong> <span>info@example.com</span></p>
          </div>
          <div class="social-links d-flex mt-4">
            <a href=""><i class="bi bi-twitter-x"></i></a>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Useful Links</h4>
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">About us</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Terms of service</a></li>
            <li><a href="#">Privacy policy</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Our Services</h4>
          <ul>
            <li><a href="#">Web Design</a></li>
            <li><a href="#">Web Development</a></li>
            <li><a href="#">Product Management</a></li>
            <li><a href="#">Marketing</a></li>
            <li><a href="#">Graphic Design</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Hic solutasetp</h4>
          <ul>
            <li><a href="#">Molestiae accusamus iure</a></li>
            <li><a href="#">Excepturi dignissimos</a></li>
            <li><a href="#">Suscipit distinctio</a></li>
            <li><a href="#">Dilecta</a></li>
            <li><a href="#">Sit quas consectetur</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Nobis illum</h4>
          <ul>
            <li><a href="#">Ipsam</a></li>
            <li><a href="#">Laudantium dolorum</a></li>
            <li><a href="#">Dinera</a></li>
            <li><a href="#">Trodelas</a></li>
            <li><a href="#">Flexo</a></li>
          </ul>
        </div>

      </div>
    </div> -->

    <!-- <div class="container text-center mt-4 mb-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">iLanding</strong> <span>All Rights Reserved</span></p>
      <div class="credits">
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> Distributed By <a
          href="https://themewagon.com">ThemeWagon</a>
      </div>
    </div> -->

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ url('ilanding/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ url('ilanding/assets/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ url('ilanding/assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ url('ilanding/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ url('ilanding/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ url('ilanding/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>

  <!-- Main JS File -->
  <script src="{{ url('ilanding/assets/js/main.js') }}"></script>

</body>

</html>
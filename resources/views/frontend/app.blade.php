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
  <!-- DataTables Bootstrap 5 CSS -->
  <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

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

    .bg-gradient-info {
      background: linear-gradient(to bottom, #0e4cfd, #6a8eff);
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

    .card.card-img-holder .card-img-absolute {
      position: absolute;
      top: 0;
      right: 0;
      height: 100%;
    }

    td, th{
      padding: 15px;
      text-align: center !important;
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

        <div class="row mt-5">
          <div class="col-lg-3 mt-3">
            <a>
              <div style="border-radius: 0.5rem; border: none;"
                class="card bg-gradient-info card-img-holder text-white">
                <div class="card-body">
                  <img src="https://themewagon.github.io/purple-react/static/media/circle.953c9ca0.svg"
                    class="card-img-absolute" alt="circle">
                  <h4 class="font-weight-normal mb-3 text-white">
                    Lulusan S3
                  </h4>
                  <h2 class="text-white">
                    {{ @$s3 ?? 0}}
                  </h2>
                  <span>Orang</span>
                </div>
              </div>
            </a>

          </div>
          <div class="col-lg-3 mt-3">
            <div style="border-radius: 0.5rem; border: none;"
              class="card bg-gradient-info card-img-holder text-white">
              <div class="card-body">
                <img src="https://themewagon.github.io/purple-react/static/media/circle.953c9ca0.svg"
                  class="card-img-absolute" alt="circle">
                <h4 class="font-weight-normal mb-3 text-white">
                  Lulusan S2
                  <i class="bi bi-person-circle float-right"></i>
                </h4>
                <h2 class="text-white">
                  {{ @$s2 ?? 0}}
                </h2>
                <span>Orang</span>
              </div>
            </div>
          </div>
          <div class="col-lg-3 mt-3">
            <a>
              <div style="border-radius: 0.5rem; border: none;"
                class="card bg-gradient-info card-img-holder text-white">
                <div class="card-body">
                  <img src="https://themewagon.github.io/purple-react/static/media/circle.953c9ca0.svg"
                    class="card-img-absolute" alt="circle">
                  <h4 class="font-weight-normal mb-3 text-white">
                    Lulusan S1
                    <i class="bi bi-person-circle float-right"></i>
                  </h4>
                  <h2 class="text-white">
                    {{ @$s1 ?? 0}}
                  </h2>
                  <span>Orang</span>
                </div>
              </div>
            </a>
          </div>
          <div class="col-lg-3 mt-3">
            <a>
              <div style="border-radius: 0.5rem; border: none;"
                class="card bg-gradient-info card-img-holder text-white">
                <div class="card-body">
                  <img src="https://themewagon.github.io/purple-react/static/media/circle.953c9ca0.svg"
                    class="card-img-absolute" alt="circle">
                  <h4 class="font-weight-normal mb-3 text-white">
                    Lulusan DIV
                    <i class="bi bi-person-circle float-right"></i>
                  </h4>
                  <h2 class="text-white">
                    {{ @$d4 ?? 0}}
                  </h2>
                  <span>Orang</span>
                </div>
              </div>
            </a>
          </div>
          <div class="col-lg-3 mt-3">
            <a>
              <div style="border-radius: 0.5rem; border: none;"
                class="card bg-gradient-info card-img-holder text-white">
                <div class="card-body">
                  <img src="https://themewagon.github.io/purple-react/static/media/circle.953c9ca0.svg"
                    class="card-img-absolute" alt="circle">
                  <h4 class="font-weight-normal mb-3 text-white">
                    Lulusan DIII
                    <i class="bi bi-person-circle float-right"></i>
                  </h4>
                  <h2 class="text-white">
                    {{ @$d3 ?? 0}}
                  </h2>
                  <span>Orang</span>
                </div>
              </div>
            </a>

          </div>
          <div class="col-lg-3 mt-3">
            <a>
              <div style="border-radius: 0.5rem; border: none;"
                class="card bg-gradient-info card-img-holder text-white">
                <div class="card-body">
                  <img src="https://themewagon.github.io/purple-react/static/media/circle.953c9ca0.svg"
                    class="card-img-absolute" alt="circle">
                  <h4 class="font-weight-normal mb-3 text-white">
                    Lulusan DII
                    <i class="bi bi-person-circle float-right"></i>
                  </h4>
                  <h2 class="text-white">
                    {{ @$d2 ?? 0}}
                  </h2>
                  <span>Orang</span>
                </div>
              </div>
            </a>
          </div>
          <div class="col-lg-3 mt-3">
            <a>
              <div style="border-radius: 0.5rem; border: none;"
                class="card bg-gradient-info card-img-holder text-white">
                <div class="card-body">
                  <img src="https://themewagon.github.io/purple-react/static/media/circle.953c9ca0.svg"
                    class="card-img-absolute" alt="circle">
                  <h4 class="font-weight-normal mb-3 text-white">
                    Lulusan DI
                    <i class="bi bi-person-circle float-right"></i>
                  </h4>
                  <h2 class="text-white">
                    {{ @$d1 ?? 0}}
                  </h2>
                  <span>Orang</span>
                </div>
              </div>
            </a>

          </div>
          <div class="col-lg-3 mt-3">
            <a>
              <div style="border-radius: 0.5rem; border: none;"
                class="card bg-gradient-info card-img-holder text-white">
                <div class="card-body">
                  <img src="https://themewagon.github.io/purple-react/static/media/circle.953c9ca0.svg"
                    class="card-img-absolute" alt="circle">
                  <h4 class="font-weight-normal mb-3 text-white">
                    Lulusan SMA
                    <i class="bi bi-person-circle float-right"></i>
                  </h4>
                  <h2 class="text-white">
                    {{ @$sma ?? 0 }}
                  </h2>
                  <span>Orang</span>
                </div>
              </div>
            </a>
          </div>
          <div class="col-lg-6 mt-4">
            <div class="card">
              <div class="card-body">
                <div id="jenisKelamin"></div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 mt-4">
            <div class="card">
              <div class="card-body">
                <div id="jenisJabatan"></div>
              </div>
            </div>
          </div>
          <div class="col-lg-12 mt-4">
            <div class="card">
              <div class="card-body">
                <div id="container"></div>
              </div>
            </div>
          </div>
          <div class="col-lg-12 mt-4">
            <div class="card">
              <div class="card-body">
                <div id="pangkat"></div>
              </div>
            </div>
          </div>
          <div class="col-lg-12 mt-4">
            <div class="card">
              <div class="card-body">
                <div id="umur"></div>
              </div>
            </div>
          </div>
          <div class="col-lg-12 mt-4">
            <div class="card">
              <div class="card-body">
                <h3 class="mt-4">Distribusi SKPD</h3>
                <p class="mb-4">Total Pegawai ASN Berdasarkan SKPD</p>
                <table id="myTable" class="table table-striped display" style="width:100%">
                  <thead class="bg-gradient-info text-white text-center">
                    <tr>
                      <th>No</th>
                      <th>SKPD</th>
                      <th width="10%">Laki-laki</th>
                      <th>Perempuan</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

    </section><!-- /Hero Section -->

    <!-- Features Cards Section -->

    <!-- /Features Cards Section -->



  </main>

  <footer id="footer" class="footer">


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
  <script>
    axios.get('/data-pendidikan')
      .then(response => {
        const rawData = response.data;

        const categories = rawData.map(item => {
          return item.tingkat_pendidikan == null ? 'Belum Isi' : item.tingkat_pendidikan;
        });
        const dataLaki = rawData.map(item => Number(item.laki_laki));
        const dataPerempuan = rawData.map(item => Number(item.perempuan));

        console.log(dataLaki);


        Highcharts.chart('container', {
          chart: {
            type: 'column'
          },
          title: {
            text: 'Distribusi Pendidikan'
          },
          subtitle: {
            text: 'Total Pegawai ASN Berdasarkan Pendidikan'
          },
          xAxis: {
            categories: categories,
            title: {
              text: 'Tingkat Pendidikan'
            }
          },
          yAxis: {
            min: 0,
            title: {
              text: 'Jumlah Orang'
            },
            stackLabels: {
              enabled: true,
              style: {
                fontWeight: 'bold'
              }
            }
          },
          legend: {
            reversed: false
          },
          plotOptions: {
            column: {
              stacking: 'normal',
            }
          },
          series: [
            {
              name: 'Laki-laki',
              data: dataLaki,
            },
            {
              name: 'Perempuan',
              data: dataPerempuan,
            }
          ]
        });
      })
      .catch(error => {
        console.error('Gagal mengambil data chart:', error);
      });
  </script>
  <script>
    axios.get('/data-jenis-kelamin')
      .then(response => {
        const rawData = response.data;

        const dataPie = rawData.map(item => {
          let label = item.jenis_kelamin
          return {
            name: label,
            y: parseInt(item.total)
          };
        });

        Highcharts.chart('jenisKelamin', {
          chart: {
            type: 'pie'
          },
          title: {
            text: 'Distribusi Jenis Kelamin'
          },
          subtitle: {
            text: 'Total Pegawai ASN Berdasarkan Jenis Kelamin'
          },
          tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b> ({point.y} orang)'
          },
          accessibility: {
            point: {
              valueSuffix: '%'
            }
          },
          plotOptions: {
            pie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.y} ({point.percentage:.1f}%)'
              },
            }
          },
          series: [{
            name: 'Persentase',
            colorByPoint: true,
            data: dataPie
          }]
        });
      })
      .catch(error => {
        console.error('Gagal memuat data pie chart:', error);
      });
  </script>
  <script>
    axios.get('/data-jenis-jabatan')
      .then(response => {
        const rawData = response.data;

        const dataPie = rawData.map(item => {
          let label = ''; // deklarasi di awal

          if (item.jenis_jabatan != null) {
            const words = item.jenis_jabatan.split(' ');
            label = words[1] || words[0]; // kata kedua, fallback ke pertama
          } else {
            label = 'Lainnya'; // default jika null
          }

          return {
            name: label,
            y: parseInt(item.total)
          };
        });

        Highcharts.chart('jenisJabatan', {
          chart: {
            type: 'pie'
          },
          title: {
            text: 'Distribusi Jenis Jabatan'
          },
          subtitle: {
            text: 'Total Pegawai ASN Berdasarkan Jenis Jabatan'
          },
          tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b> ({point.y} orang)'
          },
          accessibility: {
            point: {
              valueSuffix: '%'
            }
          },
          plotOptions: {
            pie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.y} ({point.percentage:.1f}%)'
              },
            }
          },
          series: [{
            name: 'Persentase',
            colorByPoint: true,
            data: dataPie
          }]
        });
      })
      .catch(error => {
        console.error('Gagal memuat data pie chart:', error);
      });
  </script>
  <script>
    axios.get('/data-pangkat')
      .then(response => {
        const rawData = response.data;

        const categories = rawData.map(item => {


          let label = ''; // deklarasi di awal

          if (item.pangkat != null) {
            const words = item.pangkat.split(' - ');
            label = words[0]; // kata kedua, fallback ke pertama
          } else {
            label = 'Belum Isi'; // default jika null
          }

          return label;

        });
        const dataLaki = rawData.map(item => Number(item.laki_laki));
        const dataPerempuan = rawData.map(item => Number(item.perempuan));


        Highcharts.chart('pangkat', {
          chart: {
            type: 'column'
          },
          title: {
            text: 'Distribusi Pangkat'
          },
          subtitle: {
            text: 'Total Pegawai ASN Berdasarkan Pangkat'
          },
          xAxis: {
            categories: categories,

          },
          yAxis: {
            min: 0,
            title: {
              text: 'Jumlah Orang'
            },
            stackLabels: {
              enabled: true,
              style: {
                fontWeight: 'bold'
              }
            }
          },
          legend: {
            reversed: false
          },
          plotOptions: {
            column: {
              stacking: 'normal',
            }
          },
          series: [
            {
              name: 'Laki-laki',
              data: dataLaki,
            },
            {
              name: 'Perempuan',
              data: dataPerempuan,
            }
          ]
        });
      })
      .catch(error => {
        console.error('Gagal mengambil data chart:', error);
      });
  </script>
  <script>
    axios.get('/data-statistik-umur')
      .then(response => {
        const rawData = response.data;

        const categories = rawData.map(item => {
          return item.umur;
        });
        const dataLaki = rawData.map(item => Number(item.laki_laki));
        const dataPerempuan = rawData.map(item => Number(item.perempuan));

        console.log(dataLaki);


        Highcharts.chart('umur', {
          chart: {
            type: 'column'
          },
          title: {
            text: 'Distribusi Umur'
          },
          subtitle: {
            text: 'Total Pegawai ASN Berdasarkan Umur'
          },
          xAxis: {
            categories: categories,

          },
          yAxis: {
            min: 0,
            title: {
              text: 'Jumlah Orang'
            },
            stackLabels: {
              enabled: true,
              style: {
                fontWeight: 'bold'
              }
            }
          },
          legend: {
            reversed: false
          },
          plotOptions: {
            column: {
              stacking: 'normal',
              point: {
                events: {
                  click: function () {
                    // Gantilah URL sesuai kebutuhan Anda
                    const umur = this.category; // Kategori umur
                    window.location.href = `/detail-statistik-umur?umur=${umur}`; // URL berdasarkan umur yang diklik
                  }
                }
              }
            }
          },
          series: [
            {
              name: 'Laki-laki',
              data: dataLaki,
            },
            {
              name: 'Perempuan',
              data: dataPerempuan,
            }
          ]
        });
      })
      .catch(error => {
        console.error('Gagal mengambil data chart:', error);
      });
  </script>
  <script>
    $(document).ready(function () {
      $('#myTable').DataTable({
        ajax: {
          url: '/data-statistik-skpd',
          dataSrc: ''
        },
        pageLength: 100,
        columns: [
          {
            data: null,
            render: function (data, type, row, meta) {
              return meta.row + 1;
            }
          },
          { data: 'nama_skpd' },
          { data: 'laki_laki' },
          { data: 'perempuan' },
          {
            render: function (data, type, row) {
              return Number(row.laki_laki) + Number(row.perempuan);
            }
          }
        ]
      });
    });
  </script>
</body>

</html>
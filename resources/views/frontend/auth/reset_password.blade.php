<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="login-form-02/https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="login-form-02/fonts/icomoon/style.css">

  <link rel="stylesheet" href="login-form-02/css/owl.carousel.min.css">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="login-form-02/css/bootstrap.min.css">

  <!-- Style -->
  <link rel="stylesheet" href="login-form-02/css/style.css">

  <!-- Favicons -->
  <link href="{{ url('pandu.jpeg') }}" rel="icon">
  <link href="{{ url('pandu.jpeg') }}" rel="apple-touch-icon">

  <title>PANDU Pengelolaan Kepegawaian Terpadu</title>
</head>

<body>


  <div class="d-lg-flex half">
    <div class="bg order-1 order-md-2" style="background-image: url('natural.png');"></div>
    <div class="contents order-2 order-md-1">

      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-7">
            <h3>Reset Password <br><strong><span class="text-danger">PANDU</span> Pengelolaan Kepegawaian Terpadu</strong></h3>
            <br>
            <form id="formRegister">
              <div class="form-group mb-3">
                <label>No Whatsapp</label>
                <div class="input-group">
                  <input type="number" class="form-control" id="no_wa" placeholder="No Whatsapp" name="no_wa">
                  <button class="input-group-text" id="btnSendOtp">🚀 Send</a>
                </div>
                <span style="font-size: 12px;" class="text-danger">*Jangan berikan kode OTP kepada orang lain</span>
              </div>
              <div class="form-group">
                <label>Kode OTP</label>
                <input type="text" name="otp" class="form-control" id="otp" placeholder="OTP">
              </div>
              <div class="form-group">
                <label>New Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Password">
              </div>
              <div class="d-grid">
                <button type="submit" id="btnLogin" class="btn btn-primary btn-lg btn-block">Reset Password</button>

                <button style="display: none; background: #0d6efd;" id="btnLoginLoading"
                  class="btn btn-info btn-moodle text-white btn-lg btn-block" type="button" disabled>
                  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>

                </button>
              </div>
              <br>
              Have an account? <a href="{{ url('login') }}" class="text-primary">Login</a>
            </form>
          </div>
        </div>
      </div>
    </div>


  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.7/dist/sweetalert2.all.min.js"></script>

  <script>
    formRegister.onsubmit = (e) => {

      e.preventDefault();

      const formData = new FormData(formRegister);

      axios({
        method: 'post',
        url: '/reset-password-proses',
        data: formData,
      })
        .then(function (res) {
          //handle success
          if (res.data.responCode == 1) {

            Swal.fire({
              icon: 'success',
              title: 'Data Berhasil Disimpan!',
              text: 'Password baru anda sudah diganti, harap simpan password anda!',
              timer: 1000,
            })

            setTimeout(() => {
              window.location.href = '/login';
            }, 1000);

          } else {

            Swal.fire({
              icon: 'warning',
              title: 'Kode OTP Salah',
              text: `Kode OTP yang dimasukan salah, silahkan ulangi kembali!.`,
            })
          }
        })
        .catch(function (res) {
          //handle error
          console.log(res);
        }).then(function () {
          // always executed              
          document.getElementById(`btnLogin`).style.display = "block";
          document.getElementById(`btnLoginLoading`).style.display = "none";

        });

    }

  </script>


  <script>
    document.getElementById('btnSendOtp').addEventListener('click', function (e) {
      e.preventDefault();

      // Ambil nilai no_wa dari input
      const noWa = document.getElementById('no_wa').value;

      // Validasi input kosong
      if (!noWa) {
        Swal.fire({
          icon: 'warning',
          title: 'No Whatsapp wajib diisi',
          text: 'Harap mengisi nomor whatsapp terlebih dahulu',
          showConfirmButton: true,
        });
        return;
      }

      // Kirim request ke server
      axios.post('/resetOtp', { no_wa: noWa })
        .then(function (response) {
          // Handle sukses
          if (response.data.status == 'success') {
            Swal.fire({
              icon: 'success',
              title: 'Kode OTP berhasil dikirim',
              text: 'kode OTP hanya berlaku selama satu menit',
              showConfirmButton: true,
            });

            // Jalankan countdown 60 detik
            startCountdown();
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Gagal mengirim OTP',
              text: response.data.respon,
              showConfirmButton: true,
            });
          }
        })
        .catch(function (error) {
          // Handle error
          console.error(error);
          Swal.fire({
            icon: 'error',
            title: 'Terjadi kesalahan',
            text: 'Tidak dapat mengirim OTP.',
            showConfirmButton: true,
          });
        });
    });

    // Fungsi untuk mengatur countdown
    function startCountdown() {
      const btnSendOtp = document.getElementById('btnSendOtp');
      let countdown = 60; // Durasi countdown dalam detik

      // Nonaktifkan tombol
      btnSendOtp.disabled = true;

      // Timer interval
      const timer = setInterval(() => {
        btnSendOtp.textContent = `⏳ ${countdown} detik`;
        countdown--;

        // Jika countdown selesai
        if (countdown < 0) {
          clearInterval(timer); // Hentikan timer
          btnSendOtp.textContent = "🚀 Send"; // Kembalikan teks tombol
          btnSendOtp.disabled = false; // Aktifkan tombol
        }
      }, 1000); // Interval per detik
    }
  </script>


</body>

</html>
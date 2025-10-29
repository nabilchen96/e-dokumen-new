<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register | PANDU</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.7/dist/sweetalert2.all.min.js"></script>
    <!-- Favicon -->
    <link href="{{ url('ilanding/assets/img/pandu3.png') }}" rel="icon">
    <link href="{{ url('ilanding/assets/img/pandu3.png') }}" rel="apple-touch-icon">
</head>

<body class="min-h-screen bg-gradient-to-br from-[#fce5e9] to-[#f7d6e6] flex items-center justify-center relative">

    <!-- Marquee -->
    <!-- <div class="absolute top-0 left-0 right-0 bg-blue-500 text-white text-sm py-2 px-4">
    <marquee behavior="scroll" direction="left">📢 Selamat datang di Aplikasi PANDU - Pastikan data Anda lengkap!</marquee>
  </div> -->

    <!-- Register Card -->
    <div class="mt-20 z-10 w-full max-w-md bg-white/30 backdrop-blur-md rounded-2xl shadow-xl p-8 mx-4 text-slate-800">

        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <img src="{{ url('pandu2.png') }}" alt="Logo PANDU" class="w-50 h-auto max-h-24 object-contain" />
        </div>

        <h2 class="text-2xl font-bold mb-2 text-center">Daftar Akun</h2>
        <p class="text-sm text-slate-700 mb-6 text-center">Masukkan informasi berikut untuk mendaftar.</p>

        <form id="formRegister" class="space-y-4">
            {{-- <!-- No WA -->
      <div>
        <label class="block text-sm font-medium mb-1">No Whatsapp</label>
        <div class="flex">
          <input type="number" name="no_wa" id="no_wa" placeholder="08xxxxxxxxxx"
            class="w-full px-4 py-2 rounded-l-md bg-white/60 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-red-400"
            required />
          <button type="button" id="btnSendOtp"
            class="bg-red-600 text-white px-4 rounded-r-md hover:bg-red-700 transition">🚀 Send</button>
        </div>
      </div> --}}

            {{-- EMAIL  --}}
            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <div class="flex">
                    <input type="mail" name="email" id="email" placeholder="Email Address"
                        class="w-full px-4 py-2 rounded-l-md bg-white/60 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-red-400"
                        required />
                    <button type="button" id="btnSendOtp"
                        class="bg-red-600 text-white px-4 rounded-r-md hover:bg-red-700 transition">🚀 Send</button>
                </div>
            </div>

            <!-- OTP -->
            <div>
                <label class="block text-sm font-medium mb-1">Kode OTP</label>
                <input type="text" name="otp" id="otp" placeholder="Masukkan OTP"
                    class="w-full px-4 py-2 rounded-md bg-white/60 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-red-400"
                    required />
            </div>

            <!-- Submit -->
            <button type="submit" id="btnLogin"
                class="w-full py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-md transition">
                Sign Up
            </button>

            <button type="button" id="btnLoginLoading" style="display: none;" disabled
                class="w-full py-2 bg-red-400 text-white rounded-md flex items-center justify-center">
                <svg class="animate-spin h-5 w-5 mr-2" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4" />
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.4 0 0 5.4 0 12h4z" />
                </svg>
                Loading...
            </button>

            <p class="text-sm text-center mt-4">
                Sudah punya akun?
                <a href="{{ url('login') }}" class="text-red-500 font-semibold hover:underline">Login</a>
            </p>
        </form>
    </div>

    <!-- JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.7/dist/sweetalert2.all.min.js"></script>
    <script>
        const formRegister = document.getElementById("formRegister");
        const btnSendOtp = document.getElementById("btnSendOtp");
        const btnLogin = document.getElementById("btnLogin");
        const btnLoginLoading = document.getElementById("btnLoginLoading");

        // === SUBMIT FORM ===
        formRegister.onsubmit = (e) => {
            e.preventDefault();

            const formData = new FormData(formRegister);
            btnLogin.style.display = "none";
            btnLoginLoading.style.display = "flex";

            axios.post('/registerOtpCek', formData)
                .then(res => {
                    if (res.data.responCode == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: 'OTP Ditemukan',
                            text: 'Anda akan diarahkan ke pengisian data...',
                            timer: 1000,
                            showConfirmButton: false
                        });
                        setTimeout(() => {
                            window.location.href = '/register2';
                        }, 1000);
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'OTP Salah',
                            text: 'Silakan ulangi kembali!'
                        });
                    }
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Kesalahan Server',
                        text: 'Terjadi kesalahan saat memproses data.'
                    });
                })
                .finally(() => {
                    btnLogin.style.display = "block";
                    btnLoginLoading.style.display = "none";
                });
        };

        // === KIRIM OTP ===
        btnSendOtp.addEventListener('click', function(e) {
            e.preventDefault();
            const email = document.getElementById('email').value;

            if (!email) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Email wajib diisi',
                    text: 'Silakan isi email terlebih dahulu.'
                });
                return;
            }

            // Tampilkan animasi loading di tombol
            btnSendOtp.disabled = true;
            const originalText = btnSendOtp.innerHTML;
            btnSendOtp.innerHTML = `
      <svg class="animate-spin h-5 w-5 mr-2 inline" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.4 0 0 5.4 0 12h4z"></path>
      </svg> Mengirim...
    `;

            axios.post('/registerOtp', {
                    email: email
                })
                .then(response => {
                    if (response.data.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'OTP Dikirim!',
                            text: 'Kode OTP telah dikirim ke email Anda (berlaku 1 menit).'
                        });
                        startCountdown();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal kirim OTP',
                            text: response.data.respon || 'Silakan coba lagi.'
                        });
                    }
                })
                .catch(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Tidak dapat mengirim OTP. Periksa koneksi atau server Anda.'
                    });
                })
                .finally(() => {
                    // Kembalikan tampilan tombol ke semula
                    btnSendOtp.innerHTML = originalText;
                    btnSendOtp.disabled = false;
                });
        });

        // === TIMER 60 DETIK ===
        function startCountdown() {
            let count = 60;
            btnSendOtp.disabled = true;
            const timer = setInterval(() => {
                btnSendOtp.textContent = `⏳ ${count} detik`;
                count--;
                if (count < 0) {
                    clearInterval(timer);
                    btnSendOtp.textContent = '🚀 Send';
                    btnSendOtp.disabled = false;
                }
            }, 1000);
        }
    </script>


</body>

</html>

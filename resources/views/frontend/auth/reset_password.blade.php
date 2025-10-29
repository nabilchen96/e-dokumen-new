<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset Password | PANDU</title>
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

        <h2 class="text-2xl font-bold mb-2 text-center">Reset Password</h2>
        {{-- <p class="text-sm text-slate-700 mb-6 text-center">Masukkan nomor WA dan OTP untuk reset password</p> --}}
        <p class="text-sm text-slate-700 mb-6 text-center">Masukkan Email dan OTP untuk reset password</p>

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

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <div class="flex">
                    <input type="email" name="no_wa" id="no_wa" placeholder="Email"
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

                <small class="text-danger">*Jangan berikan kode OTP kepada orang lain</small>

                <div class="relative">
                    <label for="password" class="block text-sm font-medium mb-1 text-gray-900">New Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-2 pr-10 rounded-md bg-yellow-100 border border-gray-300 focus:outline-none"
                        placeholder="Password" />

                    <!-- Tombol intip password -->

                    <button type="button" onmousedown="showPassword(true)" onmouseup="showPassword(false)"
                        onmouseleave="showPassword(false)"
                        class="absolute right-2 top-0 bottom-0 my-auto h-full flex items-center text-gray-700 translate-y-[12px]">
                        <!-- Ikon mata -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 3C5 3 1.73 7.11 1 10c.73 2.89 4 7 9 7s8.27-4.11 9-7c-.73-2.89-4-7-9-7zm0 12c-2.76 0-5-2.24-5-5s2.24-5
                5-5 5 2.24 5 5-2.24 5-5 5zm0-8a3 3 0 100 6 3 3 0 000-6z" />
                        </svg>
                    </button>

                </div>
                <small class="text-danger">*Password minimal 8 karakter harus mengandung huruf kapital, huruf kecil dan
                    angka</small>
                <div class="relative">
                    <label for="confirm_password" class="block text-sm font-medium mb-1 text-gray-900">Konfirmasi
                        Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required
                        class="w-full px-4 py-2 pr-10 rounded-md bg-yellow-100 border border-gray-300 focus:outline-none"
                        placeholder="Ulangi Password" />

                    <!-- Tombol intip konfirmasi password -->
                    <button type="button" onmousedown="showConfirmPassword(true)"
                        onmouseup="showConfirmPassword(false)" onmouseleave="showConfirmPassword(false)"
                        class="absolute right-2 top-0 bottom-0 my-auto h-full flex items-center text-gray-700 translate-y-[12px]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 3C5 3 1.73 7.11 1 10c.73 2.89 4 7 9 7s8.27-4.11 9-7c-.73-2.89-4-7-9-7zm0 12c-2.76 0-5-2.24-5-5s2.24-5
                5-5 5 2.24 5 5-2.24 5-5 5zm0-8a3 3 0 100 6 3 3 0 000-6z" />
                        </svg>
                    </button>
                </div>
            </div>
            <!-- Submit -->
            <button type="submit" id="btnLogin"
                class="w-full py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-md transition">
                Reset Password
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

        </form>
    </div>

    <!-- JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.7/dist/sweetalert2.all.min.js"></script>
    <script>
        function showConfirmPassword(show) {
            const input = document.getElementById("confirm_password");
            input.type = show ? "text" : "password";
        }

        function showPassword(show) {
            const input = document.getElementById("password");
            input.type = show ? "text" : "password";
        }
        const formRegister = document.getElementById("formRegister");

        formRegister.onsubmit = (e) => {
            e.preventDefault();

            const password = document.getElementById("password").value;
            const confirmPassword = document.getElementById("confirm_password").value;

            // Validasi password & konfirmasi
            if (password !== confirmPassword) {
                Swal.fire({
                    icon: 'error',
                    title: 'Password Tidak Cocok',
                    text: 'Pastikan password dan konfirmasi sama.'
                });
                return;
            }

            // Validasi kekuatan password
            const strongPasswordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/;

            if (!strongPasswordPattern.test(password)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Password Lemah',
                    html: 'Password minimal 8 karakter harus mengandung:<br>- Huruf besar<br>- Huruf kecil<br>- Angka'
                });
                return;
            }



            const formData = new FormData(formRegister);
            document.getElementById("btnLogin").style.display = "none";
            document.getElementById("btnLoginLoading").style.display = "flex";

            axios.post('/reset-password-proses', formData)
                .then(res => {
                    if (res.data.responCode == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: 'OTP Ditemukan',
                            text: 'Password Berhasil di Reset Silahkan Coba Login Kembali',
                            timer: 1000
                        });
                        setTimeout(() => {
                            window.location.href = '/login';
                        }, 1000);
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'OTP Salah',
                            text: 'Silakan ulangi kembali!'
                        });
                    }
                })
                .catch(err => console.error(err))
                .finally(() => {
                    document.getElementById("btnLogin").style.display = "block";
                    document.getElementById("btnLoginLoading").style.display = "none";
                });
        }

        // === KIRIM OTP ===
        document.getElementById('btnSendOtp').addEventListener('click', function(e) {
            e.preventDefault();
            const email = document.getElementById('no_wa').value; // meskipun id-nya 'no_wa', ini adalah email

            if (!email) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Email wajib diisi',
                    text: 'Silakan isi email terlebih dahulu.'
                });
                return;
            }

            const btn = document.getElementById('btnSendOtp');
            const originalText = btn.innerHTML;

            // tampilkan loading di tombol
            btn.disabled = true;
            btn.innerHTML = `
      <svg class="animate-spin h-5 w-5 mr-2 inline" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.4 0 0 5.4 0 12h4z"></path>
      </svg>
      Mengirim...
    `;

            axios.post('/resetOtp', {
                    no_wa: email
                })
                .then(response => {
                    if (response.data.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'OTP Dikirim!',
                            text: 'Kode OTP telah dikirim ke email Anda. Berlaku selama 1 menit.'
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
                    // Kembalikan tombol seperti semula (kalau tidak dalam countdown)
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                });
        });

        // === TIMER 60 DETIK ===
        function startCountdown() {
            const btn = document.getElementById('btnSendOtp');
            let count = 60;
            btn.disabled = true;
            const timer = setInterval(() => {
                btn.textContent = `⏳ ${count} detik`;
                count--;
                if (count < 0) {
                    clearInterval(timer);
                    btn.textContent = '🚀 Send';
                    btn.disabled = false;
                }
            }, 1000);
        }
    </script>

</body>

</html>

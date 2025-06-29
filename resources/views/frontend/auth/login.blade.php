<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login | PANDU</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.7/dist/sweetalert2.all.min.js"></script>
  <!-- Favicon -->
  <link href="{{ url('ilanding/assets/img/pandu2.png') }}" rel="icon">
  <link href="{{ url('ilanding/assets/img/pandu2.png') }}" rel="apple-touch-icon">
  <style>
    body {
      font-family: 'Roboto', sans-serif;
    }
  </style>
</head>

<body
  class="min-h-screen bg-gradient-to-br from-[#fce5e9] to-[#f7d6e6] flex items-center justify-center relative overflow-hidden">



  <!-- Container Login -->
  <div class="z-10 w-full max-w-md bg-white/30 backdrop-blur-md rounded-2xl shadow-xl p-8 mx-4 text-slate-800">

    <!-- Header -->

    <!-- Logo Tengah Saja -->
    <div class="flex justify-center mb-6">
      <img src="{{ url('ilanding/assets/img/pandu2.png') }}" alt="Logo PANDU" class="w-50 h-auto max-h-24 object-contain" />
    </div>



    <h2 class="text-2xl font-bold mb-2">Login Aplikasi</h2>
    <p class="text-sm text-slate-700 mb-6">Masukkan akun Anda untuk melanjutkan.</p>

    <!-- Form -->
    <form id="formLogin" class="space-y-4">
      <div>
        <label for="nip_email" class="block text-sm font-medium mb-1">NIP atau Email</label>
        <input type="text" id="nip_email" name="nip_email" required
          class="w-full px-4 py-2 rounded-md bg-white/60 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-red-400"
          placeholder="NIP atau Email" />
      </div>

      <div class="relative">
          <label for="password" class="block text-sm font-medium mb-1 text-gray-900">Password</label>
          <input type="password" id="password" name="password" required
            class="w-full px-4 py-2 pr-10 rounded-md bg-yellow-100 border border-gray-300 focus:outline-none"
            placeholder="Password" />
        
          <!-- Tombol intip password -->
          <button type="button"
            onmousedown="showPassword(true)"
            onmouseup="showPassword(false)"
            onmouseleave="showPassword(false)"
            class="absolute right-2 top-0 bottom-0 my-auto h-full flex items-center text-gray-700 translate-y-[12px]">
            <!-- Ikon mata -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path d="M10 3C5 3 1.73 7.11 1 10c.73 2.89 4 7 9 7s8.27-4.11 9-7c-.73-2.89-4-7-9-7zm0 12c-2.76 0-5-2.24-5-5s2.24-5 
                5-5 5 2.24 5 5-2.24 5-5 5zm0-8a3 3 0 100 6 3 3 0 000-6z"/>
            </svg>
          </button>
        </div>

      <div class="flex items-center justify-between text-sm">
        <label class="flex items-center">
          <input type="checkbox" class="mr-2"> Remember me
        </label>
        <a href="{{ url('reset-password') }}" class="text-red-500 hover:underline">Lupa Password?</a>
      </div>

      <button type="submit" id="btnLogin"
        class="w-full py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-md transition">
        Login
      </button>

      <button type="button" id="btnLoginLoading" style="display: none;" disabled
        class="w-full py-2 bg-red-400 text-white rounded-md flex items-center justify-center">
        <svg class="animate-spin h-5 w-5 mr-2" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.4 0 0 5.4 0 12h4z" />
        </svg>
        Loading...
      </button>

      <p class="text-sm text-center mt-4">
        Belum punya akun?
        <a href="{{ url('register') }}" class="text-red-500 font-semibold hover:underline">Registrasi</a>
      </p>
      
    </form>
  </div>

  <!-- Script Login -->
  
  <script>
  function showPassword(show) {
    const input = document.getElementById("password");
    input.type = show ? "text" : "password";
  }
    const formLogin = document.getElementById("formLogin");

    formLogin.onsubmit = (e) => {
      e.preventDefault();

      const formData = new FormData(formLogin);
      document.getElementById("btnLogin").style.display = "none";
      document.getElementById("btnLoginLoading").style.display = "flex";

      axios.post('/loginProses', formData)
        .then(res => {
          if (res.data.responCode == 1) {
            Swal.fire({
              icon: 'success',
              title: 'Login Berhasil',
              text: 'Mengalihkan ke dashboard...',
              timer: 1500,
              showConfirmButton: false
            });
            setTimeout(() => location.reload(), 1500);
          } else {
            Swal.fire({
              icon: 'warning',
              title: 'Login Gagal',
              text: res.data.respon
            });
          }
        })
        .catch(err => console.error(err))
        .finally(() => {
          document.getElementById("btnLogin").style.display = "block";
          document.getElementById("btnLoginLoading").style.display = "none";
        });
    }
  </script>

</body>

</html>
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

    <!-- Select2 CSS -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" /> -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.7/dist/sweetalert2.all.min.js"></script>

    <!-- Favicons -->
     <link href="{{ url('ilanding/assets/img/pandu3.png') }}" rel="icon">
     <link href="{{ url('ilanding/assets/img/pandu3.png') }}" rel="apple-touch-icon">


    <style>
        .select2-container .select2-selection--single {
            height: calc(2.25rem + 15px);
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
        }
    </style>

    <title>Register | PANDU</title>
</head>

<body class="min-h-screen bg-gradient-to-br from-[#fce5e9] to-[#f7d6e6] flex items-center justify-center px-4 py-8">

    <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-4xl w-full">
        <div class="text-center mb-6">
            <img src="{{ url('ilanding/assets/img/pandu2.png') }}" alt="Logo PANDU" class="mx-auto mb-2" style="height: 80px;">
            <h3 class="text-2xl font-bold text-gray-800">Register</h3>
            <p class="text-sm text-gray-500">Silakan isi data dengan benar untuk membuat akun</p>
        </div>

        <form id="formRegister" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kolom Kiri -->
                <div class="space-y-4">
                    <div>
                        <label class="font-semibold text-gray-700">Nama <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Nama" required>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-700">Email <span class="text-red-500">*</span></label>
                        <input type="email" value="{{ session('user_otp')->no_wa }}" readonly name="email" id="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-700">Tempat Lahir <span class="text-red-500">*</span></label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" placeholder="Tempat Lahir" required>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-700">Jenis Kelamin <span class="text-red-500">*</span></label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option>Laki-laki</option>
                            <option>Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-700">Status Pegawai <span class="text-red-500">*</span></label>
                        <select onchange="pilihStatus()" name="status_pegawai" id="status_pegawai" class="form-control" required>
                            <option value="">PILIH STATUS</option>
                            <option>PNS</option>
                            <option>PPPK</option>
                            {{-- <option value="Honorer">Non ASN</option> --}}
                        </select>
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="space-y-4">
                    <div>
                        <label class="font-semibold text-gray-700">NIK <span class="text-red-500">*</span></label>
                        <input type="number" name="nik" id="nik" class="form-control" placeholder="NIK" required>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-700">
                            Password  <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                          <input type="password" name="password" id="password" class="form-control pr-10" placeholder="Password" required>
                          <span id="passwordValidIcon" class="absolute right-10 top-1/2 transform -translate-y-1/2 text-green-600 hidden">✔️</span>
                        
                          <button type="button"
                            onmousedown="showPassword(true)"
                            onmouseup="showPassword(false)"
                            onmouseleave="showPassword(false)"
                            class="absolute right-2 top-0 bottom-0 my-auto h-full flex items-center text-gray-700 ">
                            <!-- Ikon mata -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                              <path d="M10 3C5 3 1.73 7.11 1 10c.73 2.89 4 7 9 7s8.27-4.11 9-7c-.73-2.89-4-7-9-7zm0 12c-2.76 0-5-2.24-5-5s2.24-5 
                                5-5 5 2.24 5 5-2.24 5-5 5zm0-8a3 3 0 100 6 3 3 0 000-6z"/>
                            </svg>
                          </button>
                        </div>

                        <small id="passwordHelp" class="text-gray-500 text-sm">
                            Password minimal 8 karakter harus mengandung huruf kapital, huruf kecil, dan angka.
                        </small>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-700">Tanggal Lahir <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required>
                    </div>
                    {{-- OLD SCRIPT  --}}
                    {{-- <div>
                        <label class="font-semibold text-gray-700">No WA <span class="text-red-500">*</span></label>
                        <input type="number" name="no_wa" id="no_wa" class="form-control bg-gray-100" placeholder="No Whatsapp"
                            readonly value="{{ session('user_otp')->no_wa }}" required>
                    </div> --}}

                    {{-- NEW SCRIPT  --}}
                    <div>
                        <label class="font-semibold text-gray-700">No WA <span class="text-red-500">*</span></label>
                        <input type="number" name="no_wa" id="no_wa" class="form-control bg-gray-100" placeholder="No Whatsapp" required>
                    </div>
                    <div id="nip_form"></div>
                </div>
            </div>

            <div>
                <label class="font-semibold text-gray-700">Daerah (kecamatan) <span class="text-red-500">*</span></label>
                <select name="district_id" id="select2-ajax" class="form-control w-full" required>
                    <option value="">Pilih Data</option>
                </select>
            </div>

            <div>
                <label class="font-semibold text-gray-700">Alamat <span class="text-red-500">*</span></label>
                <textarea name="alamat" id="alamat" class="form-control" rows="4" placeholder="Alamat" required></textarea>
            </div>

            <div class="text-center space-y-3">
                <button type="submit" id="btnLogin" class="w-full py-2 px-4 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600">
                    Sign Up
                </button>

                <button style="display: none;" id="btnLoginLoading"
                    class="w-full py-2 px-4 bg-blue-500 text-white font-semibold rounded-lg flex justify-center items-center" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </button>

                <p class="text-sm text-gray-600">Have an account? <a href="{{ url('login') }}" class="text-red-600 font-semibold hover:underline">Login</a></p>
            </div>
        </form>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.7/dist/sweetalert2.all.min.js"></script>
    <!-- Select2 JS -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        function showPassword(show) {
        const passwordInput = document.getElementById('password');
        passwordInput.type = show ? 'text' : 'password';
      }
    // Validasi Password saat Input
        const passwordInput = document.getElementById('password');
        const passwordIcon = document.getElementById('passwordValidIcon');
    
        passwordInput.addEventListener('input', function () {
            const value = passwordInput.value;
    
            const isValid =
                value.length >= 8 &&
                /[a-z]/.test(value) &&
                /[A-Z]/.test(value) &&
                /\d/.test(value);
    
            if (isValid) {
                passwordIcon.classList.remove('hidden');
            } else {
                passwordIcon.classList.add('hidden');
            }
        });
    
        // Fungsi Validasi Detail Password
        function getPasswordValidationMessage(password) {
            let messages = [];
    
            if (password.length < 8) {
                messages.push("*minimal 8 karakter");
            }
            if (!/[A-Z]/.test(password)) {
                messages.push("*huruf besar");
            }
            if (!/[a-z]/.test(password)) {
                messages.push("*huruf kecil");
            }
            if (!/\d/.test(password)) {
                messages.push("*angka");
            }
    
            return messages;
        }
    
        // Form Submit
        const formRegister = document.getElementById('formRegister');
    
        formRegister.onsubmit = (e) => {
            e.preventDefault();
    
            const password = document.getElementById('password').value;
            const missing = getPasswordValidationMessage(password);
    
            if (missing.length > 0) {
            const messageList = `<ul style="text-align: center;">${missing.map(msg => `<li>${msg}</li>`).join('')}</ul>`;
    
            Swal.fire({
                icon: 'warning',
                title: 'Password tidak valid',
                html: `Password harus mengandung:${messageList}`,
            });
            return;
            }
    
            const formData = new FormData(formRegister);
    
            axios({
                method: 'post',
                url: '/registerProses',
                data: formData,
            })
                .then(function (res) {
                    if (res.data.responCode == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil Mendaftar',
                            text: 'Data anda berhasil diregistrasi, anda bisa menggunakan NIP dan password untuk login',
                            timer: 1000,
                            showConfirmButton: false,
                        });
    
                        setTimeout(() => {
                            window.location.href = '/dashboard';
                        }, 1000);
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Ada kesalahan',
                            text: `${res.data.respon}`,
                        });
                    }
                })
                .catch(function (res) {
                    console.log(res);
                })
                .then(function () {
                    document.getElementById(`btnLogin`).style.display = "block";
                    document.getElementById(`btnLoginLoading`).style.display = "none";
                });
        };
    </script>
    
    <!-- Script Status Pegawai -->
    <script>
        function pilihStatus() {
            var dok = document.getElementById('status_pegawai').value;
    
            if (dok == 'Honorer') {
                document.getElementById('nip_form').innerHTML = ``;
            } else {
                document.getElementById('nip_form').innerHTML = `
                    <label>NIP <sup class="text-danger">*</sup></label>
                    <input type="number" name="nip" class="form-control" id="nip" placeholder="NIP" value="" required>
                `;
            }
        }
    </script>

<!-- Script Select2 -->
<script>
    $(document).ready(function () {
        $('#select2-ajax').select2({
            ajax: {
                url: '/search-district',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return { q: params.term };
                },
                processResults: function (data) {
                    return {
                        results: data.map(item => ({
                            id: item.id,
                            text: item.name + ', ' + item.regensi_name + ', ' + item.provinsi_name
                        }))
                    };
                }
            },
            placeholder: "Cari Data...",
            minimumInputLength: 2
        });
    });
</script>
</body>

</html>
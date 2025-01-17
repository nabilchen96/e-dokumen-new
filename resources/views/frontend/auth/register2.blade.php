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

    <!-- Favicons -->
    <link href="{{ url('ilanding/logo.png') }}" rel="icon">
    <link href="{{ url('ilanding/logo.png') }}" rel="apple-touch-icon">


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

    <title>APLIKASI PENDATAAN NON ASN</title>
</head>

<body>


    <div class="d-lg-flex half" style="height: 125vh !important;">
        <div class="bg order-1 order-md-2" style="background-image: url('natural.png');"></div>
        <div class="contents order-2 order-md-1">

            <div class="container">
                <div class="row align-items-center justify-content-center" style="height: 125vh !important;">
                    <div class="col-md-9">
                        <h3>Register to <br><strong>APLIKASI PENDATAAN MANDIRI  TENAGA NON ASN</strong></h3>
                        <br>
                        <form id="formRegister">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Nama <sup class="text-danger">*</sup></label>
                                        <input type="text" name="name" class="form-control" id="name" placeholder="Nama"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label>Email <sup class="text-danger">*</sup></label>
                                        <input type="email" name="email" class="form-control" id="email"
                                            placeholder="Email" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Tempat Lahir <sup class="text-danger">*</sup></label>
                                        <input type="text" name="tempat_lahir" class="form-control" id="tempat_lahir"
                                            placeholder="Tempat Lahir" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Jenis Kelamin <sup class="text-danger">*</sup></label>
                                        <select name="jenis_kelamin" class="form-control" id="jenis_kelamin" required>
                                            <option>Laki-laki</option>
                                            <option>Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Status Pegawai <sup class="text-danger">*</sup></label>
                                        <select onchange="pilihStatus()" name="status_pegawai" class="form-control" id="status_pegawai" required>
                                            <option value="">PILIH STATUS</option>
                                            <option>PNS</option>
                                            <option>P3K</option>
                                            <option value="Honorer">Non ASN</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>NIK<sup class="text-danger">*</sup></label>
                                        <input type="number" name="nik" class="form-control" id="nik" placeholder="NIK"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label>Password <sup class="text-danger">*</sup></label>
                                        <input type="password" name="password" class="form-control" id="password"
                                            placeholder="Password" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Tanggal Lahir <sup class="text-danger">*</sup></label>
                                        <input type="date" name="tanggal_lahir" class="form-control" id="tanggal_lahir"
                                            placeholder="Tanggal Lahir" required>
                                    </div>
                                    <div class="form-group">
                                        <label>No WA <sup class="text-danger">*</sup></label>
                                        <input type="number" name="no_wa" class="form-control" id="no_wa"
                                            placeholder="No Whatsapp" readonly value="{{ session('user_otp')->no_wa }}"
                                            required>
                                    </div>
                                    <div id="nip_form" class="form-group">
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Daerah <sup class="text-danger">*</sup></label>
                                <select class="form-control" style="height: 58px !important; width: 100%;" name="district_id" id="select2-ajax"
                                    required>
                                    <option value="">Pilih Data</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Alamat <sup class="text-danger">*</sup></label>
                                <textarea name="alamat" class="form-control" id="alamat" cols="10" rows="10"
                                    placeholder="Alamat" required></textarea>
                            </div>
                            <div class="d-grid">
                                <button type="submit" id="btnLogin" class="btn btn-primary btn-lg btn-block">Sign
                                    Up</button>

                                <button style="display: none; background: #0d6efd;" id="btnLoginLoading"
                                    class="btn btn-info btn-moodle text-white btn-lg btn-block" type="button" disabled>
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>

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
    <!-- Select2 JS -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script>

        function pilihStatus(){

            var dok = document.getElementById('status_pegawai').value

            console.log(dok);
            

            if(dok == 'Honorer'){

                document.getElementById('nip_form').innerHTML = ``

            }else{

                document.getElementById('nip_form').innerHTML = `
                    <label>NIP <sup class="text-danger">*</sup></label>
                    <input type="number" name="nip" class="form-control" id="nip"
                        placeholder="NIP" value=""
                        required>
                `
            }

        }

        formRegister.onsubmit = (e) => {

            e.preventDefault();

            const formData = new FormData(formRegister);

            axios({
                method: 'post',
                url: '/registerProses',
                data: formData,
            })
                .then(function (res) {
                    //handle success
                    if (res.data.responCode == 1) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil Mendaftar',
                            text: 'Data anda berhasil diregistrasi, anda bisa menggunakan nip dan password untuk login',
                            timer: 1000,
                            showConfirmButton: false,
                            // text: res.data.respon
                        })

                        setTimeout(() => {
                            window.location.href = '/dashboard';
                        }, 1000);

                    } else {

                        Swal.fire({
                            icon: 'warning',
                            title: 'Ada kesalahan',
                            text: `${res.data.respon}`,
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
                            results: data.map(item => ({ id: item.id, text: item.name + ', ' + item.regensi_name + ', ' + item.provinsi_name }))
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
@extends('backend.app')
@push('style')
    <style>
        #myTable_filter input {
            height: 29.67px !important;
        }

        #myTable_length select {
            height: 29.67px !important;
        }

        .btn {
            border-radius: 50px !important;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #9e9e9e21 !important;
        }

        td,
        th {
            font-size: 13.5px !important;
        }

        #map {
            width: 100%;
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container .select2-selection--single {
            height: calc(2.25rem + 2px);
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
        }
    </style>
@endpush
@section('content')
<div class="row" style="margin-top: -200px;">
    <div class="col-md-12">
        <div class="row">
            <div class="col-12 col-xl-8 mb-xl-0">
                <h3 class="font-weight-bold">Data Profil</h3>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 mt-4">
        <div class="card w-100">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped" style="width: 100%;">
                        <thead class="bg-info text-white">
                            <tr>
                                <th width="5%">No</th>
                                <th>Name</th>
                                <th>NIP/EMAIL/WA</th>
                                <th>Jenis Kelamin/Tempat, Tgl Lahir</th>
                                <th>Alamat/Daerah</th>
                                <th>Peta</th>
                                <th width="5%"></th>
                                <!-- <th width="5%"></th> -->
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form">
                <div class="modal-header p-3">
                    <h5 class="modal-title m-2" id="exampleModalLabel">User Form</h5>
                </div>
                <div class="modal-body">
                    <div id="respon_error" class="text-danger mb-4"></div>
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="id_user" id="id_user">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Nama <sup class="text-danger">*</sup></label>
                                <input type="text" name="name" class="form-control" id="name" placeholder="Nama"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>Email <sup class="text-danger">*</sup></label>
                                <input type="email" name="email" class="form-control" id="email" placeholder="Email"
                                    required>
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
                                <label>Golongan/Pangkat <sup class="text-danger">*</sup></label>
                                <select name="pangkat" class="form-control" id="pangkat" required>
                                    <option>I/a - Juru Muda</option>
                                    <option>I/b - Juru Muda Tingkat I</option>
                                    <option>I/c - Juru</option>
                                    <option>I/d - Juru Tingkat I</option>
                                    <option>II/a - Pengatur Muda</option>
                                    <option>II/b - Pengatur Muda Tingkat I</option>
                                    <option>II/c - Pengatur</option>
                                    <option>II/d - Pengatur Tingkat I</option>
                                    <option>III/a - Penata Muda</option>
                                    <option>III/b - Penata Muda Tingkat I</option>
                                    <option>III/c - Penata</option>
                                    <option>III/d - Penata Tingkat I</option>
                                    <option>IV/a - Pembina</option>
                                    <option>IV/b - Pembina Tingkat I - Pembina Tk.I</option>
                                    <option>IV/c - Pembina Utama Muda</option>
                                    <option>IV/d - Pembina Utama Madya</option>
                                    <option>IV/e - Pembina Utama</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>NIP <sup class="text-danger">*</sup></label>
                                <input type="number" name="nip" class="form-control" id="nip" placeholder="NIP"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" id="password"
                                    placeholder="Password">
                            </div>
                            <div class="form-group">
                                <label>Tanggal Lahir <sup class="text-danger">*</sup></label>
                                <input type="date" name="tanggal_lahir" class="form-control" id="tanggal_lahir"
                                    placeholder="Tanggal Lahir" required>
                            </div>
                            <div class="form-group">
                                <label>Status Pegawai <sup class="text-danger">*</sup></label>
                                <select name="status_pegawai" class="form-control" id="status_pegawai" required>
                                    <option>PNS</option>
                                    <option>P3K</option>
                                    <option>Honorer</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Jabatan <sup class="text-danger">*</sup></label>
                                <input type="text" name="jabatan" class="form-control" id="jabatan" placeholder="Jabatan"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Daerah <sup class="text-danger">*</sup></label>
                        <select class="form-control" style="width: 100%;" name="district_id" id="select2-ajax" required>
                            <option value="">Pilih Data</option>
                        </select>
                        <span class="text-danger" style="font-size: 12px;">*Daerah yang dipilih sebelumnya adalah <i
                                id="district"></i></span>
                    </div>
                    <div class="form-group">
                        <label>Alamat <sup class="text-danger">*</sup></label>
                        <textarea name="alamat" class="form-control" id="alamat" cols="10" rows="10"
                            placeholder="Alamat" required></textarea>
                    </div>

                </div>
                <div class="modal-footer p-3">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                    <button id="tombol_kirim" class="btn btn-primary btn-sm">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalpeta" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Peta Lokasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="map" style="aspect-ratio: 2.5/1 !important; width: 100%;"></div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            getData()
        })

        function getData() {
            $("#myTable").DataTable({
                "ordering": false,
                ajax: '/data-profil',
                processing: true,
                'language': {
                    'loadingRecords': '&nbsp;',
                    'processing': 'Loading...'
                },
                columns: [{
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    render: function (data, type, row, meta) {
                        return `<b>Name</b>: ${row.name} <br> 
                                <b>Role</b>: ${row.role} <br>
                                <b>Status</b>: ${row.status_pegawai} <br>
                                ${row.pangkat ?? `IV/c - Pembina Utama Muda`}`;
                    }
                },
                {
                    render: function (data, type, row, meta) {
                        return `<b>NIP</b>: ${row.nip} <br> 
                                <b>Email</b>: ${row.email} <br> 
                                <b>Whatsapp</b>: ${row.no_wa} <br>
                                <b>Jabatan</b>: ${row.jabatan ?? `Guru Ahli Madya`}`;
                    }
                },
                {
                    render: function (data, type, row, meta) {
                        return `<b>Jenis Kelamin</b>: ${row.jenis_kelamin} <br> 
                                <b>Tempat lahir</b>: ${row.tempat_lahir} <br> 
                                <b>Tanggal Lahir</b>: ${row.tanggal_lahir}`;
                    }
                },
                {
                    render: function (data, type, row, meta) {
                        return `<b>Alamat</b>: ${row.alamat} <br> 
                                <b>Daerah</b>: ${row.district} <br>`;
                    }
                },
                {
                    render: function (data, type, row, meta) {
                        return `<a data-toggle="modal" data-target="#modalpeta"
                                data-lat="${row.latitude}" 
                                data-lng="${row.longitude}" 
                                href="javascript:void(0)">
                                <i style="font-size: 1.5rem;" class="text-info bi bi-geo-alt"></i>
                        </a>`;
                    }
                },
                {
                    render: function (data, type, row, meta) {
                        return `<a data-toggle="modal" data-target="#modal"
                            data-bs-id=` + (row.id) + ` href="javascript:void(0)">
                            <i style="font-size: 1.5rem;" class="text-success bi bi-grid"></i>
                        </a>`
                    }
                },
                    // {
                    //     render: function (data, type, row, meta) {
                    //         return `<a href="javascript:void(0)" onclick="hapusData(` + (row
                    //             .id) + `)">
                    //                                         <i style="font-size: 1.5rem;" class="text-danger bi bi-trash"></i>
                    //                                     </a>`
                    //     }
                    // },
                ]
            })
        }

        var map;
        var marker;

        $('#modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('bs-id') // Extract info from data-* attributes
            var cok = $("#myTable").DataTable().rows().data().toArray()

            // map.invalidateSize();

            let cokData = cok.filter((dt) => {
                return dt.id == recipient;
            })

            document.getElementById("form").reset();
            document.getElementById('id').value = ''
            $('.error').empty();

            if (recipient) {
                var modal = $(this)
                modal.find('#id').val(cokData[0].id)
                modal.find('#id_user').val(cokData[0].id_user)
                modal.find('#email').val(cokData[0].email)
                modal.find('#name').val(cokData[0].name)
                modal.find('#jenis_kelamin').val(cokData[0].jenis_kelamin)
                modal.find('#tempat_lahir').val(cokData[0].tempat_lahir)
                modal.find('#tanggal_lahir').val(cokData[0].tanggal_lahir)
                modal.find('#nip').val(cokData[0].nip)
                modal.find('#alamat').val(cokData[0].alamat)
                modal.find('#status_pegawai').val(cokData[0].status_pegawai)
                modal.find('#pangkat').val(cokData[0].pangkat)
                modal.find('#jabatan').val(cokData[0].jabatan)
                // modal.find('#district').val(cokData[0].district)
                document.getElementById('district').innerHTML = cokData[0].district
            }
        })

        $('#modalpeta').on('shown.bs.modal', function (event) {
            const button = $(event.relatedTarget); // Tombol yang men-trigger modal
            const latitude = button.data('lat');  // Ambil latitude dari atribut data
            const longitude = button.data('lng'); // Ambil longitude dari atribut data


            if (!map) {
                map = L.map('map').setView([latitude, longitude], 13);

                // Tambahkan layer peta dasar (OpenStreetMap)
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                // Tambahkan marker pada peta
                L.marker([latitude, longitude]).addTo(map)
                    .bindPopup(`<b>Lokasi:</b><br>Lat: ${latitude}, Lng: ${longitude}`)
                    .openPopup();
            } else {
                // Memastikan peta diperbarui ukurannya saat modal dibuka
                setTimeout(() => {
                    map.invalidateSize();
                }, 100);
            }
        });

        form.onsubmit = (e) => {

            let formData = new FormData(form);

            e.preventDefault();

            document.getElementById("tombol_kirim").disabled = true;

            axios({
                method: 'post',
                url: formData.get('id') == '' ? '/store-profil' : '/update-profil',
                data: formData,
            })
                .then(function (res) {
                    //handle success         
                    if (res.data.responCode == 1) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: res.data.respon,
                            timer: 3000,
                            showConfirmButton: false
                        })

                        location.reload('/profil')

                    } else {
                        //respon 
                        let respon_error = ``
                        Object.entries(res.data.respon).forEach(([field, messages]) => {
                            messages.forEach(message => {
                                respon_error += `<li>${message}</li>`;
                            });
                        });

                        document.getElementById('respon_error').innerHTML = respon_error
                    }

                    document.getElementById("tombol_kirim").disabled = false;
                })
                .catch(function (res) {
                    document.getElementById("tombol_kirim").disabled = false;
                    //handle error
                    console.log(res);
                });
        }

        hapusData = (id) => {
            Swal.fire({
                title: "Yakin hapus data?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonColor: '#3085d6',
                cancelButtonText: "Batal"

            }).then((result) => {

                if (result.value) {
                    axios.post('/delete-user', {
                        id
                    })
                        .then((response) => {
                            if (response.data.responCode == 1) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    timer: 2000,
                                    showConfirmButton: false
                                })

                                $('#myTable').DataTable().clear().destroy();
                                getData();

                            } else {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Gagal...',
                                    text: response.data.respon,
                                })
                            }
                        }, (error) => {
                            console.log(error);
                        });
                }

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
@endpush
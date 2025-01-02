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
            white-space: nowrap !important;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
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
                <h3 class="font-weight-bold">Data SKPD</h3>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 mt-4">
        <div class="card w-100">
            <div class="card-body">
                <button type="button" class="btn btn-primary btn-sm mb-4" data-toggle="modal" data-target="#modalpeta">
                    Tambah
                </button>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped" style="width: 100%;">
                        <thead class="bg-info text-white">
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama SKPD</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th width="10%">Alamat</th>
                                <!-- <th width="5%"></th> -->
                                <th width="5%"></th>
                                <th width="5%"></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->

<div class="modal fade" id="modalpeta" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form">
                <div class="modal-header">
                    <h5 class="modal-title">SKPD Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div id="respon_error" class="text-danger mb-4"></div>
                            <input type="hidden" name="id" id="id">
                            <div class="form-group">
                                <label>Nama SKPD <sup class="text-danger">*</sup></label>
                                <input name="nama_skpd" id="nama_skpd" type="text" placeholder="Nama SKPD"
                                    class="form-control form-control-sm" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input name="email" id="email" type="email" placeholder="Email"
                                    class="form-control form-control-sm">
                            </div>
                            <div class="form-group">
                                <label>Telepon</label>
                                <input name="telepon" id="telepon" type="number" placeholder="Telepon"
                                    class="form-control form-control-sm">
                            </div>
                            <div class="form-group">
                                <label>Latitude</label>
                                <input name="latitude" id="latitude" type="text" placeholder="Latitude"
                                    class="form-control form-control-sm" required readonly>
                            </div>
                            <div class="form-group">
                                <label>Longitude</label>
                                <input name="longitude" id="longitude" type="text" placeholder="Longitude"
                                    class="form-control form-control-sm" required readonly>
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea rows="5" name="alamat" id="alamat" class="form-control" required placeholder="Alamat"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label>Pilih Latitude dan Longitude di Peta</label>
                            <div id="map" style="aspect-ratio: 1/1 !important; width: 100%;"></div>
                        </div>
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
@endsection
@push('script')
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            getData()
        })

        var map;  // Variabel untuk menyimpan instansi peta
        var marker;  // Variabel untuk menyimpan marker yang dapat dipindah-pindah

        function getData() {
            $("#myTable").DataTable({
                "ordering": false,
                ajax: '/data-skpd',
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
                        return `${row.nama_skpd}<br> <b>Email:</b> ${row.email}, <b>Telepon:</b> ${row.telepon}`
                    }
                },
                {
                    data: "latitude"
                },
                {
                    data: "longitude"
                },
                {
                    render: function (data, type, row, meta) {
                        return `${row.alamat}`
                    }
                },

                {
                    render: function (data, type, row, meta) {
                        return `<a data-toggle="modal" data-target="#modalpeta"
                            data-bs-id=` + (row.id) + ` href="javascript:void(0)">
                            <i style="font-size: 1.5rem;" class="text-success bi bi-grid"></i>
                        </a>`
                    }
                },
                {
                    render: function (data, type, row, meta) {
                        return `<a href="javascript:void(0)" onclick="hapusData(` + (row
                            .id) + `)">
                            <i style="font-size: 1.5rem;" class="text-danger bi bi-trash"></i>
                        </a>`
                    }
                },
                ]
            })
        }

        $('#modalpeta').on('shown.bs.modal', function (event) {
            // Reset konten peta hanya jika peta belum ada
            if (!map) {
                // Inisialisasi peta hanya sekali
                map = L.map('map').setView([-2.548926, 118.014863], 5);

                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map);

                // Event listener untuk klik peta
                map.on('click', function (e) {
                    const { lat, lng } = e.latlng;

                    // Menampilkan latitude dan longitude pada form
                    document.getElementById('latitude').value = lat.toFixed(6);
                    document.getElementById('longitude').value = lng.toFixed(6);

                    // Jika marker belum ada, buat satu marker
                    if (!marker) {
                        marker = L.marker([lat, lng]).addTo(map)
                            .bindPopup(`Latitude: ${lat.toFixed(6)}<br>Longitude: ${lng.toFixed(6)}`)
                            .openPopup();
                    } else {
                        // Jika marker sudah ada, pindahkan marker ke posisi baru
                        marker.setLatLng([lat, lng])
                            .bindPopup(`Latitude: ${lat.toFixed(6)}<br>Longitude: ${lng.toFixed(6)}`)
                            .openPopup();
                    }
                });
            } else {
                // Memastikan peta diperbarui ukurannya saat modal dibuka
                setTimeout(() => {
                    map.invalidateSize();
                }, 100);
            }

            // Reset form jika modal dibuka untuk data baru
            var button = $(event.relatedTarget);
            var recipient = button.data('bs-id');
            var cok = $("#myTable").DataTable().rows().data().toArray();

            let cokData = cok.filter((dt) => {
                return dt.id == recipient;
            });

            document.getElementById("form").reset();
            document.getElementById('id').value = '';
            $('.error').empty();

            if (recipient) {
                var modal = $(this);
                modal.find('#id').val(cokData[0].id);
                modal.find('#nama_skpd').val(cokData[0].nama_skpd);
                modal.find('#telepon').val(cokData[0].telepon);
                modal.find('#email').val(cokData[0].email);
                modal.find('#alamat').val(cokData[0].alamat);
                modal.find('#latitude').val(cokData[0].latitude);
                modal.find('#longitude').val(cokData[0].longitude);

                // // Jika data koordinat ada, atur posisi peta
                if (cokData[0].latitude && cokData[0].longitude) {
                    var lat = cokData[0].latitude;
                    var lng = cokData[0].longitude;
                    map.setView([lat, lng], 13); // Ubah posisi peta ke koordinat baru
                    // Jika marker belum ada, tambahkan marker
                    if (!marker) {
                        marker = L.marker([lat, lng]).addTo(map)
                            .bindPopup(`Latitude: ${lat.toFixed(6)}<br>Longitude: ${lng.toFixed(6)}`)
                            .openPopup();
                    } else {
                        // Jika marker sudah ada, pindahkan marker ke posisi baru
                        marker.setLatLng([lat, lng])
                            .bindPopup(`Latitude: ${lat.toFixed(6)}<br>Longitude: ${lng.toFixed(6)}`)
                            .openPopup();
                    }
                }
            }
        });


        form.onsubmit = (e) => {

            let formData = new FormData(form);

            e.preventDefault();

            document.getElementById("tombol_kirim").disabled = true;

            axios({
                method: 'post',
                url: formData.get('id') == '' ? '/store-skpd' : '/update-skpd',
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

                        location.reload('/skpd')

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
                    axios.post('/delete-skpd', {
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
@endpush
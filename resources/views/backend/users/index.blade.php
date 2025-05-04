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

        /* Mengatur ukuran dan margin panah sorting di DataTables */
        table.dataTable thead .sorting::after,
        table.dataTable thead .sorting_asc::after,
        table.dataTable thead .sorting_desc::after {
            margin-bottom: 5px !important;
            content: "▲" !important;
            top: 7px !important;
        }

        table.dataTable thead .sorting::before,
        table.dataTable thead .sorting_asc::before,
        table.dataTable thead .sorting_desc::before {
            margin-top: -5px !important;
            content: "▼" !important;
            bottom: 7px !important;
        }
    </style>
@endpush
@section('content')
<div class="row" style="margin-top: -200px;">
    <div class="col-md-12">
        <div class="row">
            <div class="col-12 col-xl-8 mb-xl-0">
                <h3 class="font-weight-bold">Data User</h3>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 mt-4">
        <div class="card w-100">
            <div class="card-body">
                <button type="button" class="btn btn-primary btn-sm mb-4" data-toggle="modal" data-target="#modal">
                    Tambah
                </button>
                <a class="btn btn-success btn-sm mb-4" href="{{ url('export-excel-user') }}" data-target="#modalexport">
                    <i class="bi bi-file-earmark-excel"></i> Export
                </a>
                <button type="button" class="btn btn-success btn-sm mb-4" data-toggle="modal"
                    data-target="#modalimport">
                    <i class="bi bi-file-earmark-excel"></i> Import
                </button>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped" style="width: 100%;">
                        <thead class="bg-info text-white">
                            <tr>
                                <th width="5%">No</th>
                                <th>Name</th>
                                <th>Email / No. WA</th>
                                <th>Role</th>
                                <th>Status Pegawai</th>
                                <th>Tgl Dibuat</th>
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
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input name="email" id="email" type="email" placeholder="email"
                            class="form-control form-control-sm" aria-describedby="emailHelp" required>
                        <span class="text-danger error" style="font-size: 12px;" id="email_alert"></span>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama Lengkap</label>
                        <input name="name" id="name" type="text" placeholder="Nama Lengkap"
                            class="form-control form-control-sm" aria-describedby="emailHelp" required>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input name="password" id="password" type="password" placeholder="Password"
                            class="form-control form-control-sm">
                        <span class="text-danger error" style="font-size: 12px;" id="password_alert"></span>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Role</label>
                        <select name="role" class="form-control" id="role" required>
                            <option value="">PILIH ROLE</option>
                            @if (Auth::user()->role == 'Admin')                            
                                <option value="Admin">Admin</option>
                            @endif
                            <option value="SKPD">SKPD</option>
                            <option value="Pegawai">Pegawai</option>
                            <option>OPD</option>
                            <option>Staff BKPSDM</option>
                            <option>Kabid BKPSDM</option>
                            <option>Sekretaris BKPSDM</option>
                            <option>Kepala BKPSDM</option>
                            <option>Bendahara Gaji DPKAD</option>
                            <option>Inspektorat</option>
                        </select>
                    </div>
                    <div class="form-group" id="status_pegawai_group" style="display: none;">
                        <label for="status_pegawai">Status Pegawai</label>
                        <select name="status_pegawai" class="form-control" id="status_pegawai">
                            <option>PNS</option>
                            <option>P3K</option>
                            <option>Honorer</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="no_wa">No Whatsapp</label>
                        <input name="no_wa" id="no_wa" type="text" placeholder="082777120"
                            class="form-control form-control-sm" aria-describedby="emailHelp" required>
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

<!-- Modal Import-->
<div class="modal fade" id="modalimport" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="importForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-header p-3">
                    <h5 class="modal-title m-2" id="exampleModalLabel">User Import Form</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Import Excel <sup class="text-danger">*</sup> </label>
                        <input name="file" id="file" type="file" class="form-control form-control-sm mb-2" required>
                        <span>*Unduh format import user <a href="{{ asset('template_user_import.xlsx') }}">Template
                                Import User</a></span>
                    </div>

                </div>
                <div class="modal-footer p-3">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                    <button id="importButton" class="btn btn-primary btn-sm">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@push('script')
    <script>
        document.getElementById('importForm').addEventListener('submit', function (event) {
            event.preventDefault();  // Mencegah reload halaman
            let formData = new FormData(this);  // Mengambil data form

            axios.post('/import-excel-user', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then(response => {
                    const data = response.data;
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: `Data Berhasil Diimport: ${data.success_count}, Data Gagal Diimport: ${data.fail_count}`,
                        showConfirmButton: true
                    })

                    $("#modalimport").modal("hide");
                    $('#myTable').DataTable().clear().destroy();
                    getData()
                })
                .catch(error => {
                    if (error.response) {
                        document.getElementById('responseMessage').innerText =
                            'Terjadi kesalahan saat mengimpor data.';
                    }
                });
        });

    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            getData()
        })

        document.getElementById('role').addEventListener('change', function () {
            const role = this.value;
            const statusPegawaiGroup = document.getElementById('status_pegawai_group');

            if (role === 'Pegawai') {
                statusPegawaiGroup.style.display = 'block'; // Tampilkan field Status Pegawai
            } else {
                statusPegawaiGroup.style.display = 'none'; // Sembunyikan field Status Pegawai
            }
        });

        function getData() {
            $("#myTable").DataTable({
                "ordering": true,
                ajax: '/data-user',
                processing: true,
                'language': {
                    'loadingRecords': '&nbsp;',
                    'processing': 'Loading...'
                },
                columnDefs: [
                    { orderable: false, targets: [6, 7] } // Kolom ke-0 dan ke-2 tidak bisa di-sort
                ],
                columns: [{
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "name"
                },
                {
                    render: function (data, type, row, meta) {
                        return `${row.email} <br> WA: ${row.no_wa}`
                    }
                },
                {
                    data: 'role'
                },
                {
                    data: 'status_pegawai'
                },
                {
                    data: "created_at"
                },

                {
                    render: function (data, type, row, meta) {
                        return `<a data-toggle="modal" data-target="#modal"
                                    data-bs-id=` + (row.id) + ` href="javascript:void(0)">
                                    <i style="font-size: 1.5rem;" class="text-success bi bi-grid"></i>
                                </a>`
                    }
                },
                {
                    render: function (data, type, row, meta) {
                        return `<a href="javascript:void(0)" onclick="hapusData(` + (row.id) + `)">
                                    <i style="font-size: 1.5rem;" class="text-danger bi bi-trash"></i>
                                </a>`
                    }
                },
                ]
            })
        }

        $('#modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var recipient = button.data('bs-id'); // Extract info from data-* attributes
            var cok = $("#myTable").DataTable().rows().data().toArray();

            let cokData = cok.filter((dt) => {
                return dt.id == recipient;
            });

            const statusPegawaiGroup = document.getElementById('status_pegawai_group');
            document.getElementById("form").reset();
            document.getElementById('id').value = '';
            $('.error').empty();

            if (recipient) {
                // Edit Mode
                var modal = $(this);
                modal.find('#id').val(cokData[0].id);
                modal.find('#email').val(cokData[0].email);
                modal.find('#name').val(cokData[0].name);
                modal.find('#role').val(cokData[0].role);
                modal.find('#no_wa').val(cokData[0].no_wa);
                modal.find('#status_pegawai').val(cokData[0].status_pegawai);

                // Tampilkan Status Pegawai jika role adalah Pegawai
                if (cokData[0].role === 'Pegawai') {
                    statusPegawaiGroup.style.display = 'block';
                } else {
                    statusPegawaiGroup.style.display = 'none';
                }
            } else {
                // Tambah Mode
                statusPegawaiGroup.style.display = 'none'; // Sembunyikan Status Pegawai
            }
        });



        form.onsubmit = (e) => {

            let formData = new FormData(form);

            document.getElementById('respon_error').innerHTML = ``

            e.preventDefault();

            document.getElementById("tombol_kirim").disabled = true;

            axios({
                method: 'post',
                url: formData.get('id') == '' ? '/store-user' : '/update-user',
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

                        $("#modal").modal("hide");
                        $('#myTable').DataTable().clear().destroy();
                        getData()

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
@endpush
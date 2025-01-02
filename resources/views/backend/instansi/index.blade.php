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
    </style>
@endpush
@section('content')
<div class="row" style="margin-top: -200px;">
    <div class="col-md-12">
        <div class="row">
            <div class="col-12 col-xl-8 mb-xl-0">
                <h3 class="font-weight-bold">Data Instansi</h3>
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
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped" style="width: 100%;">
                        <thead class="bg-info text-white">
                            <tr>
                                <th width="5%">No</th>
                                <th>Logo</th>
                                <th>Kepala BKPSDM</th>
                                <th>Email/Website</th>
                                <th>Telp/Fax/Kode Pos</th>
                                <th>Status</th>
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
                    <h5 class="modal-title m-2" id="exampleModalLabel">Instansi Form</h5>
                </div>
                <div class="modal-body">
                    <div id="respon_error" class="text-danger mb-4"></div>
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label>Logo <sup class="text-danger">*</sup></label>
                        <input name="logo" id="logo" type="file" placeholder="Logo"
                            class="form-control form-control-sm">
                    </div>
                    <div class="form-group">
                        <label>Kepala BKPSDM <sup class="text-danger">*</sup></label>
                        @php
                            $profil = DB::table('profils')
                                ->join('users', 'users.id', '=', 'profils.id_user')
                                ->select(
                                    'users.name',
                                    'profils.*'
                                )
                                ->get();
                        @endphp
                        <select name="id_profil" id="id_profil" class="form-control" required>
                            <option value="">PILIH Kepala BKPSDM</option>
                            @foreach ($profil as $p)
                                <option value="{{ $p->id }}">{{ $p->name }} | NIP: {{ $p->nip }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kode Pos <sup class="text-danger">*</sup></label>
                        <input type="text" placeholder="Kode Pos" class="form-control" required name="kode_pos"
                            id="kode_pos">
                    </div>
                    <div class="form-group">
                        <label>Email Instansi <sup class="text-danger">*</sup></label>
                        <input type="email" placeholder="Email Instansi" class="form-control" required name="email"
                            id="email">
                    </div>
                    <div class="form-group">
                        <label>Website Instansi <sup class="text-danger">*</sup></label>
                        <input type="text" placeholder="Website Instansi" class="form-control" required name="website"
                            id="website">
                    </div>
                    <div class="form-group">
                        <label>Telepon/fax <sup class="text-danger">*</sup></label>
                        <input type="text" placeholder="Telepon/Fax Instansi" class="form-control" required
                            name="telp_fax" id="telp_fax">
                    </div>
                    <div class="form-group">
                        <label>Status <sup class="text-danger">*</sup></label>
                        <select name="status" id="status" class="form-control" required>
                            <option>Aktif</option>
                            <option>Tidak Aktif</option>
                        </select>
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            getData()
        })

        function getData() {
            $("#myTable").DataTable({
                "ordering": false,
                ajax: '/data-instansi',
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
                        return `<img src="/logo/${row.logo}" style="height: 100px !important; width: 80px; border-radius: 0;">`
                    }
                },
                {
                    render: function (data, type, row, meta) {
                        return `${row.name} <br> <b>${row.nip}</b>`
                    }
                },
                {
                    render: function (data, type, row, meta) {
                        return `<b><i class="bi bi-envelope"></i> Email</b>: ${row.email} <br> 
                                <b><i class="bi bi-globe"></i> Website</b>: ${row.website} <br>`
                    }
                },
                {
                    render: function (data, type, row, meta) {
                        return `<b><i class="bi bi-telephone"></i> Telp/Fax</b>: ${row.telp_fax} <br>
                                <b><i class="bi bi-envelope"></i> Kode Pos</b>: ${row.kode_pos}`
                    }
                },
                {
                    data: "status"
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
                        return `<a href="javascript:void(0)" onclick="hapusData(` + (row
                            .id) + `)">
                            <i style="font-size: 1.5rem;" class="text-danger bi bi-trash"></i>
                        </a>`
                    }
                },
                ]
            })
        }

        $('#modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('bs-id') // Extract info from data-* attributes
            var cok = $("#myTable").DataTable().rows().data().toArray()

            let cokData = cok.filter((dt) => {
                return dt.id == recipient;
            })

            document.getElementById("form").reset();
            document.getElementById('id').value = ''
            $('.error').empty();

            if (recipient) {
                var modal = $(this)
                modal.find('#id').val(cokData[0].id)
                modal.find('#id_profil').val(cokData[0].id_profil)
                modal.find('#status').val(cokData[0].status)
                modal.find('#kode_pos').val(cokData[0].kode_pos)
                modal.find('#email').val(cokData[0].email)
                modal.find('#website').val(cokData[0].website)
                modal.find('#telp_fax').val(cokData[0].telp_fax)
            }
        })

        form.onsubmit = (e) => {

            let formData = new FormData(form);

            e.preventDefault();

            document.getElementById("tombol_kirim").disabled = true;

            axios({
                method: 'post',
                url: formData.get('id') == '' ? '/store-instansi' : '/update-instansi',
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

                        location.reload('/instansi')

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
                    axios.post('/delete-instansi', {
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
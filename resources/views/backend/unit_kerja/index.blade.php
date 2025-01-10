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
                <h3 class="font-weight-bold">Data Unit Kerja</h3>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 mt-4">
        <div class="card w-100">
            <div class="card-body">
                @if (Auth::user()->role == 'Admin')
                    <button type="button" class="btn btn-primary btn-sm mb-4" data-toggle="modal" data-target="#modal">
                        Tambah
                    </button>
                    <a class="btn btn-success btn-sm mb-4" href="{{ url('export-excel-unit-kerja') }}"
                        data-target="#modalexport">
                        <i class="bi bi-file-earmark-excel"></i> Export
                    </a>
                    <button type="button" class="btn btn-success btn-sm mb-4" data-toggle="modal"
                        data-target="#modalimport">
                        <i class="bi bi-file-earmark-excel"></i> Import
                    </button>
                @endif

                <div class="table-responsive">
                    <table id="myTable" class="table table-striped" style="width: 100%;">
                        <thead class="bg-info text-white">
                            <tr>
                                <th width="5%">No</th>
                                <th>Unit Kerja</th>
                                <th>SKPD</th>
                                @if (Auth::user()->role == 'Admin')
                                    <th width="5%"></th>
                                    <th width="5%"></th>
                                @endif
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
                        <label>SKPD<sup class="text-danger">*</sup></label>
                        @php
                            $skpd = DB::table('skpds')->get();
                        @endphp
                        <select name="id_skpd" id="id_skpd" class="form-control" required>
                            <option value="">PILIH SKPD</option>
                            @foreach ($skpd as $p)
                                <option value="{{ $p->id }}">{{ $p->nama_skpd }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Unit Kerja <sup class="text-danger">*</sup></label>
                        <input type="text" placeholder="Unit Kerja" class="form-control" required name="unit_kerja"
                            id="unit_kerja">
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
                    <h5 class="modal-title m-2">Unit Kerja Import Form</h5>
                </div>
                <div id="responseMessage"></div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Import Excel <sup class="text-danger">*</sup> </label>
                        <input name="file" id="file" type="file" class="form-control form-control-sm mb-2" required>
                        <ul>
                            <li>
                                Unduh format import Unit Kerja
                                <a href="{{ url('export-template-unit-kerja') }}">Template Import Unit Kerja</a>
                            </li>
                            <li>
                                Daftar SKPD di dalam format import akan berubah saat ada update pada menu SKPD
                            </li>
                            <li>
                                Copy kolom yang memilik daftar SKPD pada format import untuk menambah data pada baris
                                selanjutnya
                            </li>
                        </ul>
                        <img src="{{ asset('instruksi_1.png') }}" width="100%" alt="">
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
        document.addEventListener('DOMContentLoaded', function () {
            getData()
        })

        function getData() {
            $("#myTable").DataTable({
                "ordering": true,
                ajax: '/data-unit-kerja',
                processing: true,
                'language': {
                    'loadingRecords': '&nbsp;',
                    'processing': 'Loading...'
                },
                @if (Auth::user()->role == 'Admin')
                    columnDefs: [
                        { orderable: false, targets: [3, 4] } // Kolom ke-0 dan ke-2 tidak bisa di-sort
                    ],
                @endif

                columns: [{
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    render: function (data, type, row, meta) {
                        return `${row.unit_kerja}`
                    }
                },
                {
                    render: function (data, type, row, meta) {
                        return `${row.nama_skpd}`
                    }
                },
                @if (Auth::user()->role == 'Admin')
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
                @endif

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
                modal.find('#id_skpd').val(cokData[0].id_skpd)
                modal.find('#unit_kerja').val(cokData[0].unit_kerja)
            }
        })

        form.onsubmit = (e) => {

            let formData = new FormData(form);

            e.preventDefault();

            document.getElementById("tombol_kirim").disabled = true;

            axios({
                method: 'post',
                url: formData.get('id') == '' ? '/store-unit-kerja' : '/update-unit-kerja',
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
                    axios.post('/delete-unit-kerja', {
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
        document.getElementById('importForm').addEventListener('submit', function (event) {
            event.preventDefault();  // Mencegah reload halaman
            let formData = new FormData(this);  // Mengambil data form

            document.getElementById('responseMessage').innerText = ``

            axios.post('/import-excel-unit-kerja', formData, {
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
@endpush
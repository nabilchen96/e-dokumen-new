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
                <h3 class="font-weight-bold">Data
                    {{ $jenis = DB::table('jenis_dokumens')->where('id', Request('jenis_dokumen'))->value('jenis_dokumen') }}
                </h3>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 mt-4">
        <div class="card w-100">
            <div class="card-body">
                @if (Auth::user()->role == 'Pegawai')
                    <button type="button" class="btn btn-primary btn-sm mb-4" data-toggle="modal" data-target="#modal">
                        Tambah
                    </button>
                @endif
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped" style="width: 100%;">
                        <thead class="bg-info text-white">
                            <tr>
                                <th width="5%">No</th>
                                <th>Pemilik</th>
                                <th>Jenis Dokumen</th>
                                <th>Tanggal Berlaku</th>
                                <th>Tanggal Upload</th>
                                <th>SKPD / Unit Kerja</th>
                                <th>Status</th>
                                <th width="5%">PDF</th>
                                <th width="5%">Edit</th>
                                <th width="5%">Hapus</th>
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
            <form id="updateStatusForm">
                @if (Auth::user()->role == 'Admin' || Auth::user()->role == 'SKPD' || Auth::user()->role == 'OPD')
                    <div class="modal-header p-3">
                        <h5 class="modal-title m-2" id="exampleModalLabel">Dokumen Form</h5>
                    </div>
                    <div class="modal-body">
                        <div id="respon_error" class="text-danger mb-4"></div>
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="id_dokumen" id="id_dokumen" value="{{ Request('jenis_dokumen') }}">
                        <div class="form-group">
                            <label>Status Dokumen</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="">--PILIH STATUS--</option>
                                <option>Sedang Dalam Pengecekan</option>
                                <option>Dokumen Diterima</option>
                                <option>Perlu Diperbaiki</option>
                            </select>
                        </div>
                        <div class="modal-footer p-3">
                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                            <button id="tombol_kirim" class="btn btn-primary btn-sm">Submit</button>
                        </div>
                    </div>
                @endif
            </form>
            <form id="form">
                @if(Auth::user()->role == 'Pegawai')
                    <div class="modal-header p-3">
                        <h5 class="modal-title m-2" id="exampleModalLabel">Dokumen Form</h5>
                    </div>
                    <div class="modal-body">
                        <div id="respon_error" class="text-danger mb-4"></div>
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="id_dokumen" id="id_dokumen" value="{{ Request('jenis_dokumen') }}">
                        <div class="form-group">
                            <label>Dokumen</label>
                            <input name="dokumen" id="dokumen" type="file" placeholder="Dokumen"
                                class="form-control form-control-sm" accept=".pdf, image/*">
                        </div>
                        <div class="form-group">
                            <label>Jenis Dokumen</label>
                            <input type="text" placeholder="Dokumen" value="{{ $jenis }}"
                                class="form-control form-control-sm" required readonly>
                        </div>
                        @php
                            $variations = [
                                'dokumen berkala',
                                'Dokumen Berkala',
                                'Dokumen berkala',
                                'dokumen Berkala',
                                'DOKUMEN BERKALA',
                                'dok. berkala',
                                'dok berkala',
                                'Dok. Berkala',
                                'Dok Berkala',
                                'DOK. BERKALA',
                                'DOK BERKALA',
                                'dokumenberkala',
                                'DokumenBerkala',
                                'DOKUMENBERKALA',
                                'Dokumenberkala',
                                'dokumenBerkala',
                                'Kenaikan Gaji',
                                'Kenaikan gaji',
                                'kenaikan Gaji',
                                'kenaikangaji',
                                'KenaikanGaji',
                                'Kenaikangaji',
                                'kenaikanGaji',
                                'KENAIKAN GAJI',
                                'KENAIKANGAJI',
                                'SK Gaji Berkala'
                            ];

                            $kenaikan_gaji = DB::table('jenis_dokumens')
                                ->where('id', Request('jenis_dokumen'))
                                ->first();
                        @endphp
                        @if (in_array($kenaikan_gaji->jenis_dokumen, $variations))
                            <div class="form-group">
                                <label>Jenis Dokumen Berkala</label>
                                <select name="jenis_dokumen_berkala" id="jenis_dokumen_berkala"
                                    class="form-control form-control-sm" required>
                                    <option>Kenaikan Gaji</option>
                                    <option>Lainnya</option>
                                </select>
                            </div>
                        @endif
                        <div class="form-group">
                            <label>Tanggal Awal Dokumen</label>
                            <input type="date" placeholder="Tanggal Awal Dokumen" id="tanggal_dokumen"
                                name="tanggal_dokumen" class="form-control form-control-sm" required>
                        </div>
                        @if ($kenaikan_gaji->punya_tgl_akhir == 'Ya')
                            <div class="form-group">
                                <label>Tanggal Akhir Dokumen</label>
                                <input type="date" placeholder="Tanggal Akhir Dokumen" id="tanggal_akhir_dokumen"
                                    name="tanggal_akhir_dokumen" class="form-control form-control-sm">
                            </div>
                        @endif
                        <div class="form-group">
                            <label>Pemilik</label>
                            @php
                                if (Auth::user()->role == 'Admin' || Auth::user()->role == 'SKPD') {

                                    $users = DB::table('users')->get();

                                } else {

                                    $users = DB::table('users')->where('id', Auth::id())->get();
                                }
                            @endphp
                            <select name="id_user" id="id_user" class="form-control" required>
                                @foreach ($users as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>SKPD <sup class="text-danger">*</sup></label>
                            @php

                                $skpd = DB::table('skpds')->get();
                            @endphp
                            <select name="id_skpd" id="id_skpd" class="form-control" required>
                                <option value="">PILIH SKPD</option>
                                @foreach ($skpd as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_skpd }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Unit Kerja <sup class="text-danger">*</sup></label>
                            <select name="id_unit_kerja" id="id_unit_kerja" class="form-control" required>
                                <option value="">PILIH UNIT KERJA</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer p-3">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                        <button id="tombol_kirim" class="btn btn-primary btn-sm">Submit</button>
                    </div>
                @endif
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

            // Mendapatkan query string dari URL
            let params = new URLSearchParams(window.location.search);

            // Mendapatkan nilai parameter
            let jenis_dokumen = params.get('jenis_dokumen'); // "John"

            $("#myTable").DataTable({
                "ordering": true,
                ajax: '/data-file-dokumen?jenis_dokumen=' + jenis_dokumen,
                processing: true,
                'language': {
                    'loadingRecords': '&nbsp;',
                    'processing': 'Loading...'
                },
                columnDefs: [
                    { orderable: false, targets: [7, 8, 9] } // Kolom ke-0 dan ke-2 tidak bisa di-sort
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
                        return `${row.jenis_dokumen} <br> ${row.jenis_dokumen_berkala ?? `Lainnya`}`
                    }
                },
                {
                    render: function (data, type, row, meta) {
                        return `<b>Tanggal Awal:</b><br> ${row.tanggal_dokumen} <br> <b>Tanggal Akhir:</b><br> ${row.tanggal_akhir_dokumen ?? '-'}`
                    }
                },
                {
                    data: "created_at"
                },
                {
                    render: function (data, type, row, meta) {
                        return `SKPD: ${row.nama_skpd} <br> UNIT KERJA: ${row.unit_kerja ?? `-`}`
                    }
                },
                {
                    render: function (data, type, row, meta) {
                        return `${row.status ?? 'Belum Diperiksa'}
                                    <br> <span style="display: none;">${row.dokumen}</span>
                                `
                    }
                },
                {
                    render: function (data, type, row, meta) {
                        return `<a target="_blank" href="/convert-to-pdf/${row.dokumen}">
                                    <i style="font-size: 1.5rem;" class="text-danger bi bi-file-earmark-pdf"></i>
                                </a>`
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
                modal.find('#id_user').val(cokData[0].id_user)
                modal.find('#jenis_dokumen').val(cokData[0].jenis_dokumen)
                modal.find('#status').val(cokData[0].status)
                modal.find('#tanggal_dokumen').val(cokData[0].tanggal_dokumen)
                modal.find('#tanggal_akhir_dokumen').val(cokData[0].tanggal_akhir_dokumen)
                modal.find('#id_user').val(cokData[0].id_user)
                modal.find('#id_skpd').val(cokData[0].id_skpd)
            }
        })

        form.onsubmit = (e) => {

            let formData = new FormData(form);

            document.getElementById('respon_error').innerHTML = ``

            e.preventDefault();

            document.getElementById("tombol_kirim").disabled = true;

            axios({
                method: 'post',
                url: formData.get('id') == '' ? '/store-file-dokumen' : '/update-file-dokumen',
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

                        location.reload('/file-dokumen')

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

        updateStatusForm.onsubmit = (e) => {

            let formData = new FormData(updateStatusForm);

            e.preventDefault();

            document.getElementById("tombol_kirim").disabled = true;

            axios({
                method: 'post',
                url: '/update-status-dokumen',
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

                        location.reload('/file-dokumen')

                    } else {

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
                    axios.post('/delete-file-dokumen', {
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
        document.getElementById('id_skpd').addEventListener('change', function () {
            const skpdId = this.value; // Ambil id_skpd yang dipilih
            const unitKerjaSelect = document.getElementById('id_unit_kerja');

            // Kosongkan daftar unit kerja sebelum memuat data baru
            unitKerjaSelect.innerHTML = '<option value="">Memuat data...</option>';

            // Panggil data unit kerja dengan Axios
            axios.get(`/data-unit-kerja/${skpdId}`)
                .then(response => {
                    const data = response.data;
                    unitKerjaSelect.innerHTML = '<option value="">PILIH UNIT KERJA</option>'; // Reset pilihan

                    // Tambahkan setiap unit kerja ke dalam dropdown
                    data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.id;
                        option.textContent = item.unit_kerja;
                        unitKerjaSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error fetching unit kerja:', error);
                    unitKerjaSelect.innerHTML = '<option value="">GAGAL MEMUAT DATA</option>';
                });
        });
    </script>

@endpush
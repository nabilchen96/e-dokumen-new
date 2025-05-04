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
                <h3 class="font-weight-bold">Data Kenaikan Gaji</h3>
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
                @endif
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped" style="width: 100%;">
                        <thead class="bg-info text-white">
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Lengkap</th>
                                <th>No. / Status</th>
                                <th>Gaji Lama</th>
                                <th>Gaji Baru</th>
                                <th width="5%">File</th>
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
@if (Auth::user()->role == 'Admin')
    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form" action="{{ url('store-kenaikan-gaji') }}" method="post">
                    @csrf
                    <div class="modal-header p-3">
                        <h5 class="modal-title m-2" id="exampleModalLabel">Kenaikan Gaji Form</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label>Pilih Pegawai <sup class="text-danger">*</sup></label>
                            @php
                                $pegawai = DB::table('users')
                                    ->join('profils', 'profils.id_user', '=', 'users.id')
                                    ->select(
                                        'profils.*',
                                        'users.name'
                                    )
                                    ->get();
                            @endphp
                            <select name="id_profil" id="id_profil" class="form-control" required>
                                @foreach ($pegawai as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }} | NIP: {{ $p->nip }}</option>
                                @endforeach
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
@endif
@endsection
@push('script')
    <script>

        function formatRupiah(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(amount);
        }

        function formatTanggal(date) {
            var d = new Date(date);
            var day = d.getDate().toString().padStart(2, '0'); // Menambahkan leading zero jika perlu
            var month = (d.getMonth() + 1).toString().padStart(2, '0'); // Bulan dimulai dari 0, jadi tambah 1
            var year = d.getFullYear();

            return `${day}-${month}-${year}`;
        }

        document.addEventListener('DOMContentLoaded', function () {
            getData()
        })

        function getData() {
            $("#myTable").DataTable({
                "ordering": true,
                ajax: '/data-kenaikan-gaji',
                processing: true,
                'language': {
                    'loadingRecords': '&nbsp;',
                    'processing': 'Loading...'
                },
                columnDefs: [
                    { orderable: false, targets: [5, 6, 7] } // Kolom ke-0 dan ke-2 tidak bisa di-sort
                ],
                    columns: [{
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    render: function (data, type, row, meta) {
                        return `${row.name} <br> <b>${row.nip}</b>`
                    }
                },
                {
                    render: function (data, type, row, meta) {
                        return `${row.no_dokumen ?? `-`} <br> Status: ${row.status}`
                    }
                },
                {
                    render: function (data, type, row, meta) {
                        return `${row.gaji_pokok_lama ? `<b>Gaji Lama</b>: ${formatRupiah(row.gaji_pokok_lama)}` : '-'} 
                                                    <br> ${row.tgl_berlaku_gaji ? `<b>Tgl Berlaku</b>: ${formatTanggal(row.tgl_berlaku_gaji)}` : '-'}`
                    }
                },
                {
                    render: function (data, type, row, meta) {
                        return `${row.gaji_pokok_baru ? `<b>Gaji Baru</b>: ${formatRupiah(row.gaji_pokok_baru)}` : `-`} 
                                                    <br> ${row.tgl_terhitung_mulai ? `<b>Tgl Berlaku</b>: ${formatTanggal(row.tgl_terhitung_mulai)}` : `-`}`
                    }
                },
                {
                    render: function (data, type, row, meta) {
                        if (row.status != 'Draft') {
                            return `<a href="/export-kenaikan-gaji?data=${row.id}">
                                            <i style="font-size: 1.5rem;" class="text-danger bi bi-file-earmark-pdf"></i>
                                        </a>`
                        } else {
                            return ``
                        }
                    }
                },
                {
                    render: function (data, type, row, meta) {
                        return `<a href="/edit-kenaikan-gaji?data=${row.id}">
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
                    axios.post('/delete-kenaikan-gaji', {
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
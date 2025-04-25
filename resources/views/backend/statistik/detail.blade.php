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
                    <h3 class="font-weight-bold">Data Detail Pegawai</h3>
                    <p><b>{{ $title }}</b></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mt-3">
            <div class="card w-100">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="myTable" class="table table-striped" style="width: 100%;">
                            <thead class="bg-info text-white">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nama / NIP</th>
                                    <th>Pendidikan / Jenis Kelamin</th>
                                    <th width="25%">Jabatan / Pangkat</th>
                                    <th>Umur / SKPD</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $k => $item)
                                    <tr>
                                        <td>{{ $k+1 }}</td>
                                        <td>
                                            <b>Nama:</b> {{ $item->name }} <br>
                                            <b>NIP:</b> {{ $item->nip }}
                                        </td>
                                        <td>
                                            <b>Pendidikan:</b> {{ $item->tingkat_pendidikan }} <br>
                                            <b>Jenis Kelamin:</b> {{ $item->jenis_kelamin }}
                                        </td>
                                        <td>
                                            <b>Jabatan:</b> {{ $item->jenis_jabatan }} <br>
                                            <b>Pangkat:</b> {{ $item->pangkat }}
                                        </td>
                                        <td>
                                            <b>Umur:</b> {{ $item->umur }} Tahun<br>
                                            <b>SKPD:</b> {{ $item->nama_skpd }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $("#myTable").DataTable({})
    </script>
@endpush
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

        th,
        td {
            /* white-space: nowrap !important; */
        }
    </style>
@endpush
@section('content')
    <div class="row" style="margin-top: -200px;">
        <div class="col-md-12">
            <div class="row">
                <div class="col-12 col-xl-8 mb-xl-0">
                    <h3 class="font-weight-bold">Data Proses Kenaikan Gaji</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mt-4">
            <div class="card w-100">
                <div class="card-body">
                    @if (Auth::user()->role == 'Admin' || Auth::user()->role == 'OPD')
                        <button type="button" class="btn btn-primary btn-sm mb-4" data-toggle="modal" data-target="#modal">
                            Tambah
                        </button>
                    @endif
                    <div class="table-responsive">
                        <table id="myTable" class="table table-striped table-bordered" style="width: 100%;">
                            <thead class="bg-info text-white">
                                <tr>
                                    <th rowspan="2" style="vertical-align: middle;" width="5%">No</th>
                                    <th rowspan="2" style="vertical-align: middle;">File Pengantar</th>
                                    <th colspan="5" style="border: #ced4da solid 1px !important;" class="text-center">Proses
                                        Kenaikan Gaji</th>
                                    <th rowspan="2" style="vertical-align: middle;"></th>
                                </tr>
                                <tr class="border-top">
                                    <th>[1]. Staff <br> BKPSDM</th>
                                    <th>[2]. Kabid <br> BKPSDM</th>
                                    <th>[3]. Sekretaris <br> BKPSDM</th>
                                    <th>[4]. Kepala <br> BKPSDM</th>
                                    <th>[5]. Bendahara <br> Gaji DPKAD</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $k => $item)
                                    <tr>
                                        <td>{{ $k + 1 }}</td>
                                        <td>
                                            <div>
                                                <a href="{{ asset('file_pengantar') }}/{{ $item->file_pengantar }}">
                                                    <i class="bi bi-file-earmark-fill"></i> Lihat File
                                                </a>
                                            </div><br>
                                            <b>User OPD: </b><br>
                                            {{ $item->name_0 }}
                                        </td>
                                        <td>
                                            <div>
                                                @if ($item->status_1 == 'Disetujui')
                                                    <i class="bi bi-check-circle-fill text-success"></i> Disetujui
                                                @elseif ($item->status_1 == 'Ditolak')
                                                    <i class="bi bi-x-circle-fill text-danger"></i> Ditolak
                                                @else
                                                    <i class="bi bi-clock-fill text-warning"></i> Belum Proses
                                                @endif
                                            </div><br>
                                            <b>Waktu Verifikasi: </b><br>
                                            {{ $item->waktu_1 ?? '-' }}
                                        </td>
                                        <td>
                                            <div>
                                                @if ($item->status_2 == 'Disetujui')
                                                    <i class="bi bi-check-circle-fill text-success"></i> Disetujui
                                                @elseif ($item->status_2 == 'Ditolak')
                                                    <i class="bi bi-x-circle-fill text-danger"></i> Ditolak
                                                @else
                                                    <i class="bi bi-clock-fill text-warning"></i> Belum Proses
                                                @endif
                                            </div><br>
                                            <b>Waktu Verifikasi: </b><br>
                                            {{ $item->waktu_2 ?? '-' }}
                                        </td>
                                        <td>
                                            <div>
                                                @if ($item->status_3 == 'Disetujui')
                                                    <i class="bi bi-check-circle-fill text-success"></i> Disetujui
                                                @elseif ($item->status_3 == 'Ditolak')
                                                    <i class="bi bi-x-circle-fill text-danger"></i> Ditolak
                                                @else
                                                    <i class="bi bi-clock-fill text-warning"></i> Belum Proses
                                                @endif

                                            </div><br>
                                            <b>Waktu Verifikasi: </b><br>
                                            {{ $item->waktu_3 ?? '-' }}
                                        </td>
                                        <td>
                                            <div>
                                                @if ($item->status_4 == 'Dirilis')
                                                    <i class="bi bi-check-circle-fill text-success"></i> Dirilis
                                                @elseif ($item->status_4 == 'Ditolak')
                                                    <i class="bi bi-x-circle-fill text-danger"></i> Ditolak
                                                @else
                                                    <i class="bi bi-clock-fill text-warning"></i> Belum Proses
                                                @endif

                                            </div><br>
                                            <b>Waktu Verifikasi: </b><br>
                                            {{ $item->waktu_4 ?? '-' }}
                                        </td>
                                        <td>
                                            <div>
                                                @if ($item->status_5 == 'Dibayarkan')
                                                    <i class="bi bi-check-circle-fill text-success"></i> Dibayarkan
                                                @elseif ($item->status_5 == 'Ditolak')
                                                    <i class="bi bi-x-circle-fill text-danger"></i> Ditolak
                                                @else
                                                    <i class="bi bi-clock-fill text-warning"></i> Belum Proses
                                                @endif

                                            </div><br>
                                            <b>Waktu Dibayarkan: </b><br>
                                            {{ $item->waktu_5 ?? '-' }}
                                        </td>
                                        <td>
                                            <a href="{{ url('detail-proses-kenaikan-gaji') }}?id={{ $item->id }}">
                                                <i style="font-size: 1.5rem;" class="text-success bi bi-grid"></i>
                                            </a>
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
    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form">
                    <div class="modal-header p-3">
                        <h5 class="modal-title m-2" id="exampleModalLabel">Upload File Pengantar</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label>File Pengantar</label>
                            <input name="file_pengantar" id="file_pengantar" type="file" placeholder="File Pengantar"
                                class="form-control form-control-sm" accept=".pdf">
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
                // scrollX: true
            })
        }

        form.onsubmit = (e) => {

            let formData = new FormData(form);

            e.preventDefault();

            document.getElementById("tombol_kirim").disabled = true;

            axios({
                method: 'post',
                url: '/store-proses-kenaikan-gaji',
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

                        location.reload('/proses-kenaikan-gaji')

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
    </script>
@endpush
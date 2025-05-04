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
            white-space: nowrap !important;
        }
    </style>
@endpush
@section('content')
    <div class="row" style="margin-top: -200px;">
        <div class="col-md-12">
            <div class="row">
                <div class="col-12 col-xl-8 mb-xl-0">
                    <h3 class="font-weight-bold">Detail Proses Kenaikan Gaji</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mt-4">
            <div class="card w-100">
                <div class="card-body">
                    @if (Auth::user()->role != 'OPD')
                        <button style="border-radius: 8px !important;" type="button" class="btn btn-primary btn-sm mb-5"
                            data-toggle="modal" data-target="#modal">
                            Verifikasi Proses
                        </button>
                    @endif
                    <a href="{{ url('proses-kenaikan-gaji') }}">
                        <button style="border-radius: 8px !important;" type="button"
                            class="btn btn-warning text-white btn-sm mb-5">
                            Kembali
                        </button>
                    </a>
                    <!-- Modal Import-->
                    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                @if ($data->status_5 == 'Dibayarkan')
                                    <div class="modal-header p-3">
                                        <h5 class="modal-title m-2" id="exampleModalLabel">Verifikasi Form</h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="alert alert-success">
                                            <i class="bi bi-check-circle-fill text-success"></i>
                                            proses kenaikan gaji sudah selesai!
                                        </div>
                                    </div>
                                    <div class="modal-footer p-3">
                                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                                    </div>
                                @else
                                    <form id="form" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-header p-3">
                                            <h5 class="modal-title m-2" id="exampleModalLabel">Verifikasi Form</h5>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <input type="hidden" name="id" value="{{ Request('id') }}">
                                                <label>Verifikasi Proses <sup class="text-danger">*</sup> </label>
                                                <select class="form-control" name="verifikasi_proses" id="verifikasi_proses"
                                                    required>
                                                    <option value="">--PILIH VERIFIKASI--</option>
                                                    @if($data->status_4 == 'Dirilis')
                                                        <option>Dibayarkan</option>
                                                    @elseif ($data->status_3 == 'Disetujui')
                                                        <option>Dirilis</option>
                                                    @else
                                                        <option>Disetujui</option>
                                                    @endif
                                                    <option>Ditolak</option>
                                                </select>
                                            </div>
                                            @if ($data->status_4 == 'Dirilis')
                                                <div class="form-group">
                                                    <label>Waktu Pembayaran <sup class="text-danger">*</sup> </label>
                                                    <input type="datetime-local" class="form-control" name="waktu_5" id="waktu_5"
                                                        required>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="modal-footer p-3">
                                            <button type="button" class="btn btn-danger btn-sm"
                                                data-dismiss="modal">Close</button>
                                            <button id="tombol_kirim" class="btn btn-primary btn-sm">Submit</button>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    <h3><i class="bi bi-folder2"></i> Proses kenaikan Gaji</h3>
                    <hr>
                    <div class="table-responsive">
                        <table id="myTable" class="table table-striped table-bordered" style="width: 100%;">
                            <thead class="bg-info text-white">
                                <tr>
                                    <th colspan="6" style="border: #ced4da solid 1px !important;" class="text-center">Proses
                                        Kenaikan Gaji</th>
                                </tr>
                                <tr class="border-top">
                                    <th>[0]. Upload File <br> User OPD</th>
                                    <th>[1]. Staff <br> BKPSDM</th>
                                    <th>[2]. Kabid <br> BKPSDM</th>
                                    <th>[3]. Sekretaris <br> BKPSDM</th>
                                    <th>[4]. Kepala <br> BKPSDM</th>
                                    <th>[5]. Bendahara <br> Gaji DPKAD</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div>
                                            <i class="bi bi-cloud-arrow-up-fill text-success"></i> Diupload
                                        </div><br>
                                        <b>Waktu Upload: </b><br>
                                        {{ $data->waktu_0 ?? '-' }}
                                    </td>
                                    <td>
                                        <div>
                                            @if ($data->status_1 == 'Disetujui')
                                                <i class="bi bi-check-circle-fill text-success"></i> Disetujui
                                            @elseif ($data->status_1 == 'Ditolak')
                                                <i class="bi bi-x-circle-fill text-danger"></i> Ditolak
                                            @else
                                                <i class="bi bi-clock-fill text-warning"></i> Belum Proses
                                            @endif
                                        </div><br>
                                        <b>Waktu Verifikasi: </b><br>
                                        {{ $data->waktu_1 ?? '-' }}
                                    </td>
                                    <td>
                                        <div>
                                            @if ($data->status_2 == 'Disetujui')
                                                <i class="bi bi-check-circle-fill text-success"></i> Disetujui
                                            @elseif ($data->status_2 == 'Ditolak')
                                                <i class="bi bi-x-circle-fill text-danger"></i> Ditolak
                                            @else
                                                <i class="bi bi-clock-fill text-warning"></i> Belum Proses
                                            @endif
                                        </div><br>
                                        <b>Waktu Verifikasi: </b><br>
                                        {{ $data->waktu_2 ?? '-' }}
                                    </td>
                                    <td>
                                        <div>
                                            @if ($data->status_3 == 'Disetujui')
                                                <i class="bi bi-check-circle-fill text-success"></i> Disetujui
                                            @elseif ($data->status_3 == 'Ditolak')
                                                <i class="bi bi-x-circle-fill text-danger"></i> Ditolak
                                            @else
                                                <i class="bi bi-clock-fill text-warning"></i> Belum Proses
                                            @endif

                                        </div><br>
                                        <b>Waktu Verifikasi: </b><br>
                                        {{ $data->waktu_3 ?? '-' }}
                                    </td>
                                    <td>
                                        <div>
                                            @if ($data->status_4 == 'Dirilis')
                                                <i class="bi bi-check-circle-fill text-success"></i> Dirilis
                                            @elseif ($data->status_4 == 'Ditolak')
                                                <i class="bi bi-x-circle-fill text-danger"></i> Ditolak
                                            @else
                                                <i class="bi bi-clock-fill text-warning"></i> Belum Proses
                                            @endif

                                        </div><br>
                                        <b>Waktu Dirilis: </b><br>
                                        {{ $data->waktu_4 ?? '-' }}
                                    </td>
                                    <td>
                                        <div>
                                            @if ($data->status_5 == 'Dibayarkan')
                                                <i class="bi bi-check-circle-fill text-success"></i> Dibayarkan
                                            @elseif ($data->status_5 == 'Ditolak')
                                                <i class="bi bi-x-circle-fill text-danger"></i> Ditolak
                                            @else
                                                <i class="bi bi-clock-fill text-warning"></i> Belum Proses
                                            @endif

                                        </div><br>
                                        <b>Waktu Dibayarkan: </b><br>
                                        {{ $data->waktu_5 ?? '-' }}
                                    </td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <h3 class="mt-5"><i class="bi bi-file-earmark-text"></i> Preview File Pengantar</h3>
                    <hr>
                    <iframe class="mb-4" height="600px;" width="100%"
                        src="{{ asset('file_pengantar') }}/{{ $data->file_pengantar }}" frameborder="0">
                    </iframe>
                    @if (Auth::user()->role != 'OPD')
                        <button style="border-radius: 8px !important;" type="button" class="btn btn-primary btn-sm"
                            data-toggle="modal" data-target="#modal">
                            Verifikasi Proses
                        </button>
                    @endif
                    <a href="{{ url('proses-kenaikan-gaji') }}">
                        <button style="border-radius: 8px !important;" type="button"
                            class="btn btn-warning text-white btn-sm">
                            Kembali
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            getData()
        })

        form.onsubmit = (e) => {

            let formData = new FormData(form);

            e.preventDefault();

            document.getElementById("tombol_kirim").disabled = true;

            axios({
                method: 'post',
                url: '/verifikasi-proses-kenaikan-gaji',
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

                        location.reload();

                    } else {

                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: res.data.respon,
                            timer: 3000,
                            showConfirmButton: false
                        })
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
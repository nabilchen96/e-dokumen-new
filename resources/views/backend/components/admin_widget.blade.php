@if(
        Auth::user()->role == 'Admin' ||
        Auth::user()->role == 'SKPD' ||
        Auth::user()->role == 'Staff BKPSDM' ||
        Auth::user()->role == 'Kabid BKPSDM' ||
        Auth::user()->role == 'Sekretaris BKPSDM' ||
        Auth::user()->role == 'Kepala BKPSDM' ||
        Auth::user()->role == 'Inspektorat'
    )
    <div class="col-lg-3 mt-3">
        <div class="card shadow bg-gradient-success card-img-holder text-white">
            <div class="card-body">
                <img src="https://themewagon.github.io/purple-react/static/media/circle.953c9ca0.svg"
                    class="card-img-absolute" alt="circle">
                <h4 class="font-weight-normal mb-3">
                    Total Pegawai Terdaftar
                    <i class="bi bi-person-circle float-right"></i>
                </h4>
                <h2>
                    {{ $total_pegawai ?? 0}}
                </h2>
                <span>Orang</span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 mt-3">
        <div class="card shadow bg-gradient-primary card-img-holder text-white">
            <div class="card-body">
                <img src="https://themewagon.github.io/purple-react/static/media/circle.953c9ca0.svg"
                    class="card-img-absolute" alt="circle">
                <h4 class="font-weight-normal mb-3">
                    Jenis Dokumen
                    <i class="bi bi-person-circle float-right"></i>
                </h4>
                <h2>
                    {{ $total_jenis_dokumen ?? 0}}
                </h2>
                <span>Jenis</span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 mt-3">
        <div class="card shadow bg-gradient-info card-img-holder text-white">
            <div class="card-body">
                <img src="https://themewagon.github.io/purple-react/static/media/circle.953c9ca0.svg"
                    class="card-img-absolute" alt="circle">
                <h4 class="font-weight-normal mb-3">
                    Total Dokumen
                    <i class="bi bi-person-circle float-right"></i>
                </h4>
                <h2>
                    {{ $total_dokumen ?? 0}}
                </h2>
                <span>Diupload</span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 mt-3">
        <div class="card shadow bg-gradient-danger card-img-holder text-white">
            <div class="card-body">
                <img src="https://themewagon.github.io/purple-react/static/media/circle.953c9ca0.svg"
                    class="card-img-absolute" alt="circle">
                <h4 class="font-weight-normal mb-3">
                    Total SKPD
                    <i class="bi bi-person-circle float-right"></i>
                </h4>
                <h2>
                    {{ $total_asal_pegawai ?? 0 }}
                </h2>
                <span>Daerah</span>
            </div>
        </div>
    </div>
@endif

@if (
        Auth::user()->role == 'Staff BKPSDM' ||
        Auth::user()->role == 'Kabid BKPSDM' ||
        Auth::user()->role == 'Sekretaris BKPSDM' ||
        Auth::user()->role == 'Kepala BKPSDM' ||
        Auth::user()->role == 'Inspektorat' ||
        Auth::user()->role == 'Bendahara Gaji DPKAD'
    )
    <div class="col-lg-12 mt-4">
        <div class="card shadow">
            <div class="card-body">
                <h3 class="font-weight-bold">[ <i class="bi bi-bell"></i> ] Notifikasi
                </h3>
                <span class="text-danger">
                    Informasi dokuman yang perlu diproses. Lihat data lainnya di menu proses kenaikan gaji berkala
                </span>

                <div class="table-responsive">
                    <table id="myTable" class="table table-striped table-bordered" style="width: 100%;">
                        <thead class="bg-info text-white">
                            <tr>
                                <th rowspan="2" style="vertical-align: middle;">File Pengantar</th>
                                <th colspan="5" style="border: #ced4da solid 1px !important;" class="text-center">Proses
                                    Kenaikan Gaji</th>
                                @if (Auth::user()->role != 'Inspektorat')
                                    <th rowspan="2" style="vertical-align: middle;">Detail</th>
                                @endif
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
                            @php
                                $datax = DB::table('proses_kenaikan_gajis as pkg')
                                    ->leftJoin('users as user_0', 'user_0.id', '=', 'pkg.id_user_0')
                                    ->leftJoin('users as user_1', 'user_1.id', '=', 'pkg.id_user_1')
                                    ->leftJoin('users as user_2', 'user_2.id', '=', 'pkg.id_user_2')
                                    ->leftJoin('users as user_3', 'user_3.id', '=', 'pkg.id_user_3')
                                    ->leftJoin('users as user_4', 'user_4.id', '=', 'pkg.id_user_4')
                                    ->leftJoin('users as user_5', 'user_5.id', '=', 'pkg.id_user_5')
                                    ->select(
                                        'user_0.name as name_0',
                                        'user_1.name as name_1',
                                        'user_2.name as name_2',
                                        'user_3.name as name_3',
                                        'user_4.name as name_4',
                                        'user_5.name as name_5',
                                        'pkg.*'
                                    );

                                if (Auth::user()->role == 'Staff BKPSDM') {
                                    $datax = $datax->where('pkg.status_1', NULL)->get();
                                }

                                if (Auth::user()->role == 'Kabid BKPSDM') {
                                    $datax = $datax->where('pkg.status_2', NULL)->get();
                                }

                                if (Auth::user()->role == 'Sekretaris BKPSDM') {
                                    $datax = $datax->where('pkg.status_3', NULL)->get();
                                }

                                if (Auth::user()->role == 'Kepala BKPSDM') {
                                    $datax = $datax->where('pkg.status_4', NULL)->get();
                                }

                                if (Auth::user()->role == 'Inspektorat') {
                                    $datax = $datax->where('pkg.status_4', 'Dirilis')->get();
                                }

                                if(Auth::user()->role == 'Bendahara Gaji DPKAD'){
                                    $datax = $datax->where('pkg.status_4', 'Dirilis')->where('status_5', NULL)->get();
                                }
                            @endphp
                            @foreach ($datax as $k => $item)
                                <tr>
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
                                    @if (Auth::user()->role != 'Inspektorat')
                                        <td>
                                            <a href="{{ url('detail-proses-kenaikan-gaji') }}?id={{ $item->id }}">
                                                <i style="font-size: 1.5rem;" class="text-success bi bi-grid"></i>
                                            </a>
                                        </td>
                                    @endif

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- @include('backend.components.profil_kepala') -->
@if(Auth::user()->role == 'Admin' || Auth::user()->role == 'SKPD' || Auth::user()->role == 'OPD')
    <div class="col-lg-6 mt-4">
        <div class="card shadow" style="border-radius: 8px; border: none;">
            <div class="card-body" style="border-radius: 8px; border: none;">
                <h3 style="line-height: 1.7rem;">
                    [ <i class="bi bi-bell"></i> ]
                    Dokumen Belum Diperiksa
                </h3>
                <span class="text-danger">
                    Informasi Dokumen yang Belum Diperiksa oleh Admin
                </span>
                <div class="mb-4"></div>
                <div class="table-responsive" id="tabel" style="height: 290px;">
                    <table id="myTable2" class="table table-striped">
                        <thead class="bg-info text-white">
                            <tr>
                                <th>Nama / NIP</th>
                                <th>Status / Jenis Dokumen</th>
                                <th>File</th>
                                <th>Periksa</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse($dokumen_periksa as $i)
                                <tr>
                                    <td>
                                        {{ $i->name }} <br>
                                        <b>{{ $i->nip }}</b>
                                    </td>
                                    <td>
                                        {{ $i->status ?? 'Belum Diperiksa' }} <br>
                                        Dok. {{ $i->jenis_dokumen ?? 'Lainnya' }}
                                    </td>
                                    <td>
                                        <a target="_blank" href="{{ url('convert-to-pdf') }}/{{ $i->dokumen }}">
                                            <i style="font-size: 1.5rem;" class="text-danger bi bi-file-earmark-pdf"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <button style="border-radius: 8px !important;" class="btn btn-sm btn-primary"
                                            data-toggle="modal" data-target="#modalExample" data-bs-id="{{ $i->id }}"
                                            data-bs-status="{{ $i->status }}" data-bs-id_dokumen="{{ $i->id_dokumen }}">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">
                                        Belum Ada Data Untuk Ditampilkan!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('backend.components.proses_dokumen_berkala')
@endif

<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form">
                <div class="modal-header p-3">
                    <h5 class="modal-title m-2" id="exampleModalLabel">Informasi</h5>
                </div>
                <div class="modal-body">
                    Mohon Maaf!. Saat ini dokumen berkala yang bisa diproses adalah dokumen kenaikan gaji pegawai.

                </div>
                <div class="modal-footer p-3">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalExample" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="updateStatusForm">
                @if (Auth::user()->role == 'Admin' || Auth::user()->role == 'SKPD' || Auth::user()->role == 'OPD')
                    <div class="modal-header p-3">
                        <h5 class="modal-title m-2" id="exampleModalLabel">Update Dokumen Form</h5>
                    </div>
                    <div class="modal-body">
                        <div id="respon_error" class="text-danger"></div>
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="id_dokumen" id="id_dokumen">
                        <div class="form-group">
                            <label>Status Dokumen <sup class="text-danger">*</sup></label>
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
        </div>
    </div>
</div>
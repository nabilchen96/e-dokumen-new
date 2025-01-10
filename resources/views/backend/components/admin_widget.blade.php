@if(Auth::user()->role == 'Admin' || Auth::user()->role == 'SKPD')
    <div class="col-lg-3 mt-3">
        <div class="card shadow bg-gradient-success card-img-holder text-white">
            <div class="card-body">
                <img src="https://themewagon.github.io/purple-react/static/media/circle.953c9ca0.svg"
                    class="card-img-absolute" alt="circle">
                <h4 class="font-weight-normal mb-3">
                    Pegawai BKPSDM
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

    <!-- @include('backend.components.profil_kepala') -->

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
                @if (Auth::user()->role == 'Admin')
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
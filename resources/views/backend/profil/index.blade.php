@extends('backend.app')
@push('style')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
@endpush
@section('content')
    <div class="row" style="margin-top: -200px;">
        <div class="col-md-12 text-white">
            <div class="row">
                <div class="col-12 col-xl-8 mb-xl-0">
                    <h3 class="font-weight-bold">Data Profil</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mt-4">
            <div class="card w-100">
                <div class="card-body">
                    <div class="table-responsive">
                        @if (Auth::user()->role == 'Admin')
                            <a class="btn btn-success btn-sm mb-4" href="{{ url('export-excel-profil') }}"
                                data-target="#modalexport">
                                <i class="bi bi-file-earmark-excel"></i> Export
                            </a>
                        @endif
                        <table id="myTable" class="table table-striped" style="width: 100%;">
                            <thead class="bg-info text-white">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nama/Role/Status/Gol</th>
                                    <th>NIP/NIK/Email/Jabatan</th>
                                    <th>JK/Tempat, Tgl Lahir/WA</th>
                                    <th>Peta</th>
                                    <th width="5%">Detail</th>
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
            <div class="modal-content ">
                <form id="form">
                    <div class="modal-header p-3">
                        <h5 class="modal-title m-2" id="exampleModalLabel">User Form</h5>
                    </div>
                    <div class="modal-body">
                        <div id="respon_error" class="text-danger mb-4"></div>
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="id_user" id="id_user">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Nama <sup class="text-danger">*</sup></label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        placeholder="Nama" required>
                                </div>
                                <div class="form-group">
                                    <label>Email <sup class="text-danger">*</sup></label>
                                    <input type="email" name="email" class="form-control" id="email"
                                        placeholder="Email" required>
                                </div>
                                <div class="form-group">
                                    <label>Tempat Lahir <sup class="text-danger">*</sup></label>
                                    <input type="text" name="tempat_lahir" class="form-control" id="tempat_lahir"
                                        placeholder="Tempat Lahir" required>
                                </div>
                                <div class="form-group">
                                    <label>Jenis Kelamin <sup class="text-danger">*</sup></label>
                                    <select name="jenis_kelamin" class="form-control" id="jenis_kelamin" required>
                                        <option>Laki-laki</option>
                                        <option>Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>NIK <sup class="text-danger">*</sup></label>
                                    <input type="number" name="nik" class="form-control" id="nik"
                                        placeholder="NIK" required>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control" id="password"
                                        placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Lahir <sup class="text-danger">*</sup></label>
                                    <input type="date" name="tanggal_lahir" class="form-control" id="tanggal_lahir"
                                        placeholder="Tanggal Lahir" required>
                                </div>
                                <div class="form-group">
                                    <label>Status Pegawai <sup class="text-danger">*</sup></label>
                                    <select onchange="togglePegawaiDetails()" name="status_pegawai" class="form-control"
                                        id="status_pegawai" required>
                                        <option>PNS</option>
                                        <option>P3K</option>
                                        <option value="Honorer">Non ASN</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div id="pegawai-details" style="display: none;">
                            <div class="form-group">
                                <label>NIP <sup class="text-danger">*</sup></label>
                                <input type="number" name="nip" class="form-control" id="nip"
                                    placeholder="NIP">
                            </div>
                            <div class="form-group">
                                <label>Golongan/Pangkat <sup class="text-danger">*</sup></label>
                                <select name="pangkat" class="form-control" id="pangkat">
                                    <option>I/a - Juru Muda</option>
                                    <option>I/b - Juru Muda Tingkat I</option>
                                    <option>I/c - Juru</option>
                                    <option>I/d - Juru Tingkat I</option>
                                    <option>II/a - Pengatur Muda</option>
                                    <option>II/b - Pengatur Muda Tingkat I</option>
                                    <option>II/c - Pengatur</option>
                                    <option>II/d - Pengatur Tingkat I</option>
                                    <option>III/a - Penata Muda</option>
                                    <option>III/b - Penata Muda Tingkat I</option>
                                    <option>III/c - Penata</option>
                                    <option>III/d - Penata Tingkat I</option>
                                    <option>IV/a - Pembina</option>
                                    <option>IV/b - Pembina Tingkat I - Pembina Tk.I</option>
                                    <option>IV/c - Pembina Utama Muda</option>
                                    <option>IV/d - Pembina Utama Madya</option>
                                    <option>IV/e - Pembina Utama</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Jabatan <sup class="text-danger">*</sup></label>
                                <input type="text" name="jabatan" class="form-control" id="jabatan"
                                    placeholder="Jabatan">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Unit Kerja / SKPD</label>
                            @php

                                $skpd = DB::table('skpds')
                                    ->leftjoin('unit_kerjas', 'unit_kerjas.id_skpd', '=', 'skpds.id')
                                    ->select('skpds.nama_skpd', 'unit_kerjas.unit_kerja', 'unit_kerjas.id')
                                    ->get();
                            @endphp
                            <select id="id_unit_kerja" style="height: 58px !important; width: 100%;" name="id_unit_kerja"
                                class="form-control">
                                <option value="">CARI SKPD / UNIT</option>
                                @foreach ($skpd as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_skpd }} / {{ $item->unit_kerja }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="text-danger" style="font-size: 12px;">*SKPD / Unit Kerja yang dipilih sebelumnya
                                adalah
                                <b id="skpd_unit_kerja"></b>
                            </span>
                        </div>
                        <div class="form-group">
                            <label>Daerah</label>
                            <select class="form-control" style="height: 58px !important; width: 100%;" name="district_id"
                                id="select2-ajax">
                                <option value="">Pilih Data</option>
                            </select>
                            <span class="text-danger" style="font-size: 12px;">*Daerah yang dipilih sebelumnya adalah
                                <b id="district"></b>
                            </span>
                        </div>
                        <div class="form-group">
                            <label>Alamat <sup class="text-danger">*</sup></label>
                            <textarea name="alamat" class="form-control" id="alamat" cols="10" rows="10" placeholder="Alamat"
                                required></textarea>
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

    <div class="modal fade" id="modalpeta" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Peta Lokasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="map" style="aspect-ratio: 2.5/1 !important; width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="{{ asset('js/backend/profil/index.js') }}"></script>
@endpush

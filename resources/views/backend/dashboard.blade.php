@extends('backend.app')
@push('style')
    <link href="{{ asset('bell.css') }}" rel="stylesheet">
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
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <style>
            #map {
                height: 600px;
                width: 100%;
            }
        </style>
    @endpush
@endpush
@section('content')
@php
    @$data_user = Auth::user();
    @$profil = DB::table('profils')->where('id_user', Auth::id())->first();
@endphp

<div class="row" style="margin-top: -200px;">
    <div class="col-md-12 grid-margin">
        <div class="row">
            <div class="col-lg-12 mb-4">
                <h3 class="font-weight-bold">Dashboard</h3>
                <h6 class="font-weight-normal mb-0">Hi, {{ Auth::user()->name }}.
                    Welcome back to Aplikasi ASNBKL</h6>
            </div>
            @if (Auth::user()->role == 'Pegawai' && $dokumenBelumDiupload != null)
                    @if (@$profil)
                            <div class="col-lg-12 mt-1">
                                <div class="card">
                                    <div class="card-body">
                                        <i class="text-danger bi bi-exclamation-triangle"></i>
                                        Anda belum mengupload dokumen <b>{{ $dokumenBelumDiupload }}</b>. Klik menu dokumen dan pilih
                                        jenis dokumen yang ingin diupload.
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <div class="card w-100">
                                    <div class="card-body">
                                        <h3 class="font-weight-bold mb-4">[ <i class="bi bi-file-earmark-text"></i> ] Dokumen Anda E</h3>
                                        <div class="table-responsive">
                                            <table id="myTable" class="table table-striped" style="width: 100%;">
                                                <thead class="bg-info text-white">
                                                    <tr>
                                                        <th width="5%">No</th>
                                                        <th>jenis Dokumen</th>
                                                        <th>Tanggal Dokumen</th>
                                                        <th>Tanggal Upload</th>
                                                        <th>Status</th>
                                                        <th width="5%"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php

                                                        $profil = DB::table('profils')->where('id_user', Auth::id())->first();

                                                        $data = DB::table('dokumens')
                                                            ->join('jenis_dokumens', 'jenis_dokumens.id', '=', 'dokumens.id_dokumen')
                                                            ->where('dokumens.id_user', Auth::id())
                                                            //->where('jenis_dokumens.jenis_pegawai', 'like', '%' . (@$profil->status_pegawai ?? '') . '%')
                                                            //->Orwhere('jenis_dokumens.jenis_pegawai', 'Semua')
                                                            ->select(
                                                                'dokumens.*',
                                                                'jenis_dokumens.jenis_dokumen'
                                                            )
                                                            ->get();
                                                    @endphp
                                                    @foreach ($data as $k => $item)
                                                        <tr>
                                                            <td>{{ $k + 1 }}</td>
                                                            <td>{{ $item->jenis_dokumen }}</td>
                                                            <td>{{ $item->tanggal_dokumen }}</td>
                                                            <td>{{ $item->created_at }}</td>
                                                            <td>{{ $item->status ?? 'Belum Diperiksa' }}</td>
                                                            <td>
                                                                <a target="_blank" href="/convert-to-pdf/{{ $item->dokumen }}">
                                                                    <i style="font-size: 1.5rem;"
                                                                        class="text-danger bi bi-file-earmark-pdf"></i>
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
                    @else
                        <div class="col-lg-12 mt-1">
                            <div class="card">
                                <div class="card-body">
                                    <i class="text-danger bi bi-exclamation-triangle"></i>
                                    Anda belum melengkapi data profil. Masuk ke menu profil dan lengkapi data agar anda dapat
                                    mengunggah dokumen
                                </div>
                            </div>
                        </div>
                    @endif
            @elseif(Auth::user()->role == 'Pegawai' && $dokumenBelumDiupload == null)

                    @if(@$profil)

                            <div class="col-12 mt-3">
                                <div class="card w-100">
                                    <div class="card-body">
                                        <h3 class="font-weight-bold mb-4">[ <i class="bi bi-file-earmark-text"></i> ] Dokumen Anda</h3>
                                        <div class="table-responsive">
                                            <table id="myTable" class="table table-striped" style="width: 100%;">
                                                <thead class="bg-info text-white">
                                                    <tr>
                                                        <th width="5%">No</th>
                                                        <th>jenis Dokumen</th>
                                                        <th>Tanggal Dokumen</th>
                                                        <th>Tanggal Upload</th>
                                                        <th>Status</th>
                                                        <th width="5%"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php

                                                        $profil = DB::table('profils')->where('id_user', Auth::id())->first();

                                                        $data = DB::table('dokumens')
                                                            ->join('jenis_dokumens', 'jenis_dokumens.id', '=', 'dokumens.id_dokumen')
                                                            ->where('dokumens.id_user', Auth::id())
                                                            //->where('jenis_dokumens.jenis_pegawai', 'like', '%' . (@$profil->status_pegawai ?? '') . '%')
                                                            //->Orwhere('jenis_dokumens.jenis_pegawai', 'Semua')
                                                            ->select(
                                                                'dokumens.*',
                                                                'jenis_dokumens.jenis_dokumen'
                                                            )
                                                            ->get();
                                                    @endphp
                                                    @foreach ($data as $k => $item)
                                                        <tr>
                                                            <td>{{ $k + 1 }}</td>
                                                            <td>{{ $item->jenis_dokumen }}</td>
                                                            <td>{{ $item->tanggal_dokumen }}</td>
                                                            <td>{{ $item->created_at }}</td>
                                                            <td>{{ $item->status ?? 'Belum Diperiksa' }}</td>
                                                            <td>
                                                                <a target="_blank" href="/convert-to-pdf/{{ $item->dokumen }}">
                                                                    <i style="font-size: 1.5rem;"
                                                                        class="text-danger bi bi-file-earmark-pdf"></i>
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
                    @else
                        <div class="col-lg-12 mt-1">
                            <div class="card">
                                <div class="card-body">
                                    <i class="text-danger bi bi-exclamation-triangle"></i>
                                    Anda belum melengkapi data profil. Masuk ke menu profil dan lengkapi data agar anda dapat
                                    mengunggah dokumen
                                </div>
                            </div>
                        </div>
                    @endif
            @elseif(Auth::user()->role == 'Admin')
                        <div class="col-lg-3 mt-3">
                            <div class="card shadow bg-gradient-success card-img-holder text-white">
                                <div class="card-body">
                                    <img src="https://themewagon.github.io/purple-react/static/media/circle.953c9ca0.svg"
                                        class="card-img-absolute" alt="circle">
                                    <h4 class="font-weight-normal mb-3">
                                        Total Pegawai
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

                        <div class="col-lg-6 mt-4">
                            <div class="card shadow" style="border-radius: 8px; border: none;">
                                <div class="card-body" style="border-radius: 8px; border: none;">
                                    <h3 style="line-height: 1.7rem;">
                                        [ <i class="bi bi-building"></i> ]
                                        Profil Kepala Instansi
                                    </h3>
                                    <span class="text-danger">
                                        Set Data Instansi di Menu Instansi
                                        <a href="{{ url('instansi') }}">
                                            <i class="bi bi-box-arrow-up-right"></i>
                                        </a>
                                    </span>
                                    <div class="mb-4"></div>
                                    @php
                                        $data = DB::table('instansis')
                                            ->join('profils', 'profils.id', '=', 'instansis.id_profil')
                                            ->join('users', 'users.id', '=', 'profils.id_user')
                                            ->select(
                                                'users.name',
                                                'profils.nip',
                                                'profils.pangkat',
                                                'profils.tempat_lahir',
                                                'profils.tanggal_lahir',
                                                'profils.jenis_kelamin'
                                            )->where('instansis.status', 'Aktif')->first();
                                    @endphp
                                    <div class="table-responsive" style="height: 290px; overflow-y: auto;">
                                        <table class="table table-striped table-borderless"
                                            style="border-radius: 8px !important; border: none !important;">
                                            <tr>
                                                <td width="1%">
                                                    <i class="bi bi-person-circle"></i>
                                                </td>
                                                <td>
                                                    Kepala Instansi
                                                </td>

                                                <td>: {{ @$data->name }}</td>
                                            </tr>
                                            <tr>
                                                <td width="1%">
                                                    <i class="bi bi-postcard"></i>
                                                </td>
                                                <td>
                                                    NIP
                                                </td>
                                                <td>: {{ @$data->nip }}</td>
                                            </tr>
                                            <tr>
                                                <td width="1%">
                                                    <i class="bi bi-boxes"></i>
                                                </td>
                                                <td>
                                                    Gol. / Pangkat
                                                </td>
                                                <td>: {{ @$data->pangkat }}</td>
                                            </tr>
                                            <tr>
                                                <td width="1%">
                                                    <i class="bi bi-calendar3"></i>
                                                </td>
                                                <td>
                                                    Tempat / Tanggal Lahir
                                                </td>
                                                <td>: {{ @$data->tempat_lahir}}, {{ @$data->tanggal_lahir }}</td>
                                            </tr>
                                            <tr>
                                                <td width="1%">
                                                    <i class="bi bi-person-square"></i>
                                                </td>
                                                <td>
                                                    Jenis Kelamin
                                                </td>
                                                <td>: {{ @$data->jenis_kelamin }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 mt-4">
                            <div class="card shadow" style="border-radius: 8px; border: none;">
                                <div class="card-body" style="border-radius: 8px; border: none;">
                                    <h3 style="line-height: 1.7rem;">
                                        [ <i class="bi bi-coin"></i> ]
                                        Proses Kenaikan Gaji Pegawai
                                    </h3>
                                    <span class="text-danger">
                                        Lihat Data Kenaikan gaji di Menu Kenaikan Gaji
                                        <a href="{{ url('kenaikan-gaji') }}">
                                            <i class="bi bi-box-arrow-up-right"></i>
                                        </a>
                                    </span>
                                    <div class="mb-4"></div>
                                    <div class="table-responsive" style="height: 290px;">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Nama / NIP</th>
                                                    <th width="40%">Tgl Kenaikan</th>
                                                    <th>Buat Dok.</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @forelse($kenaikan_gaji as $i)
                                                    <tr>
                                                        <td>
                                                            {{ $i->name }} <br>
                                                            <b>{{ $i->nip }}</b>
                                                        </td>
                                                        <td>
                                                            Tgl. {{ date('d-m-Y', strtotime($i->tgl_kenaikan_berikutnya)) }} <br>
                                                            <i class="bi bi-exclamation-triangle"></i>
                                                            {{ $i->total_hari }} hari lagi
                                                        </td>
                                                        <td>
                                                            <form action="{{ url('store-kenaikan-gaji') }}" method="post">
                                                                <input type="hidden" name="id_profil" id="id_profil" required>
                                                                <button style="border-radius: 8px !important;"
                                                                    class="btn btn-sm btn-primary">Proses</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="3" class="text-center">
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
            @endif
        </div>
        <div class="row">
            <!-- //peta -->
            <div class="col-lg-12 mt-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h3 class="font-weight-bold mb-4">
                            [ <i class="bi bi-geo-alt"></i> ]
                            Data Sebaran Pegawai
                        </h3>
                        <div id="map"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
    <script>
        $("#myTable").DataTable({
            "ordering": false,
        })
    </script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Initialize the map
        const map = L.map('map').setView([-2.548926, 118.014863], 5);
        // Adjust default view coordinates

        // Add OpenStreetMap tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Fetch district data from Laravel backend
        fetch('/data-peta') // Adjust this endpoint as necessary
            .then(response => response.json())
            .then(data => {
                data.forEach(district => {
                    const marker = L.marker([district.latitude, district.longitude]).addTo(map);
                    marker.bindPopup(`
                                                                                                                <strong>${district.nama_skpd}</strong><br>
                                                                                                                Total pegawai: ${district.total_employees}
                                                                                                            `);
                });
            })
            .catch(error => console.error('Error fetching district data:', error));
    </script>
@endpush
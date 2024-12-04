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
                        <div class="col-lg-12 mt-3">
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
                                    <h3 class="font-weight-bold mb-4"><i class="bi bi-file-earmark-text"></i> Dokumen Anda</h3>
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
                                                    $data = DB::table('dokumens')
                                                        ->join('jenis_dokumens', 'jenis_dokumens.id', '=', 'dokumens.id_dokumen')
                                                        ->where('dokumens.id_user', Auth::id())
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
            @elseif(Auth::user()->role == 'Pegawai' && $dokumenBelumDiupload == null)
                        <div class="col-lg-12 mt-3">
                            <div class="card">
                                <div class="card-body">
                                    <i class="text-danger bi bi-exclamation-triangle"></i>
                                    Anda sudah mengupload semua dokumen. Klik menu dokumen dan pilih
                                    jenis dokumen untuk menambah atau mengedit dokumen.
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="card w-100">
                                <div class="card-body">
                                    <h3 class="font-weight-bold mb-4"><i class="bi bi-file-earmark-text"></i> Dokumen Anda</h3>
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
                                                    $data = DB::table('dokumens')
                                                        ->join('jenis_dokumens', 'jenis_dokumens.id', '=', 'dokumens.id_dokumen')
                                                        ->where('dokumens.id_user', Auth::id())
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
            @elseif(Auth::user()->role == 'Admin')
                <div class="col-lg-3 mt-3">
                    <div class="card bg-gradient-success card-img-holder text-white">
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
                    <div class="card bg-gradient-primary card-img-holder text-white">
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
                    <div class="card bg-gradient-info card-img-holder text-white">
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
                    <div class="card bg-gradient-danger card-img-holder text-white">
                        <div class="card-body">
                            <img src="https://themewagon.github.io/purple-react/static/media/circle.953c9ca0.svg"
                                class="card-img-absolute" alt="circle">
                            <h4 class="font-weight-normal mb-3">
                                Asal Pegawai
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
        </div>
        <div class="row">
            <!-- //peta -->
            <div class="col-lg-12 mt-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h3 class="font-weight-bold mb-4"><i class="bi bi-geo-alt"></i> Data Sebaran Pegawai</h3>
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
            maxZoom: 10,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Fetch district data from Laravel backend
        fetch('/data-peta') // Adjust this endpoint as necessary
            .then(response => response.json())
            .then(data => {
                data.forEach(district => {
                    const marker = L.marker([district.latitude, district.longitude]).addTo(map);
                    marker.bindPopup(`
                                                <strong>${district.name}</strong><br>
                                                Total Employees: ${district.total_employees}
                                            `);
                });
            })
            .catch(error => console.error('Error fetching district data:', error));
    </script>
@endpush
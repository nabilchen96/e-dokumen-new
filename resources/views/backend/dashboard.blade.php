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

            th,
            td {
                font-size: 13.2px !important;
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
                    Welcome back to APLIKASI PENDATAAN MANDIRI  TENAGA NON ASN</h6>
            </div>
            @if (@$profil)
                <div class="col-lg-5">
                    <div class="card shadow">
                        <div class="card-body">
                            <h3 class="font-weight-bold">[ <i class="bi bi-bell"></i> ] Notifikasi
                            </h3>
                            <span class="text-danger">
                                Informasi dokuman dan data yang wajib dilengkapi
                            </span>
                            <ul class="mt-4" style="height: 275px;">
                                <li style="font-size: 15px;">
                                    @if ($dokumenBelumDiupload)
                                        <i class="text-danger bi bi-exclamation-triangle"></i>
                                        Anda belum mengupload dokumen <b>{{ $dokumenBelumDiupload }}</b>.
                                        Klik menu dokumen dan pilih jenis dokumen yang ingin diupload.
                                    @else
                                        <i class="text-success bi bi-check-circle"></i>
                                        Terimakasih!, anda sudah mengupload semua dokumen. Cek di menu dokumen untuk melihat
                                        dokumen dan status dokumen
                                    @endif
                                </li>
                                <li class="mt-2" style="font-size: 15px;">
                                    @if (@$isiProfil != null)
                                        <i class="text-danger bi bi-exclamation-triangle"></i>
                                        Anda belum mengisi data <b>{{ $isiProfil }}</b>.
                                        Klik <a href="{{ url('profil') }}">menu profil</a> untuk mengisi dan melengkapi data profil.
                                    @else
                                        <i class="text-success bi bi-check-circle"></i>
                                        Terimakasih!, anda sudah mengisi semua data di menu profil. Cek di menu profil untuk
                                        melihat data profil anda
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="card shadow w-100">
                        <div class="card-body">
                            <h3 class="font-weight-bold">[ <i class="bi bi-file-earmark-text"></i> ] Dokumen Anda
                            </h3>
                            <span class="text-danger">
                                Informasi dokuman dan status dokumen anda
                            </span>
                            <div class="mt-4 table-responsive" style="height: 290px;">
                                <table class="table table-striped" style="width: 100%;">
                                    <thead class="bg-info text-white">
                                        <tr>
                                            <th>#</th>
                                            <th>jenis Dokumen</th>
                                            <!-- <th>Tanggal Dokumen</th> -->
                                            <th>Tanggal Upload</th>
                                            <th>Status Dokumen</th>
                                            <th width="5%">File</th>
                                            <th width="5%">Edit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php

                                            $profil = DB::table('profils')->where('id_user', Auth::id())->first();

                                            $data = DB::table('dokumens')
                                                ->join('jenis_dokumens', 'jenis_dokumens.id', '=', 'dokumens.id_dokumen')
                                                ->where('dokumens.id_user', Auth::id())
                                                ->select(
                                                    'dokumens.*',
                                                    'jenis_dokumens.jenis_dokumen',
                                                    'jenis_dokumens.punya_tgl_akhir',
                                                    'jenis_dokumens.id as id_jenis_dokumen'
                                                )
                                                ->orderByRaw("
                                                    CASE 
                                                        WHEN dokumens.status = 'Perlu Diperbaiki' THEN 1
                                                        WHEN dokumens.status = 'Sedang Dalam Pengecekan' THEN 2
                                                        WHEN dokumens.status = 'Belum Diperiksa' THEN 3
                                                        WHEN dokumens.status IS NULL THEN 4
                                                        WHEN dokumens.status = 'Dokumen Diterima' THEN 5
                                                        ELSE 6
                                                    END
                                                ")
                                                ->get();
                                        @endphp
                                        @foreach ($data as $k => $item)
                                            <tr>
                                                <td>{{ $k + 1 }}</td>
                                                <td>{{ $item->jenis_dokumen }}</td>
                                                <td>{{ $item->created_at }}</td>
                                                <td>
                                                    {{ $item->status ?? 'Belum Diperiksa' }}
                                                </td>
                                                <td>
                                                    <a target="_blank" href="/convert-to-pdf/{{ $item->dokumen }}">
                                                        <i style="font-size: 1.5rem;"
                                                            class="text-danger bi bi-file-earmark-pdf"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    @if ($item->status == 'Perlu Diperbaiki')
                                                        <a href="#" style="border-radius: 8px !important;" data-toggle="modal"
                                                            data-target="#modalDokumen" data-bs-id="{{ @$item->id }}"
                                                            data-bs-id_user="{{ Auth::id() }}"
                                                            data-bs-id_jenis_dokumen="{{ @$item->id_jenis_dokumen }}"
                                                            data-bs-tanggal_dokumen="{{ @$item->tanggal_dokumen }}"
                                                            data-bs-tanggal_akhir_dokumen="{{ @$item->tanggal_akhir_dokumen }}"
                                                            data-bs-id_skpd="{{ @$item->id_skpd }}"
                                                            data-bs-jenis_dokumen_berkala="{{ @$item->jenis_dokumen_berkala }}"
                                                            data-bs-punya_tgl_akhir="{{ @$item->punya_tgl_akhir }}"
                                                            data-bs-jenis_dokumen="{{ @$item->jenis_dokumen }}">
                                                            <i style="font-size: 1.5rem;" class="text-success bi bi-grid"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @include('backend.components.admin_widget')
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

<!-- Modal -->
<div class="modal fade" id="modalDokumen" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formDokumen">
                @if(Auth::user()->role == 'Pegawai')
                    <div class="modal-header p-3">
                        <h5 class="modal-title m-2" id="exampleModalLabel">Dokumen Form</h5>
                    </div>
                    <div class="modal-body">
                        <div id="respon_error" class="text-danger mb-4"></div>
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="id_dokumen" id="id_dokumen">
                        <div class="form-group">
                            <label>Dokumen <sup class="text-danger">*</sup></label>
                            <input name="dokumen" id="dokumen" type="file" placeholder="Dokumen"
                                class="form-control form-control-sm" required accept=".pdf, image/*">
                        </div>
                        <div class="form-group">
                            <label>Jenis Dokumen <sup class="text-danger">*</sup></label>
                            <input type="text" placeholder="Dokumen" id="jenis_dokumen" class="form-control form-control-sm"
                                required readonly>
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
                        <div class="form-group">
                            <label>Tanggal Awal Dokumen <sup class="text-danger">*</sup></label>
                            <input type="date" placeholder="Tanggal Awal Dokumen" id="tanggal_dokumen"
                                name="tanggal_dokumen" class="form-control form-control-sm" required>
                        </div>
                        <div id="punya_tgl_akhir"></div>
                        <div class="form-group">
                            <label>Pemilik <sup class="text-danger">*</sup></label>
                            <select name="id_user" id="id_user" class="form-control" required>
                                <option value="{{ Auth::id() }}">{{ Auth::user()->name }}</option>
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
        $("#myTable, #myTable2").DataTable({
            "ordering": true,
            info: false,
            paging: false,
            searching: false,
            order: [[3, 'asc']]
        })
    </script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Initialize the map
        const map = L.map('map').setView([-3.4020431,102.5991136], 10);
        // Adjust default view coordinates

        // Add OpenStreetMap tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 21,
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
    <script>
        $('#modalDokumen').on('show.bs.modal', function (event) {
            const button = event.relatedTarget

            const id = button.getAttribute('data-bs-id')
            const id_user = button.getAttribute('data-bs-id_user')
            const tanggal_dokumen = button.getAttribute('data-bs-tanggal_dokumen')
            const tanggal_akhir_dokumen = button.getAttribute('data-bs-tanggal_akhir_dokumen')
            const id_skpd = button.getAttribute('data-bs-id_skpd')
            const jenis_dokumen_berkala = button.getAttribute('data-bs-jenis_dokumen_berkala')
            const jenis_dokumen = button.getAttribute('data-bs-jenis_dokumen')
            const punya_tgl_akhir = button.getAttribute('data-bs-punya_tgl_akhir')
            const id_jenis_dokumen = button.getAttribute('data-bs-id_jenis_dokumen')

            if (punya_tgl_akhir == 'Ya') {
                document.getElementById('punya_tgl_akhir').innerHTML = `
                                                            <div class="form-group">
                                                                <label>Tanggal Akhir Dokumen</label>
                                                                <input type="date" placeholder="Tanggal Akhir Dokumen" id="tanggal_akhir_dokumen"
                                                                    name="tanggal_akhir_dokumen" class="form-control form-control-sm">
                                                            </div>
                                                        `
            } else {
                document.getElementById('punya_tgl_akhir').innerHTML = ``
            }

            var modal = $(this)
            modal.find('#id').val(id)
            modal.find('#id_user').val(id_user)
            modal.find('#tanggal_dokumen').val(tanggal_dokumen)
            modal.find('#tanggal_akhir_dokumen').val(tanggal_akhir_dokumen)
            // modal.find('#id_skpd').val(id_skpd)
            // modal.find('#jenis_dokumen_berkala').val(jenis_dokumen_berkala)
            modal.find('#jenis_dokumen').val(jenis_dokumen)
            modal.find('#id_dokumen').val(id_jenis_dokumen)
        })

        formDokumen.onsubmit = (e) => {

            let formData = new FormData(formDokumen);

            document.getElementById('respon_error').innerHTML = ``

            e.preventDefault();

            document.getElementById("tombol_kirim").disabled = true;

            axios({
                method: 'post',
                url: '/update-file-dokumen',
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

                        location.reload('/dashboard')

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

        $('#modalExample').on('show.bs.modal', function (event) {

            const button = event.relatedTarget
            const id = button.getAttribute('data-bs-id')
            const status = button.getAttribute('data-bs-status')
            const id_dokumen = button.getAttribute('data-bs-id_dokumen')


            var modal = $(this)
            modal.find('#id').val(id)
            modal.find('#status').val(status)
            modal.find('#id_dokumen').val(id_dokumen)
        })

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
    </script>
@endpush
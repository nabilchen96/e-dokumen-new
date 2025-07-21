@extends('backend.app')
@push('style')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
@endpush
@section('content')
<div class="row" style="margin-top: -200px;">
    <div class="col-md-12 text-white">
        <div class="row">
            <div class="col-12 col-xl-8 mb-xl-0">
                <h3 class="font-weight-bold">Data SKPD</h3>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 mt-4">
        <div class="card w-100">
            <div class="card-body">
                @if (Auth::user()->role == 'Admin')                
                    <button type="button" class="btn btn-primary btn-sm mb-4" data-toggle="modal" data-target="#modalpeta">
                        Tambah
                    </button>
                    <a class="btn btn-success btn-sm mb-4" href="{{ url('export-excel-skpd') }}" data-target="#modalexport">
                        <i class="bi bi-file-earmark-excel"></i> Export
                    </a>
                    <button type="button" class="btn btn-success btn-sm mb-4" data-toggle="modal"
                        data-target="#modalimport">
                        <i class="bi bi-file-earmark-excel"></i> Import
                    </button>
                @endif
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped" style="width: 100%;">
                        <thead class="bg-info text-white">
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Unit Organisasi Induk</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th width="10%">Alamat</th>
                                @if (Auth::user()->role == 'Admin')                                
                                    <th width="5%"></th>
                                    <th width="5%"></th>
                                @endif
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalpeta" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form">
                <div class="modal-header">
                    <h5 class="modal-title">Unit Organisasi Induk Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div id="respon_error" class="text-danger mb-4"></div>
                            <input type="hidden" name="id" id="id">
                            <div class="form-group">
                                <label>Nama Unit Organisasi Induk <sup class="text-danger">*</sup></label>
                                <input name="nama_skpd" id="nama_skpd" type="text" placeholder="Nama Unit Organisasi Induk"
                                    class="form-control form-control-sm" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input name="email" id="email" type="email" placeholder="Email"
                                    class="form-control form-control-sm">
                            </div>
                            <div class="form-group">
                                <label>Telepon</label>
                                <input name="telepon" id="telepon" type="number" placeholder="Telepon"
                                    class="form-control form-control-sm">
                            </div>
                            <div class="form-group">
                                <label>Latitude</label>
                                <input name="latitude" id="latitude" type="text" placeholder="Latitude"
                                    class="form-control form-control-sm" required readonly>
                            </div>
                            <div class="form-group">
                                <label>Longitude</label>
                                <input name="longitude" id="longitude" type="text" placeholder="Longitude"
                                    class="form-control form-control-sm" required readonly>
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea rows="5" name="alamat" id="alamat" class="form-control" required
                                    placeholder="Alamat"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label>Pilih Latitude dan Longitude di Peta</label>
                            <div id="map" style="aspect-ratio: 1/1 !important; width: 100%;"></div>
                        </div>
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

<!-- Modal Import-->
<div class="modal fade" id="modalimport" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="importForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-header p-3">
                    <h5 class="modal-title m-2">Unit Organisasi Induk Import Form</h5>
                </div>
                <div id="responseMessage"></div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Import Excel <sup class="text-danger">*</sup> </label>
                        <input name="file" id="file" type="file" class="form-control form-control-sm mb-2" required>
                        <span>*Unduh format import Unit Organisasi Induk <a href="{{ url('template_skpd_import.xlsx') }}">Template
                                Import SKPD</a></span>
                    </div>
                </div>
                <div class="modal-footer p-3">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                    <button id="importButton" class="btn btn-primary btn-sm">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('script')
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script>
        window.userRole = "{{ Auth::user()->role }}";
    </script>
    <script src="{{ asset('js/backend/skpd/index.js') }}"></script>
@endpush
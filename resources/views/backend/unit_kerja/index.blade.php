@extends('backend.app')
@section('content')
<div class="row" style="margin-top: -200px;">
    <div class="col-md-12 text-white">
        <div class="row">
            <div class="col-12 col-xl-8 mb-xl-0">
                <h3 class="font-weight-bold">Data Unit Organisasi</h3>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 mt-4">
        <div class="card w-100">
            <div class="card-body">
                @if (Auth::user()->role == 'Admin')
                    <button type="button" class="btn btn-primary btn-sm mb-4" data-toggle="modal" data-target="#modal">
                        Tambah
                    </button>
                    <a class="btn btn-success btn-sm mb-4" href="{{ url('export-excel-unit-kerja') }}"
                        data-target="#modalexport">
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
                                <th>Unit Organisasi</th>
                                <th>Unit Organisasi Induk</th>
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
<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form">
                <div class="modal-header p-3">
                    <h5 class="modal-title m-2" id="exampleModalLabel">Instansi Form</h5>
                </div>
                <div class="modal-body">
                    <div id="respon_error" class="text-danger mb-4"></div>
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label>Unit Organisasi Induk<sup class="text-danger">*</sup></label>
                        @php
                            $skpd = DB::table('skpds')->get();
                        @endphp
                        <select name="id_skpd" id="id_skpd" class="form-control" required>
                            <option value="">PILIH Unit Organisasi Induk</option>
                            @foreach ($skpd as $p)
                                <option value="{{ $p->id }}">{{ $p->nama_skpd }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Unit Organisasi <sup class="text-danger">*</sup></label>
                        <input type="text" placeholder="Unit Organisasi" class="form-control" required name="unit_kerja"
                            id="unit_kerja">
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
                    <h5 class="modal-title m-2">Unit Kerja Import Form</h5>
                </div>
                <div id="responseMessage"></div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Import Excel <sup class="text-danger">*</sup> </label>
                        <input name="file" id="file" type="file" class="form-control form-control-sm mb-2" required>
                        <ul>
                            <li>
                                Unduh format import Unit Kerja
                                <a href="{{ url('export-template-unit-kerja') }}">Template Import Unit Kerja</a>
                            </li>
                            <li>
                                Daftar SKPD di dalam format import akan berubah saat ada update pada menu SKPD
                            </li>
                            <li>
                                Copy kolom yang memiliki daftar SKPD pada format import untuk menambah data pada baris
                                selanjutnya
                            </li>
                            <li>
                                Jangan membuat daftar SKPD secara manual. Karena angka di depan SKD adalah angka unik 
                                dari database yang berfungsi untuk mengidentifikasi SKPD
                            </li>
                        </ul>
                        <img src="{{ asset('instruksi_1.png') }}" width="100%" alt="">
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
    <script>
        window.userRole = "{{ Auth::user()->role }}";
    </script>
    <script src="{{ asset('js/backend/unit_kerja/index.js') }}"></script>
@endpush
@extends('backend.app')
@section('content')
    <div class="row" style="margin-top: -200px;">
        <div class="col-md-12 text-white">
            <div class="row">
                <div class="col-12 col-xl-8 mb-xl-0">
                    <h3 class="font-weight-bold">Elektronik Satya Lencana Karya Satya</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mt-4">
            <div class="card w-100">
                <div class="card-body">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link {{ Request('id') == 1 || !Request('id') ? 'active' : '' }}"
                                href="{{ url('slks') }}?id=1">
                                Semua Data
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request('id') == 2 ? 'active' : '' }}" href="{{ url('slks') }}?id=2">
                                <img src="/lencana/perunggu.png" width="20px"> 10 Tahun
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request('id') == 3 ? 'active' : '' }}" href="{{ url('slks') }}?id=3">
                                <img src="/lencana/perak.png" width="20px"> 20 Tahun
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request('id') == 4 ? 'active' : '' }}" href="{{ url('slks') }}?id=4">
                                <img src="/lencana/emas.png" width="20px"> 30 Tahun
                            </a>
                        </li>
                    </ul>
                    <div class="table-responsive mt-4">
                        <table id="myTable" class="table table-striped" style="width: 100%;">
                            <thead class="bg-info text-white">
                                <tr>
                                    <th width="5%">No</th>
                                    <th class="text-center">Lencana</th>
                                    <th width="25%">Nama / NIP</th>
                                    <th width="20%">Lencana / Dokuman</th>
                                    <th width="30%">SKPD / Unit Kerja</th>
                                    @if (Auth::user()->role == 'Admin')
                                        <th width="5%">Upload</th>
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
                        <h5 class="modal-title m-2" id="exampleModalLabel">Upload Dokumen</h5>
                    </div>
                    <div class="modal-body">
                        <div id="respon_error" class="text-danger mb-4"></div>
                        <input type="hidden" name="id_profil" id="id_profil">
                        <div class="form-group">
                            <label>Nama</label>
                            <input id="nama" placeholder="Nama" readonly class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label>NIP</label>
                            <input id="nip" placeholder="NIP" readonly class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label>Masa Kerja</label>
                            <input id="masa_kerja" placeholder="Masa Kerja" readonly class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label>Dokumen <sup class="text-danger">*</sup></label>
                            <input name="dokumen" id="dokumen" type="file" placeholder="Dokumen"
                                class="form-control form-control-sm" accept=".pdf, image/*">
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
        window.userRole = "{{ Auth::user()->role }}";
    </script>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/backend/slks/index.js') }}"></script>
@endpush

@extends('backend.app')
@section('content')
<div class="row" style="margin-top: -200px;">
    <div class="col-md-12 text-white">
        <div class="row">
            <div class="col-12 col-xl-8 mb-xl-0">
                <h3 class="font-weight-bold">Data Jenis Dokumen</h3>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 mt-4">
        <div class="card w-100">
            <div class="card-body">
                @if (Auth::user()->role == 'Admin' || Auth::user()->role == 'AdminBerkala')
                    <button type="button" class="btn btn-primary btn-sm mb-4" data-toggle="modal" data-target="#modal">
                        Tambah
                    </button>
                @endif
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped" style="width: 100%;">
                        <thead class="bg-info text-white">
                            <tr>
                                <th width="5%">No</th>
                                <th>Jenis Dokumen</th>
                                <th>Jenis Pegawai</th>
                                <th>Masa Berlaku?</th>
                                <th>Nomor Dokumen?</th>
                                <th>Status</th>
                                @if (Auth::user()->role == 'Admin' || Auth::user()->role == 'AdminBerkala')                                
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
                    <h5 class="modal-title m-2" id="exampleModalLabel">Jenis Dokumen Form</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label>Jenis Dokumen</label>
                        <input name="jenis_dokumen" id="jenis_dokumen" type="text" placeholder="Jenis Dokumen"
                            class="form-control form-control-sm" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Status</label>
                        <select name="status" id="status" class="form-control" required>
                            <option>Aktif</option>
                            <option>Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Masa Berlaku Dokumen?</label>
                        <select name="punya_tgl_akhir" id="punya_tgl_akhir" class="form-control" required>
                            <option value="Ya">Aktf</option>
                            <option value="Tidak">Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nomor Dokumen?</label>
                        <select name="punya_nomor_dokumen" id="punya_nomor_dokumen" class="form-control" required>
                            <option value="Ya">Aktf</option>
                            <option value="Tidak">Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Jenis Pegawai</label>
                        <select name="jenis_pegawai" id="jenis_pegawai" class="form-control" required>
                            <option>Only Admin</option>
                            <option>PNS</option>
                            <option>P3K</option>
                            <option>PNS dan P3K</option>
                            <option>P3K PW</option>
                            <option>Semua</option>
                        </select>
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
    <script src="{{ asset('js/backend/jenis_dokumen/index.js') }}"></script>
@endpush
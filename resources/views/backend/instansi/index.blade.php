@extends('backend.app')
@section('content')
<div class="row" style="margin-top: -200px;">
    <div class="col-md-12 text-white">
        <div class="row">
            <div class="col-12 col-xl-8 mb-xl-0">
                <h3 class="font-weight-bold">Data Instansi</h3>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 mt-4">
        <div class="card w-100">
            <div class="card-body">
                <button type="button" class="btn btn-primary btn-sm mb-4" data-toggle="modal" data-target="#modal">
                    Tambah
                </button>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped" style="width: 100%;">
                        <thead class="bg-info text-white">
                            <tr>
                                <th width="5%">No</th>
                                <th>Logo</th>
                                <th>Kepala BKPSDM</th>
                                <th>Email/Website</th>
                                <th>Telp/Fax/Kode Pos</th>
                                <th>Status</th>
                                <th width="5%"></th>
                                <th width="5%"></th>
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
                        <label>Logo <sup class="text-danger">*</sup></label>
                        <input name="logo" id="logo" type="file" placeholder="Logo"
                            class="form-control form-control-sm">
                    </div>
                    <div class="form-group">
                        <label>Kepala BKPSDM <sup class="text-danger">*</sup></label>
                        @php
                            $profil = DB::table('profils')
                                ->join('users', 'users.id', '=', 'profils.id_user')
                                ->select(
                                    'users.name',
                                    'profils.*'
                                )
                                ->get();
                        @endphp
                        <select name="id_profil" id="id_profil" class="form-control" required>
                            <option value="">PILIH Kepala BKPSDM</option>
                            @foreach ($profil as $p)
                                <option value="{{ $p->id }}">{{ $p->name }} | NIP: {{ $p->nip }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kode Pos <sup class="text-danger">*</sup></label>
                        <input type="text" placeholder="Kode Pos" class="form-control" required name="kode_pos"
                            id="kode_pos">
                    </div>
                    <div class="form-group">
                        <label>Email Instansi <sup class="text-danger">*</sup></label>
                        <input type="email" placeholder="Email Instansi" class="form-control" required name="email"
                            id="email">
                    </div>
                    <div class="form-group">
                        <label>Website Instansi <sup class="text-danger">*</sup></label>
                        <input type="text" placeholder="Website Instansi" class="form-control" required name="website"
                            id="website">
                    </div>
                    <div class="form-group">
                        <label>Telepon/fax <sup class="text-danger">*</sup></label>
                        <input type="text" placeholder="Telepon/Fax Instansi" class="form-control" required
                            name="telp_fax" id="telp_fax">
                    </div>
                    <div class="form-group">
                        <label>Status <sup class="text-danger">*</sup></label>
                        <select name="status" id="status" class="form-control" required>
                            <option>Aktif</option>
                            <option>Tidak Aktif</option>
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
    <script src="{{ asset('js/backend/instansi/index.js') }}"></script>
@endpush
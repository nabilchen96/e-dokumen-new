@extends('backend.app')
@section('content')
<div class="row" style="margin-top: -200px;">
    <div class="col-md-12 text-white">
        <div class="row">
            <div class="col-12 col-xl-8 mb-xl-0">
                <h3 class="font-weight-bold">Laporkan masalah anda terkait aplikasi disini!</h3>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 mt-3">
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
                                <th>Gambar</th>
                                <th width="15%">Pelapor / No. WA</th>
                                <th>Dibuat Tanggal / Status</th>
                                <th>Masalah / Keterangan</th>
                                <th></th>
                                @if(Auth::user()->role == 'Admin')
                                    <th></th>
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
                    <div id="respon_error" class="text-danger mb-4"></div>
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label>Gambar</label>
                        <input name="gambar" id="gambar" type="file" placeholder="Gambar"
                            class="form-control form-control-sm">
                    </div>
                    <div class="form-group">
                        <label>Masalah <sup class="text-danger">*</sup></label>
                        <textarea name="masalah" id="masalah" placeholder="Masalah" class="form-control form-control-sm" required></textarea>
                    </div>
                    @if(Auth::user()->role == 'Admin')
                        <div class="form-group">
                            <label>Status<sup class="text-danger">*</sup></label>
                            <select name="status" id="status" class="form-control form-control-sm">
                                <option>Proses</option>
                                <option>Selesai</option>
                                <option>Ditolak</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Jawaban</label>
                            <textarea name="jawaban" id="jawaban" placeholder="Jawaban" class="form-control form-control-sm"></textarea>
                        </div>
                    @endif
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
    <script src="{{ asset('js/backend/lapor_masalah/index.js') }}"></script>
@endpush
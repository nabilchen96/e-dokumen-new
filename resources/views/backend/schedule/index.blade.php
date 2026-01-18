@extends('backend.app')
@section('content')
    <div class="row" style="margin-top: -200px;">
        <div class="col-md-12 text-white">
            <div class="row">
                <div class="col-12 col-xl-8 mb-xl-0">
                    <h3 class="font-weight-bold">Data Schedule</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mt-4">
            <div class="card w-100">
                <div class="card-body">
                    @if (Auth::user()->role == 'Admin' ||
                            Auth::user()->role == 'SKPD' ||
                            Auth::user()->role == 'OPD' ||
                            Auth::user()->role == 'Kepala BKPSDM')
                        <button type="button" class="btn btn-primary btn-sm mb-4" data-toggle="modal" data-target="#modal">
                            Tambah
                        </button>
                    @endif

                    <button type="button" class="btn btn-info btn-sm mb-4" data-toggle="modal" data-target="#modalCari">
                        <i class="bi bi-search"></i> Cari
                    </button>

                    <div class="table-responsive">
                        <table id="myTable" class="table table-striped" style="width: 100%;">
                            <thead class="bg-info text-white">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Tanggal</th>
                                    <th>Pegawai</th>
                                    <th>Shift</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Pulang</th>
                                    <th>Aksi</th>
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
                        <h5 class="modal-title m-2" id="exampleModalLabel">Schedule Form</h5>
                    </div>
                    <div class="modal-body">
                        <div id="respon_error" class="text-danger mb-4"></div>
                        <input type="hidden" name="id" id="id">

                        <ul id="respon_error" class="text-danger mb-4"></ul>

                        <div class="form-group">
                            <label>User <sup class="text-danger">*</sup></label>
                            <select name="id_pandu" id="id_pandu" class="" required>
                                <option value="">-- Pilih User --</option>
                                @php
                                    $users = DB::table('users');
                                    if (Auth::user()->role == 'Admin') {
                                        $users = $users->get();
                                    } else {
                                        $users = $users->where('id', Auth::id())->get();
                                    }
                                @endphp
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Shift <sup class="text-danger">*</sup></label>
                            <select name="id_shift" id="id_shift" class="" required>
                                <option value="">-- Pilih Shift --</option>
                                @foreach ($shifts as $shift)
                                    <option value="{{ $shift['id'] }}">{{ $shift['nama_shift'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Tanggal Dari<sup class="text-danger">*</sup></label>
                            <input type="date" name="tanggal_dari" id="tanggal_dari" class="form-control form-control-sm"
                                required>
                        </div>

                        <div class="form-group">
                            <label>Tanggal Ke<sup class="text-danger">*</sup></label>
                            <input type="date" name="tanggal_ke" id="tanggal_ke" class="form-control form-control-sm"
                                required>
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

    <div class="modal fade" id="modalCari" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header p-3">
                    <h5 class="modal-title m-2">Form Cari</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>User <sup class="text-danger">*</sup></label>
                        <select id="idUserSearch" class="">
                            <option value="">-- Semua User --</option>
                            @php
                                $users = DB::table('users')->get();
                            @endphp
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Dari <sup class="text-danger">*</sup></label>
                        <input type="date" id="tanggalDari" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Tanggal Ke <sup class="text-danger">*</sup></label>
                        <input type="date" id="tanggalSampai" class="form-control">
                    </div>
                </div>
                <div class="modal-footer p-3">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                    <button id="btnCari" class="btn btn-primary btn-sm">Cari</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        window.userRole = "{{ Auth::user()->role }}";
    </script>
    <script src="{{ asset('js/backend/schedule/index.js') }}"></script>
@endpush

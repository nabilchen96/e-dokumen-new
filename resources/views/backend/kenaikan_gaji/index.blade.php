@extends('backend.app')
@section('content')
    <div class="row" style="margin-top: -200px;">
        <div class="col-md-12 text-white">
            <div class="row">
                <div class="col-12 col-xl-8 mb-xl-0">
                    <h3 class="font-weight-bold">Data Kenaikan Gaji</h3>
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
                    @endif
                    <div class="table-responsive">
                        <table id="myTable" class="table table-striped" style="width: 100%;">
                            <thead class="bg-info text-white">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nama Lengkap</th>
                                    <th>No. / Status</th>
                                    <th>Gaji Lama</th>
                                    <th>Gaji Baru</th>
                                    <th width="5%">File</th>
                                    <th width="5%">Edit</th>
                                    <th width="5%">Hapus</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (Auth::user()->role == 'Admin' || Auth::user()->role == 'SKPD')
        <!-- Modal -->
        <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="form" action="{{ url('store-kenaikan-gaji') }}" method="post">
                        @csrf
                        <div class="modal-header p-3">
                            <h5 class="modal-title m-2" id="exampleModalLabel">Kenaikan Gaji Form</h5>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" id="id">
                            <div class="form-group">
                                <label>Pilih Pegawai <sup class="text-danger">*</sup></label>
                                @php
                                    $pegawai = DB::table('dokumens')
                                        ->leftJoin('users', 'users.id', '=', 'dokumens.id_user')
                                        ->leftJoin('unit_kerjas', 'unit_kerjas.id', '=', 'dokumens.id_unit_kerja')
                                        ->leftJoin('profils', 'profils.id_user', '=', 'users.id')
                                        ->select(
                                            'users.id',
                                            'users.name', 
                                            'profils.nip', 
                                            'profils.id as id_profil'
                                        );

                                    if(Auth::user()->role == 'Admin'){
                                        $pegawai = $pegawai->groupBy('users.id')
                                                    ->get();
                                    }else{
                                        $pegawai = $pegawai
                                                    //->where('dokumens.id_skpd', Auth::user()->id_unit_kerja)
                                                    //->Orwhere('status_pegawai', 'PNS')
                                                    //->Orwhere('status_pegawai', 'P3K')
                                                    ->groupBy('users.id')
                                                    ->get();
                                    }
                                @endphp
                                <select name="id_profil" id="id_profil" class="" required>
                                    <option value="">PILIH PEGAWAI</option>
                                    @foreach ($pegawai as $p)
                                        <option value="{{ $p->id_profil }}">{{ strtoupper($p->name) }} <b>NIP: {{ $p->nip }}</b> </option>
                                    @endforeach
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
    @endif
@endsection
@push('script')
    <script>
        window.userRole = "{{ Auth::user()->role }}";
    </script>
    <script src="{{ asset('js/backend/kenaikan_gaji/index.js') }}"></script>
@endpush
@extends('backend.app')
@section('content')
    <style>

    </style>
    <div class="row" style="margin-top: -200px;">
        <div class="col-md-12 text-white">
            <div class="row">
                <div class="col-12 col-xl-8 mb-xl-0">
                    <h3 class="font-weight-bold">Data User</h3>
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
                    <a class="btn btn-success btn-sm mb-4" href="{{ url('export-excel-user') }}" data-target="#modalexport">
                        <i class="bi bi-file-earmark-excel"></i> Export
                    </a>
                    <button type="button" class="btn btn-success btn-sm mb-4" data-toggle="modal"
                        data-target="#modalimport">
                        <i class="bi bi-file-earmark-excel"></i> Import
                    </button>
                    <div id="filter-wrapper">
                        <button style="border-radius: 8px !important;" class="btn btn-info btn-sm mb-4 filter-btn btn-warning active" data-filter="PNS">
                            <i class="bi bi-person"></i> PNS
                        </button>

                        <button style="border-radius: 8px !important;" class="btn btn-info btn-sm mb-4 filter-btn" data-filter="P3K">
                            <i class="bi bi-person"></i> P3K
                        </button>
                        
                        <button style="border-radius: 8px !important;" class="btn btn-info btn-sm mb-4 filter-btn" data-filter="P3K PW">
                            <i class="bi bi-person"></i> P3K PW
                        </button>

                        <button style="border-radius: 8px !important;" class="btn btn-info btn-sm mb-4 filter-btn" data-filter="NON_PEGAWAI">
                            <i class="bi bi-person"></i> Admin
                        </button>
                    </div>
                    {{-- <div class="mt-3">
                        {{ $users->links() }}
                    </div> --}}
                    {{-- <form method="GET" action="{{ url()->current() }}" class="mb-3">
                        <div class="d-flex">
                            <input placeholder="Cari Data ....." type="text" name="search" class="form-control form-control-sm"
                                value="{{ request('search') }}">

                            <button style="border-radius: 0px !important;" class="btn btn-primary btn-sm">
                                Cari
                            </button>
                        </div>
                    </form> --}}
                    <div class="table-responsive">
                        <table id="myTable" class="table table-striped" style="width: 100%;">
                            <thead class="bg-info text-white">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Name</th>
                                    <th>Email / No. WA</th>
                                    <th>Role</th>
                                    <th>Status Pegawai</th>
                                    <th>Tgl Dibuat</th>
                                    <th width="5%"></th>
                                    <th width="5%"></th>
                                </tr>
                            </thead>
                        </table>
                        {{-- <table class="table table-striped">
                            <thead class="bg-info text-white">
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email / WA</th>
                                    <th>Role</th>
                                    <th>Status Pegawai</th>
                                    <th>Tgl Dibuat</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $i => $user)
                                    <tr>
                                        <td>{{ $users->firstItem() + $i }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>
                                            {{ $user->email }} <br>
                                            WA: {{ $user->no_wa }}
                                        </td>
                                        <td>
                                            {{ $user->role == 'OPD' ? 'Unit Kerja' : $user->role }} <br>
                                            {{ $user->nama_skpd }} {{ $user->unit_kerja }}
                                        </td>
                                        <td>{{ $user->status_pegawai }}</td>
                                        <td>{{ $user->created_at }}</td>
                                        <td>
                                            <a data-toggle="modal" data-target="#modal" 
                                                data-bs-id="{{ $user->id }}">
                                                <i class="text-success bi bi-grid" style="font-size:1.5rem;"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" onclick="hapusData({{ $user->id }})">
                                                <i class="text-danger bi bi-trash" style="font-size:1.5rem;"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-3">
                            {{ $users->links() }}
                        </div> --}}
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
                        <h5 class="modal-title m-2" id="exampleModalLabel">User Form</h5>
                    </div>
                    <div class="modal-body">
                        <div id="respon_error" class="text-danger mb-4"></div>
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input name="email" id="email" type="email" placeholder="email"
                                class="form-control form-control-sm" aria-describedby="emailHelp" required>
                            <span class="text-danger error" style="font-size: 12px;" id="email_alert"></span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Lengkap</label>
                            <input name="name" id="name" type="text" placeholder="Nama Lengkap"
                                class="form-control form-control-sm" aria-describedby="emailHelp" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input name="password" id="password" type="password" placeholder="Password"
                                class="form-control form-control-sm">
                            <span class="text-danger error" style="font-size: 12px;" id="password_alert"></span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Role</label>
                            <select name="role" class="form-control" id="role" required>
                                <option value="">PILIH ROLE</option>
                                @if (Auth::user()->role == 'Admin')
                                    <option value="Admin">Admin</option>
                                    <option value="SKPD">SKPD</option>
                                    <option>Staff BKPSDM</option>
                                    <option>Kabid BKPSDM</option>
                                    <option>Sekretaris BKPSDM</option>
                                    <option>Kepala BKPSDM</option>
                                    <option>Bendahara Gaji DPKAD</option>
                                    <option>Inspektorat</option>
                                @endif
                                <option>Pegawai</option>
                                <option value="OPD">Unit Kerja</option>
                            </select>
                        </div>
                        <div class="form-group" id="id_skpd_group" style="display: none;">
                            <label for="exampleInputPassword1">PILIH SKPD</label>
                            <select name="id_skpd" class="my-select" id="id_skpd">
                                <option value="">PILIH SKPD</option>
                                @php
                                    $skpd = DB::table('skpds')->get();
                                @endphp
                                @foreach ($skpd as $s)
                                    <option value="{{ $s->id }}">{{ $s->nama_skpd }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" id="id_opd_group" style="display: none;">
                            <label for="exampleInputPassword1">PILIH Unit Kerja</label>
                            <select name="id_unit_kerja" class="my-select2" id="id_unit_kerja">
                                <option value="">PILIH Unit Kerja</option>
                                @php
                                    $unit_kerja = DB::table('unit_kerjas')->get();
                                @endphp
                                @foreach ($unit_kerja as $u)
                                    <option value="{{ $u->id }}">{{ $u->unit_kerja }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" id="status_pegawai_group" style="display: none;">
                            <label for="status_pegawai">Status Pegawai</label>
                            <select name="status_pegawai" class="form-control" id="status_pegawai">
                                <option>PNS</option>
                                <option>P3K</option>
                                <option>P3K PW</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="no_wa">No Whatsapp</label>
                            <input name="no_wa" id="no_wa" type="text" placeholder="082777120"
                                class="form-control form-control-sm" aria-describedby="emailHelp" required>
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
                        <h5 class="modal-title m-2" id="exampleModalLabel">User Import Form</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Import Excel <sup class="text-danger">*</sup> </label>
                            <input name="file" id="file" type="file"
                                class="form-control form-control-sm mb-2" required>
                            <span>*Unduh format import user <a href="{{ asset('template_user_import.xlsx') }}">Template
                                    Import User</a></span>
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
    <script src="{{ asset('js/backend/users/index.js') }}"></script>
@endpush

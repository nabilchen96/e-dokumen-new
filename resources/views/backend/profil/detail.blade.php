@extends('backend.app')
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

        td,
        th {
            font-size: 13.5px !important;
            /* white-space: nowrap !important; */
        }

        #map {
            width: 100%;
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
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container .select2-selection--single {
            height: calc(2.25rem + 2px);
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
        }
    </style>
@endpush
@section('content')
    <div class="row" style="margin-top: -200px;">
        <div class="col-md-12">
            <div class="row">
                <div class="col-12 col-xl-8 mb-xl-0">
                    <h3 class="font-weight-bold">Data Detail Profil</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mt-4">
            <div class="card w-100">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link {{ Request('profil') == '1' || Request('profil') == null ? 'active' : '' }}"
                                href="{{ url('detail-profil') }}?id={{ Request('id') }}&profil=1">Data Profil</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link {{ Request('profil') == '2' ? 'active' : '' }}"
                                href="{{ url('detail-profil') }}?id={{ Request('id') }}&profil=2">Data
                                Pegawai</a>
                        </li>
                        <!-- <li class="nav-item" role="presentation">
                            <a class="nav-link {{ Request('profil') == '3' ? 'active' : '' }}"
                                href="{{ url('detail-profil') }}?id={{ Request('id') }}&profil=3">
                                Dokumen
                            </a>
                        </li> -->
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab"
                            tabindex="0">
                            @if (Request('profil') == 1 || Request('profil') == null)
                                @include('backend.components.profile.index')
                            @elseif(Request('profil') == 2)
                                @include('backend.components.profile.pegawai')
                            <!-- @elseif(Request('profil') == 3)
                                @include('backend.components.profile.dokumen') -->
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('script')
@endpush
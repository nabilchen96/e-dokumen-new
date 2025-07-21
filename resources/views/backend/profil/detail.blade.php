@extends('backend.app')
@push('style')
    <style>
        td,
        th {
            font-size: 13.5px !important;
            /* white-space: nowrap !important; */
        }

        #map {
            width: 100%;
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('content')
    <div class="row" style="margin-top: -200px;">
        <div class="col-md-12 text-white">
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
                            <a href="#" data-target="{{ url('detail-profil') }}?id={{ Request('id') }}&profil=1"
                            class="nav-link tab-link {{ Request('profil') == '1' || Request('profil') == null ? 'active' : '' }}">
                            Data Profil
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#" data-target="{{ url('detail-profil') }}?id={{ Request('id') }}&profil=2"
                            class="nav-link tab-link {{ Request('profil') == '2' ? 'active' : '' }}">
                            Data Pegawai
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="{{ url('detail-profil') }}?id={{ Request('id') }}&profil=3"
                            class="nav-link {{ Request('profil') == '3' ? 'active' : '' }}">
                            Dokumen
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="{{ url('detail-profil') }}?id={{ Request('id') }}&profil=4"
                            class="nav-link {{ Request('profil') == '4' ? 'active' : '' }}">
                            Profil SIASN
                            </a>
                        </li>

                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab"
                            tabindex="0">
                            @if (Request('profil') == 1 || Request('profil') == null)
                                @include('backend.components.profile.index')
                            @elseif(Request('profil') == 2)
                                @include('backend.components.profile.pegawai')
                            @elseif(Request('profil') == 3)
                                @include('backend.components.profile.dokumen')
                            @elseif(Request('profil') == 4)
                                @include('backend.components.profile.profil_siasn')
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new TomSelect('#instansi_kerja');
            new TomSelect('#satuan_kerja');
            new TomSelect('#lokasi_kerja');
        })
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabLinks = document.querySelectorAll('.tab-link');
            const currentProfil = '{{ Request("profil") ?? "1" }}';

            function isFormValid() {
                const form = document.getElementById('formProfil');
                if (!form) return true;

                let valid = true;
                const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
                inputs.forEach(input => {
                    if (!input.value.trim()) {
                        input.classList.add('is-invalid');
                        valid = false;
                    } else {
                        input.classList.remove('is-invalid');
                    }
                });
                return valid;
            }

            tabLinks.forEach(link => {
                link.addEventListener('click', function (e) {
                    const targetUrl = this.dataset.target;
                    const isDokumenTab = targetUrl?.includes('profil=3');

                    // Jika bukan tab dokumen dan sedang di tab profil=1
                    if (!isDokumenTab && currentProfil === '1') {
                        if (!isFormValid()) {
                            e.preventDefault();
                            Swal.fire({
                                icon: 'warning',
                                title: 'Lengkapi Data!',
                                text: 'Mohon isi semua kolom wajib sebelum melanjutkan ke Data Pegawai.',
                                confirmButtonColor: '#3085d6'
                            });
                            return;
                        }
                    }

                    // Jika valid atau tab dokumen, lanjutkan pindah
                    if (targetUrl) {
                        window.location.href = targetUrl;
                    }
                });
            });
        });
    </script>
@endpush
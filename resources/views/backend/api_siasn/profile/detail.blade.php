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
                    <h3 class="font-weight-bold">Data Detail Profil SIASN</h3>
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
                            <a href="{{ url('detail-profil') }}?id={{ Request('id') }}&profil=1"
                                class="nav-link tab-link {{ Request('profil') == '1' || Request('profil') == null ? 'active' : '' }}">
                                Data Profil
                            </a>
                        </li>
                        
                        <li class="nav-item" role="presentation">
                            <a href="{{ url('detail-profil') }}?id={{ Request('id') }}&profil=2"
                                class="nav-link tab-link {{ Request('profil') == '2' ? 'active' : '' }}">
                                Data Pegawai
                            </a>
                        </li>
                        <li class=
                        "nav-item" role="presentation">
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
                                
                                    
                                <div class="row">
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nama lengkap </label>
                                            <input type="text" value="{{ @$response['data']['nama'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Status Pegawai </label>
                                            <input type="text" value="{{ @$response['data']['statusPegawai'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>NIP </label>
                                            <input type="text" value="{{ @$response['data']['nipBaru'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <!--
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>NIP Lama </label>
                                            <input type="text" value="{{ @$response['data']['nipLama'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    -->
                                    
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Gelar Depan </label>
                                            <input type="text" value="{{ @$response['data']['gelarDepan'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Gelar Belakang </label>
                                            <input type="text" value="{{ @$response['data']['gelarBelakang'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Tempat Lahir </label>
                                            <input type="text" value="{{ @$response['data']['tempatLahir'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Tanggal Lahir</label>
                                            <input type="text" value="{{ @$response['data']['tglLahir'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Agama </label>
                                            <input type="text" value="{{ @$response['data']['agama'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Email </label>
                                            <input type="text" value="{{ @$response['data']['email'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <!--
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Email Gov </label>
                                            <input type="text" value="{{ @$response['data']['emailGov'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    -->
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>NIK</label>
                                            <input type="text" value="{{ @$response['data']['nik'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Alamat</label>
                                            <input type="text" value="{{ @$response['data']['alamat'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>No HP </label>
                                            <input type="text" value="{{ @$response['data']['noHp'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <!--
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>No. Telp </label>
                                            <input type="text" value="{{ @$response['data']['noTelp'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    -->
                                    
                                   
                                    <div class="col-lg-6">
                                        Masa Kerja</br>
                                        <div class="form-group">
                                            <label>Tahun</label>
                                            <input type="text" value="{{ @$response['data']['mkTahun'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        </br>
                                        <div class="form-group">
                                            <label>Bulan</label>
                                            <input type="text" value="{{ @$response['data']['mkBulan'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Jenis Pegawai </label>
                                            <input type="text" value="{{ @$response['data']['jenisPegawaiNama'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Kedudukan PNS </label>
                                            <input type="text" value="{{ @$response['data']['kedudukanPnsNama'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                   
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Jenis Kelamin </label>
                                            <input type="text" value="{{ @$response['data']['jenisKelamin'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <!--
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>JenisIdDokumenNama </label>
                                            <input type="text" value="{{ @$response['data']['jenisIdDokumenNama'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                   
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>NomorIdDocument</label>
                                            <input type="text" value="{{ @$response['data']['nomorIdDocument'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>No. Seri Karpeg </label>
                                            <input type="text" value="{{ @$response['data']['noSeriKarpeg'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    -->
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Jenjang Pendidikan Terkahir</label>
                                            <input type="text"
                                                value="{{ @$response['data']['tkPendidikanTerakhir'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Pendidikan Terkahir</label>
                                            <input type="text"
                                                value="{{ @$response['data']['pendidikanTerkahirNama'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Tahun Lulus </label>
                                            <input type="text" value="{{ @$response['data']['tahunLulus'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <!--
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>TMT Pensiun </label>
                                            <input type="text" value="{{ @$response['data']['tmtPensiun'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>buppensiun</label>
                                            <input type="text" value="{{ @$response['data']['bupPensiun'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    -->
                                    
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nomor SK CPNS</label>
                                            <input type="text" value="{{ @$response['data']['nomorSkCpns'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>TMT CPNS </label>
                                            <input type="text" value="{{ @$response['data']['tmtCpns'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Tanggal SK CPNS</label>
                                            <input type="text" value="{{ @$response['data']['tglSkCpns'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nomor SK PNS</label>
                                            <input type="text" value="{{ @$response['data']['nomorSkPns'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Tanggal SK PNS </label>
                                            <input type="text" value="{{ @$response['data']['tglSkPns'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>TMT PNS </label>
                                            <input type="text" value="{{ @$response['data']['tmtPns'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nama Instansi Induk </label>
                                            <input type="text" value="{{ @$response['data']['instansiIndukNama'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <!--
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nama Satuan Kerja Induk</label>
                                            <input type="text"
                                                value="{{ @$response['data']['satuanKerjaIndukNama'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    -->
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nama Kanreg </label>
                                            <input type="text" value="{{ @$response['data']['kanregNama'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <!--
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nama Instansi Kerja </label>
                                            <input type="text" value="{{ @$response['data']['instansiKerjaNama'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Kode Instansi Kerja </label>
                                            <input type="text"
                                                value="{{ @$response['data']['instansiKerjaKodeCepat'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nama Satuan Kerja </label>
                                            <input type="text"
                                                value="{{ @$response['data']['satuanKerjaKerjaNama'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    -->
                                    
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Unit Organisasi Induk </label>
                                            <input type="text" value="{{ @$response['data']['unorIndukNama'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Unit Organisasi </label>
                                            <input type="text" value="{{ @$response['data']['unorNama'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Jenis Jabatan</label>
                                            <input type="text" value="{{ @$response['data']['jenisJabatan'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nama Jabatan </label>
                                            <input type="text" value="{{ @$response['data']['jabatanNama'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <!--
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nama Jabatan Struktural </label>
                                            <input type="text"
                                                value="{{ @$response['data']['jabatanStrukturalNama'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    -->
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nama Jabatan Fungsiopnal </label>
                                            <input type="text"
                                                value="{{ @$response['data']['jabatanFungsionalNama'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nama Jabatan Fungsional Umum </label>
                                            <input type="text"
                                                value="{{ @$response['data']['jabatanFungsionalUmumNama'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>TMT Jabatan </label>
                                            <input type="text" value="{{ @$response['data']['tmtJabatan'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Lokasi Kerja</label>
                                            <input type="text" value="{{ @$response['data']['lokasiKerja'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Pangkat Awal</label>
                                            <input type="text" value="{{ @$response['data']['pangkatAwal'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Golongan Awal</label>
                                            <input type="text" value="{{ @$response['data']['golRuangAwal'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Golongan Akhir</label>
                                            <input type="text" value="{{ @$response['data']['golRuangAkhir'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Pangkat Akhir</label>
                                            <input type="text" value="{{ @$response['data']['pangkatAkhir'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>TMT Golongan Akhir</label>
                                            <input type="text" value="{{ @$response['data']['tmtGolAkhir'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <!--
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Masa Kerja</label>
                                            <input type="text" value="{{ @$response['data']['masaKerja'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Eselon</label>
                                            <input type="text" value="{{ @$response['data']['eselon'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    -->
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Eselon</label>
                                            <input type="text" value="{{ @$response['data']['eselonLevel'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>TMT Eselon</label>
                                            <input type="text" value="{{ @$response['data']['tmtEselon'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Gaji Pokok</label>
                                            <input type="number" value="{{ @$response['data']['gajiPokok'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <!--
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nama KPKN</label>
                                            <input type="text" value="{{ @$response['data']['kpknNama'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>KtuaNama</label>
                                            <input type="text" value="{{ @$response['data']['ktuaNama'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    -->
                                    
                                    <!--
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nama Taspen</label>
                                            <input type="text" value="{{ @$response['data']['taspenNama'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    -->
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Status Perkawinan</label>
                                            <input type="text" value="{{ @$response['data']['statusPerkawinan'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <!--
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Status Hidup</label>
                                            <input type="text" value="{{ @$response['data']['statusHidup'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Tgl Surat Keterangan Dokter</label>
                                            <input type="text"
                                                value="{{ @$response['data']['tglSuratKeteranganDokter'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>No Surat Keterangan Dokter</label>
                                            <input type="text"
                                                value="{{ @$response['data']['noSuratKeteranganDokter'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Jumlah Istri/Suami</label>
                                            <input type="text" value="{{ @$response['data']['jumlahIstriSuami'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Jumlah Anak</label>
                                            <input type="text" value="{{ @$response['data']['jumlahAnak'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    -->
                                    
                                    <!--
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>No. Surat Keterangan Bebas Narkoba</label>
                                            <input type="text"
                                                value="{{ @$response['data']['noSuratKeteranganBebasNarkoba'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Tgl Surat Keterangan Bebas Narkoba</label>
                                            <input type="text"
                                                value="{{ @$response['data']['tglSuratKeteranganBebasNarkoba'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>SKCK</label>
                                            <input type="text" value="{{ @$response['data']['skck'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Tgl Skck</label>
                                            <input type="text" value="{{ @$response['data']['tglSkck'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Akte Kelahiran</label>
                                            <input type="text" value="{{ @$response['data']['akteKelahiran'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Akte Meninggal</label>
                                            <input type="text" value="{{ @$response['data']['akteMeninggal'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Tgl Meninggal</label>
                                            <input type="text" value="{{ @$response['data']['tglMeninggal'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    -->
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>No. NPWP</label>
                                            <input type="text" value="{{ @$response['data']['noNpwp'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Tgl NPWP</label>
                                            <input type="text" value="{{ @$response['data']['tglNpwp'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <!--
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>No Askes</label>
                                            <input type="text" value="{{ @$response['data']['noAskes'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>BPJS</label>
                                            <input type="text" value="{{ @$response['data']['bpjs'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Kode Pos</label>
                                            <input type="text" value="{{ @$response['data']['kodePos'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>No. SPMT</label>
                                            <input type="text" value="{{ @$response['data']['noSpmt'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Tgl SPMT</label>
                                            <input type="text" value="{{ @$response['data']['tglSpmt'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>No. Taspen</label>
                                            <input type="text" value="{{ @$response['data']['noTaspen'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Bahasa</label>
                                            <input type="text" value="{{ @$response['data']['bahasa'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    -->
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nama KPPN</label>
                                            <input type="text" value="{{ @$response['data']['kppnNama'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <!--
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Tgl STTPL</label>
                                            <input type="text" value="{{ @$response['data']['tglSttpl'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nomor STTPL</label>
                                            <input type="text" value="{{ @$response['data']['nomorSttpl'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Jenjang</label>
                                            <input type="text" value="{{ @$response['data']['jenjang'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Jabatan ASN</label>
                                            <input type="text" value="{{ @$response['data']['jabatanAsn'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    -->
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Kartu ASN</label>
                                            <input type="text" value="{{ @$response['data']['kartuAsn'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <!--
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>validNik</label>
                                            <input type="text" value="{{ @$response['data']['validNik'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    -->
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Jenjang Jabatan ASN</label>
                                            <input type="text" value="{{ @$response['data']['asnJenjangJabatan'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <!--
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Kode Jenjang Jabatan</label>
                                            <input type="text"
                                                value="{{ @$response['data']['kode_jenjang_jabatan'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    -->
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Level Jabatan</label>
                                            <input type="text" value="{{ @$response['data']['levelJabatan'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    
                                    <!--
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Tanggal Taspen</label>
                                            <input type="text" value="{{ @$response['data']['tanggal_taspen'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>tabrum2</label>
                                            <input type="text" value="{{ @$response['data']['tabrum2'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>kelas Jabatan</label>
                                            <input type="text" value="{{ @$response['data']['kelas_jabatan'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>karis_karsu</label>
                                            <input type="text" value="{{ @$response['data']['karis_karsu'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    {{-- <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Path</label>
                                            <input type="text" value="{{ @$response['data']['path'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div> --}}
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>genEmailAsn</label>
                                            <input type="text" value="{{ @$response['data']['genEmailAsn'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>pertekCpnsPnsl2thNomor</label>
                                            <input type="text"
                                                value="{{ @$response['data']['pertekCpnsPnsl2thNomor'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>pertekCpnsPnsl2thTanggal</label>
                                            <input type="text"
                                                value="{{ @$response['data']['pertekCpnsPnsl2thTanggal'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nomor Surat Keterangan Dokter</label>
                                            <input type="text"
                                                value="{{ @$response['data']['nomorSuratKeteranganDokter'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>SubJftId</label>
                                            <input type="text" value="{{ @$response['data']['subJftId'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>SubJftNama</label>
                                            <input type="text" value="{{ @$response['data']['subJftNama'] }}"
                                                placeholder="-" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    -->
                                </div>
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

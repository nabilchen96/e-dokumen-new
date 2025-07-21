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
                    <h3 class="font-weight-bold">Data Detail Profil Api SIASN</h3>
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
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>NIP Baru </label>
                                            <input type="text" value="{{ @$response['data']['nipBaru'] }}"
                                                placeholder="NIP Baru" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>NIP Lama </label>
                                            <input type="text" value="{{ @$response['data']['nipLama'] }}"
                                                placeholder="NIP Lama" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nama lengkap </label>
                                            <input type="text" value="{{ @$response['data']['nama'] }}"
                                                placeholder="Nama Lengkap" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Gelar Depan </label>
                                            <input type="text" value="{{ @$response['data']['gelarDepan'] }}"
                                                placeholder="Gelar Depan" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Gelar Belakang </label>
                                            <input type="text" value="{{ @$response['data']['gelarBelakang'] }}"
                                                placeholder="Gelar Belakang" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Tempat Lahir </label>
                                            <input type="text" value="{{ @$response['data']['tempatLahir'] }}"
                                                placeholder="Tempat Lahir" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Tanggal Lahir</label>
                                            <input type="text" value="{{ @$response['data']['tglLahir'] }}"
                                                placeholder="Tanggal Lahir" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Agama </label>
                                            <input type="text" value="{{ @$response['data']['agama'] }}"
                                                placeholder="Agama" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Email </label>
                                            <input type="text" value="{{ @$response['data']['email'] }}"
                                                placeholder="Email" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Email Gov </label>
                                            <input type="text" value="{{ @$response['data']['emailGov'] }}"
                                                placeholder="Email Gov" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>NIK</label>
                                            <input type="text" value="{{ @$response['data']['nik'] }}"
                                                placeholder="NIK" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Alamat</label>
                                            <input type="text" value="{{ @$response['data']['alamat'] }}"
                                                placeholder="Alamat" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>No. HP </label>
                                            <input type="text" value="{{ @$response['data']['noHp'] }}"
                                                placeholder="No. HP" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>No. Telp </label>
                                            <input type="text" value="{{ @$response['data']['noTelp'] }}"
                                                placeholder="No. Telp" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>MK Tahun </label>
                                            <input type="text" value="{{ @$response['data']['mkTahun'] }}"
                                                placeholder="MK Tahun" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>MK Bulan</label>
                                            <input type="text" value="{{ @$response['data']['mkBulan'] }}"
                                                placeholder="MK Bulan" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Jenis Pegawai </label>
                                            <input type="text" value="{{ @$response['data']['jenisPegawaiNama'] }}"
                                                placeholder="Jenis Pegawai" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Kedudukan PNS </label>
                                            <input type="text" value="{{ @$response['data']['kedudukanPnsNama'] }}"
                                                placeholder="Kedudukan PNS" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Status Pegawai </label>
                                            <input type="text" value="{{ @$response['data']['statusPegawai'] }}"
                                                placeholder="Status Pegawai" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>jenis Kelamin </label>
                                            <input type="text" value="{{ @$response['data']['jenisKelamin'] }}"
                                                placeholder="jenis Kelamin" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>JenisIdDokumenNama </label>
                                            <input type="text" value="{{ @$response['data']['jenisIdDokumenNama'] }}"
                                                placeholder="JenisIdDokumenNama" class="form-control form-control-sm"
                                                required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>NomorIdDocument</label>
                                            <input type="text" value="{{ @$response['data']['nomorIdDocument'] }}"
                                                placeholder="NomorIdDocument" class="form-control form-control-sm"
                                                required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>No. Seri Karpeg </label>
                                            <input type="text" value="{{ @$response['data']['noSeriKarpeg'] }}"
                                                placeholder="No. Seri Karpeg" class="form-control form-control-sm"
                                                required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Jenjang Pendidikan Terkahir</label>
                                            <input type="text"
                                                value="{{ @$response['data']['tkPendidikanTerakhir'] }}"
                                                placeholder="Pendidikan Terkahir" class="form-control form-control-sm"
                                                required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Pendidikan Terkahir</label>
                                            <input type="text"
                                                value="{{ @$response['data']['pendidikanTerkahirNama'] }}"
                                                placeholder="Pendidikan Terakhir" class="form-control form-control-sm"
                                                required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Tahun Lulus </label>
                                            <input type="text" value="{{ @$response['data']['tahunLulus'] }}"
                                                placeholder="Tahun Lulus" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>TMT PNS </label>
                                            <input type="text" value="{{ @$response['data']['tmtPns'] }}"
                                                placeholder="TMT PNS" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>TMT Pensiun </label>
                                            <input type="text" value="{{ @$response['data']['tmtPensiun'] }}"
                                                placeholder="TMT Pensiun" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>buppensiun</label>
                                            <input type="text" value="{{ @$response['data']['bupPensiun'] }}"
                                                placeholder="buppensiun" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Tgl SK PNS </label>
                                            <input type="text" value="{{ @$response['data']['tglSkPns'] }}"
                                                placeholder="Tgl SK PNS" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>TMT CPNS </label>
                                            <input type="text" value="{{ @$response['data']['tmtCpns'] }}"
                                                placeholder="TMT CPNS" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Tgl SK CPNS</label>
                                            <input type="text" value="{{ @$response['data']['tglSkCpns'] }}"
                                                placeholder="Tgl SK CPNS" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nama Instansi Induk </label>
                                            <input type="text" value="{{ @$response['data']['instansiIndukNama'] }}"
                                                placeholder="Nama Instansi Induk" class="form-control form-control-sm"
                                                required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nama Satuan Kerja Induk</label>
                                            <input type="text"
                                                value="{{ @$response['data']['satuanKerjaIndukNama'] }}"
                                                placeholder="Nama Satuan Kerja Induk" class="form-control form-control-sm"
                                                required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nama Kanreg </label>
                                            <input type="text" value="{{ @$response['data']['kanregNama'] }}"
                                                placeholder="Nama Kanreg" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nama Instansi Kerja </label>
                                            <input type="text" value="{{ @$response['data']['instansiKerjaNama'] }}"
                                                placeholder="Nama Instansi Kerja" class="form-control form-control-sm"
                                                required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Kode Instansi Kerja </label>
                                            <input type="text"
                                                value="{{ @$response['data']['instansiKerjaKodeCepat'] }}"
                                                placeholder="Kode Instansi Kerja" class="form-control form-control-sm"
                                                required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nama Satuan Kerja </label>
                                            <input type="text"
                                                value="{{ @$response['data']['satuanKerjaKerjaNama'] }}"
                                                placeholder="Nama Satuan Kerja" class="form-control form-control-sm"
                                                required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nama Unor </label>
                                            <input type="text" value="{{ @$response['data']['unorNama'] }}"
                                                placeholder="Nama Unor" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nama Unor Induk </label>
                                            <input type="text" value="{{ @$response['data']['unorIndukNama'] }}"
                                                placeholder="Nama Unor Induk" class="form-control form-control-sm"
                                                required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Jenis Jabatan</label>
                                            <input type="text" value="{{ @$response['data']['jenisJabatan'] }}"
                                                placeholder="jenis Jabatan" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nama Jabatan </label>
                                            <input type="text" value="{{ @$response['data']['jabatanNama'] }}"
                                                placeholder="Nama Jabatan" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nama Jabatan Struktural </label>
                                            <input type="text"
                                                value="{{ @$response['data']['jabatanStrukturalNama'] }}"
                                                placeholder="Nama Jabatan Struktural" class="form-control form-control-sm"
                                                required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nama Jabatan Fungsiopnal </label>
                                            <input type="text"
                                                value="{{ @$response['data']['jabatanFungsionalNama'] }}"
                                                placeholder="Nama Jabatan Fungsional" class="form-control form-control-sm"
                                                required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nama Jabatan Fungsional Umum </label>
                                            <input type="text"
                                                value="{{ @$response['data']['jabatanFungsionalUmumNama'] }}"
                                                placeholder="Nama Jabatan Fungsional Umum"
                                                class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>TMT Jabatan </label>
                                            <input type="text" value="{{ @$response['data']['tmtJabatan'] }}"
                                                placeholder="TMT Jabatan" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Lokasi Kerja</label>
                                            <input type="text" value="{{ @$response['data']['lokasiKerja'] }}"
                                                placeholder="Lokasi Kerja" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Golongan Awal</label>
                                            <input type="text" value="{{ @$response['data']['golRuangAwal'] }}"
                                                placeholder="Golongan Awal" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Golongan Akhir</label>
                                            <input type="text" value="{{ @$response['data']['golRuangAkhir'] }}"
                                                placeholder="Golongan Akhir" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>TMT Golongan Akhir</label>
                                            <input type="text" value="{{ @$response['data']['tmtGolAkhir'] }}"
                                                placeholder="TMT Golongan Akhir" class="form-control form-control-sm"
                                                required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Masa Kerja</label>
                                            <input type="text" value="{{ @$response['data']['masaKerja'] }}"
                                                placeholder="Masa Kerja" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Eselon</label>
                                            <input type="text" value="{{ @$response['data']['eselon'] }}"
                                                placeholder="Eselon" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Eselon Level</label>
                                            <input type="text" value="{{ @$response['data']['eselonLevel'] }}"
                                                placeholder="Eselon Level" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>TMT Eselon</label>
                                            <input type="text" value="{{ @$response['data']['tmtEselon'] }}"
                                                placeholder="TMT Eselon" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Gaji Pokok</label>
                                            <input type="text" value="{{ @$response['data']['gajiPokok'] }}"
                                                placeholder="Gaji Pokok" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nama KPKN</label>
                                            <input type="text" value="{{ @$response['data']['kpknNama'] }}"
                                                placeholder="Nama KPKN" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>KtuaNama</label>
                                            <input type="text" value="{{ @$response['data']['ktuaNama'] }}"
                                                placeholder="KtuaNama" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nama Taspen</label>
                                            <input type="text" value="{{ @$response['data']['taspenNama'] }}"
                                                placeholder="Nama Taspen" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Status Perkawinan</label>
                                            <input type="text" value="{{ @$response['data']['statusPerkawinan'] }}"
                                                placeholder="Status Perkawinan" class="form-control form-control-sm"
                                                required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Status Hidup</label>
                                            <input type="text" value="{{ @$response['data']['statusHidup'] }}"
                                                placeholder="Status Hidup" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Tgl Surat Keterangan Dokter</label>
                                            <input type="text"
                                                value="{{ @$response['data']['tglSuratKeteranganDokter'] }}"
                                                placeholder="Tgl Surat Keterangan Dokter"
                                                class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>No Surat Keterangan Dokter</label>
                                            <input type="text"
                                                value="{{ @$response['data']['noSuratKeteranganDokter'] }}"
                                                placeholder="No Surat Keterangan Dokter"
                                                class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Jumlah Istri/Suami</label>
                                            <input type="text" value="{{ @$response['data']['jumlahIstriSuami'] }}"
                                                placeholder="Jumlah Istri/Suami" class="form-control form-control-sm"
                                                required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Jumlah Anak</label>
                                            <input type="text" value="{{ @$response['data']['jumlahAnak'] }}"
                                                placeholder="Jumlah Anak" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>No. Surat Keterangan Bebas Narkoba</label>
                                            <input type="text"
                                                value="{{ @$response['data']['noSuratKeteranganBebasNarkoba'] }}"
                                                placeholder="No. Surat Keterangan Bebas Narkoba"
                                                class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Tgl Surat Keterangan Bebas Narkoba</label>
                                            <input type="text"
                                                value="{{ @$response['data']['tglSuratKeteranganBebasNarkoba'] }}"
                                                placeholder="Tgl Surat Keterangan Bebas Narkoba"
                                                class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>SKCK</label>
                                            <input type="text" value="{{ @$response['data']['skck'] }}"
                                                placeholder="SKCK" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Tgl Skck</label>
                                            <input type="text" value="{{ @$response['data']['tglSkck'] }}"
                                                placeholder="Tgl Skck" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Akte Kelahiran</label>
                                            <input type="text" value="{{ @$response['data']['akteKelahiran'] }}"
                                                placeholder="Akte Kelahiran" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Akte Meninggal</label>
                                            <input type="text" value="{{ @$response['data']['akteMeninggal'] }}"
                                                placeholder="Akte Meninggal" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Tgl Meninggal</label>
                                            <input type="text" value="{{ @$response['data']['tglMeninggal'] }}"
                                                placeholder="Tgl Meninggal" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>No. NPWP</label>
                                            <input type="text" value="{{ @$response['data']['noNpwp'] }}"
                                                placeholder="No. NPWP" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Tgl NPWP</label>
                                            <input type="text" value="{{ @$response['data']['tglNpwp'] }}"
                                                placeholder="Tgl NPWP" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>No Askes</label>
                                            <input type="text" value="{{ @$response['data']['noAskes'] }}"
                                                placeholder="No Askes" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>BPJS</label>
                                            <input type="text" value="{{ @$response['data']['bpjs'] }}"
                                                placeholder="BPJS" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Kode Pos</label>
                                            <input type="text" value="{{ @$response['data']['kodePos'] }}"
                                                placeholder="Kode Pos" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>No. SPMT</label>
                                            <input type="text" value="{{ @$response['data']['noSpmt'] }}"
                                                placeholder="No. SPMT" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Tgl SPMT</label>
                                            <input type="text" value="{{ @$response['data']['tglSpmt'] }}"
                                                placeholder="Tgl SPMT" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>No. Taspen</label>
                                            <input type="text" value="{{ @$response['data']['noTaspen'] }}"
                                                placeholder="No. Taspen" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Bahasa</label>
                                            <input type="text" value="{{ @$response['data']['bahasa'] }}"
                                                placeholder="Bahasa" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nama KPPN</label>
                                            <input type="text" value="{{ @$response['data']['kppnNama'] }}"
                                                placeholder="Nama KPPN" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Pangkat Akhir</label>
                                            <input type="text" value="{{ @$response['data']['pangkatAkhir'] }}"
                                                placeholder="Pangkat Akhir" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Tgl STTPL</label>
                                            <input type="text" value="{{ @$response['data']['tglSttpl'] }}"
                                                placeholder="Tgl STTPL" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nomor STTPL</label>
                                            <input type="text" value="{{ @$response['data']['nomorSttpl'] }}"
                                                placeholder="Nomor STTPL" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nomor SK CPNS</label>
                                            <input type="text" value="{{ @$response['data']['nomorSkCpns'] }}"
                                                placeholder="Nomor SK CPNS" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nomor SK PNS</label>
                                            <input type="text" value="{{ @$response['data']['nomorSkPns'] }}"
                                                placeholder="Nomor SK PNS" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Jenjang</label>
                                            <input type="text" value="{{ @$response['data']['jenjang'] }}"
                                                placeholder="Jenjang" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>jabatan ASN</label>
                                            <input type="text" value="{{ @$response['data']['jabatanAsn'] }}"
                                                placeholder="jabatan ASN" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Kartu ASN</label>
                                            <input type="text" value="{{ @$response['data']['kartuAsn'] }}"
                                                placeholder="Kartu ASN" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>validNik</label>
                                            <input type="text" value="{{ @$response['data']['validNik'] }}"
                                                placeholder="validNik" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Pangkat Awal</label>
                                            <input type="text" value="{{ @$response['data']['pangkatAwal'] }}"
                                                placeholder="Pangkat Awal" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Jenjang Jabatan ASN</label>
                                            <input type="text" value="{{ @$response['data']['asnJenjangJabatan'] }}"
                                                placeholder="Jenjang Jabatan ASN" class="form-control form-control-sm"
                                                required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Kode Jenjang Jabatan</label>
                                            <input type="text"
                                                value="{{ @$response['data']['kode_jenjang_jabatan'] }}"
                                                placeholder="Kode Jenjang Jabatan" class="form-control form-control-sm"
                                                required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Level Jabatan</label>
                                            <input type="text" value="{{ @$response['data']['levelJabatan'] }}"
                                                placeholder="Level Jabatan" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Tanggal Taspen</label>
                                            <input type="text" value="{{ @$response['data']['tanggal_taspen'] }}"
                                                placeholder="Tanggal Taspen" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>tabrum2</label>
                                            <input type="text" value="{{ @$response['data']['tabrum2'] }}"
                                                placeholder="tabrum2" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>kelas Jabatan</label>
                                            <input type="text" value="{{ @$response['data']['kelas_jabatan'] }}"
                                                placeholder="kelas  Jabatan" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>karis_karsu</label>
                                            <input type="text" value="{{ @$response['data']['karis_karsu'] }}"
                                                placeholder="karis_karsu" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    {{-- <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Path</label>
                                            <input type="text" value="{{ @$response['data']['path'] }}"
                                                placeholder="Path" class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div> --}}
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>genEmailAsn</label>
                                            <input type="text" value="{{ @$response['data']['genEmailAsn'] }}"
                                                placeholder="genEmailAsn" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>pertekCpnsPnsl2thNomor</label>
                                            <input type="text"
                                                value="{{ @$response['data']['pertekCpnsPnsl2thNomor'] }}"
                                                placeholder="pertekCpnsPnsl2thNomor" class="form-control form-control-sm"
                                                required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>pertekCpnsPnsl2thTanggal</label>
                                            <input type="text"
                                                value="{{ @$response['data']['pertekCpnsPnsl2thTanggal'] }}"
                                                placeholder="pertekCpnsPnsl2thTanggal"
                                                class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nomor Surat Keterangan Dokter</label>
                                            <input type="text"
                                                value="{{ @$response['data']['nomorSuratKeteranganDokter'] }}"
                                                placeholder="Nomor Surat Keterangan Dokter"
                                                class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>SubJftId</label>
                                            <input type="text" value="{{ @$response['data']['subJftId'] }}"
                                                placeholder="SubJftId" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>SubJftNama</label>
                                            <input type="text" value="{{ @$response['data']['subJftNama'] }}"
                                                placeholder="SubJftNama" class="form-control form-control-sm" required
                                                readonly>
                                        </div>
                                    </div>
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

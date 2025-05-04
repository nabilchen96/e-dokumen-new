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
            white-space: nowrap !important;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
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
                <h3 class="font-weight-bold">Form Dokumen Kenaikan Gaji</h3>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 mt-4">
        <div class="card w-100">
            <div class="card-body">
                @php
                    $instansi = DB::table('instansis')->where('status', 'Aktif')->first();
                    $kenaikan_gaji = DB::table('kenaikan_gajis')->where('id', Request('data'))->first();
                    $pegawai = DB::table('profils')
                        ->leftjoin('users', 'users.id', '=', 'profils.id_user')
                        ->where('profils.id', $kenaikan_gaji->id_profil)
                        ->select(
                            'users.name',
                            'profils.tanggal_lahir',
                            'profils.nip',
                            'profils.id_user',
                            'profils.pangkat',
                            'profils.jabatan',
                            'profils.id'
                        )
                        ->first();
                    $kantor = DB::table('dokumens')
                        ->leftjoin('users', 'users.id', '=', 'dokumens.id_user')
                        ->leftjoin('skpds', 'skpds.id', '=', 'dokumens.id_skpd')
                        ->where('users.id', $pegawai->id_user)
                        ->select(
                            'skpds.nama_skpd'
                        )
                        ->get()
                        ->last();

                    $gaji_lama = DB::table('kenaikan_gajis')
                        ->where('id_profil', $kenaikan_gaji->id_profil)
                        ->where('id', '<', $kenaikan_gaji->id)
                        ->orderBy('id', 'desc')
                        ->first();

                    $instansi2 = DB::table('instansis')
                        ->join('profils', 'profils.id', '=', 'instansis.id_profil')
                        ->join('users', 'users.id', '=', 'profils.id_user')
                        ->select(
                            'profils.*',
                            'users.name'
                        )
                        ->orderBy('instansis.status', 'ASC')
                        ->get();
                @endphp
                <div class="table-responsive">
                    <table width="100%">
                        <tr>
                            <td width="5%"></td>
                            <td colspan="2">
                                <div class="alert alert-info">
                                    <h5 style="line-height: 1.2em;">Beberapa data sudah terisi berdasarkan data kenaikan
                                        gaji sebelumnya (jika
                                        sebelumnya sudah membuat data kenaikan gaji). <br> Silahkan edit
                                        dan pastikan data sudah sesuai sebelum disubmit. Hanya admin dan user yang memiliki otoritas yang dapat mengedit
                                    </h5>
                                </div>
                                <br>
                            </td>
                            <td width="5%"></td>
                        </tr>
                        <tr>
                            <td width="5%"></td>
                            <td width="10%">
                                <img src="{{ asset('ilanding/logo.png') }}" style="width: 100%; height: 135px;" alt="">
                            </td>
                            <td class="text-center">
                                <span style="font-size: 18px; font-family: 'Times New Roman', Times, serif;">PEMERINTAH
                                    KABUPATEN BENGKULU UTARA <br></span>
                                <span style="font-size: 25px; font-family: 'Times New Roman', Times, serif;">
                                    <b>BADAN KEPEGAWAIAN DAN PENGEMBANGAN <br>
                                        SUMBER DAYA MANUSIA</b> <br>
                                </span>
                                <i style="font-family: 'Times New Roman', Times, serif;">Jln. DR.M.Hatta Nomor 11
                                    Telp/Fax {{ @$instansi->telp_fax }} Arga Makmur Kode Pos {{ @$instansi->kode_pos }}
                                    <br>
                                    Laman: {{ @$instansi->website }}, Pos-el: {{ @$instansi->email }}
                                </i>
                            </td>
                            <td width="5%"></td>
                        </tr>
                        <tr>
                            <td width="5%"></td>
                            <td width="10%" colspan="2">
                                <hr style="border-top: 3px solid black;">
                                <hr style="border-top: 1px solid black; margin-top: -15px;">
                            </td>
                            <td width="5%"></td>
                        </tr>
                    </table>
                    <form id="form">
                        <input {{ in_array(Auth::user()->role, ['Admin', 'OPD', 'SKPD']) ? '' : 'readonly' }} required type="hidden" name="id"
                            id="id" value="{{ Request('data') }}">
                        <input {{ in_array(Auth::user()->role, ['Admin', 'OPD', 'SKPD']) ? '' : 'readonly' }} required type="hidden"
                            name="id_profil" id="id_profil" value="{{ @$pegawai->id }}">
                        <table width="100%">
                            <tr>
                                <td width="5%"></td>
                                <td width="10%"></td>
                                <td></td>
                                <td width="35%"></td>
                                <td width="5%"></td>
                                <td width="11%">Arga Makmur, </td>
                                <td>
                                    <input {{ in_array(Auth::user()->role, ['Admin', 'OPD', 'SKPD']) ? '' : 'readonly' }} required type="date"
                                        id="tgl_dokumen" name="tgl_dokumen" class="form-control border-danger"
                                        value="{{ $kenaikan_gaji->tgl_dokumen ?? date('Y-m-d') }}">
                                </td>
                                <td width="10%"></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td width="10%">Nomor</td>
                                <td>:</td>
                                <td>
                                    <input {{ in_array(Auth::user()->role, ['Admin', 'OPD', 'SKPD']) ? '' : 'readonly' }} required type="text"
                                        placeholder="Nomor" id="no_dokumen" name="no_dokumen"
                                        value="{{ @$kenaikan_gaji->no_dokumen }}" class="form-control border-danger">
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td width="10%">Lampiran</td>
                                <td>:</td>
                                <td>
                                    <input {{ in_array(Auth::user()->role, ['Admin', 'OPD', 'SKPD']) ? '' : 'readonly' }} required type="text"
                                        id="lampiran" name="lampiran" value="{{ @$kenaikan_gaji->lampiran ?? '-' }}"
                                        class="form-control border-danger">
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td width="10%">Hal</td>
                                <td>:</td>
                                <td>Kenaikan Gaji Berkala</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                        <br>
                        <table width="100%">
                            <tr>
                                <td width="5%"></td>
                                <td colspan="2">
                                    Kepada Yth. <br>
                                    Kepala Badan Keuangan dan Aset Daerah <br>
                                    Kabupaten bengkulu Utara
                                </td>
                                <td width="5%"></td>
                                <td width="11%"></td>
                                <td></td>
                                <td width="10%"></td>
                            </tr>
                        </table>
                        <br>
                        <table width="100%">
                            <tr>
                                <td width="15%">
                                </td>
                                <td width="40%">
                                    <b>Arga Makmur</b>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td width="10%"></td>
                            </tr>
                            <tr>
                                <td width="10%">
                                </td>
                                <td width="40%">
                                    <br>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td width="10%">
                                </td>
                                <td colspan="4" style="text-align: justify !important;">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kepala Badan Kepegawaian dan
                                    Pengembangan Sumber Daya Manusia Kabupaten <br>
                                    Bengkulu Utara dengan ini memberitahukan bahwa berhubung telah dipenuhinya masa
                                    kerja
                                    dan
                                    <br>
                                    syarat-syarat lainnya maka kepada:
                                    <br><br>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td width="10%">

                                </td>
                                <td width="40%">
                                    1. Nama dan Tanggal Lahir
                                </td>
                                <td width="1%">
                                    :
                                </td>
                                <td>
                                    <input {{ in_array(Auth::user()->role, ['Admin', 'OPD', 'SKPD']) ? '' : 'readonly' }} required type="text"
                                        class="form-control border-danger" value="{{ @$pegawai->name }}">
                                </td>
                                <td>
                                    <input {{ in_array(Auth::user()->role, ['Admin', 'OPD', 'SKPD']) ? '' : 'readonly' }} required type="date"
                                        class="form-control border-danger" value="{{ @$pegawai->tanggal_lahir }}">
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td width="10%">

                                </td>
                                <td width="40%">
                                    2. Nomor Induk Pegawai
                                </td>
                                <td width="1%">
                                    :
                                </td>
                                <td colspan="2">
                                    <input {{ in_array(Auth::user()->role, ['Admin', 'OPD', 'SKPD']) ? '' : 'readonly' }} required type="text"
                                        class="form-control border-danger" value="{{ @$pegawai->nip }}">
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td width="10%">

                                </td>
                                <td width="40%">
                                    3. Pangkat / Jabatan
                                </td>
                                <td width="1%">
                                    :
                                </td>
                                <td>
                                    @php
                                        if (@$pegawai->pangkat) {
                                            $pangkat = explode(" - ", @$pegawai->pangkat);
                                        }
                                    @endphp
                                    <input {{ in_array(Auth::user()->role, ['Admin', 'OPD', 'SKPD']) ? '' : 'readonly' }} required type="text"
                                        name="pangkat" id="pangkat" class="form-control border-danger"
                                        value="{{ @$kenaikan_gaji->pangkat ?? @$pangkat[1] }}" placeholder="Pangkat">
                                </td>
                                <td>
                                    <input {{ in_array(Auth::user()->role, ['Admin', 'OPD', 'SKPD']) ? '' : 'readonly' }} required type="text"
                                        name="jabatan" id="jabatan" class="form-control border-danger"
                                        value="{{ @$kenaikan_gaji->jabatan ?? @$pegawai->jabatan }}"
                                        placeholder="Jabatan">
                                </td>
                            </tr>
                            <tr>
                                <td width="10%">

                                </td>
                                <td width="40%">
                                    4. Kantor / Tempat Bekerja
                                </td>
                                <td width="1%">
                                    :
                                </td>
                                <td colspan="2">
                                    <input {{ in_array(Auth::user()->role, ['Admin', 'OPD', 'SKPD']) ? '' : 'readonly' }} required type="text"
                                        name="skpd" id="skpd" class="form-control border-danger"
                                        value="{{ @$kenaikan_gaji->skpd ?? @$kantor->nama_skpd }}"
                                        placeholder="Kantor/Tempat Bekerja">
                                </td>
                            </tr>
                            <tr>
                                <td width="10%">

                                </td>
                                <td width="40%">
                                    5. Gaji Pokok Lama
                                </td>
                                <td width="1%">
                                    :
                                </td>
                                <td colspan="2">
                                    <input {{ in_array(Auth::user()->role, ['Admin', 'OPD', 'SKPD']) ? '' : 'readonly' }} required type="number"
                                        name="gaji_pokok_lama" id="gaji_pokok_lama" class="form-control border-danger"
                                        value="{{ @$kenaikan_gaji->gaji_pokok_lama ?? @$gaji_lama->gaji_pokok_baru }}"
                                        placeholder="Gaji Pokok Lama">
                                </td>
                            </tr>
                            <tr>
                                <td width="10%">

                                </td>
                                <td colspan="4">
                                    atas dasar surat keputusan terakhir tentang gaji/pangkat yang ditetapkan:
                                </td>
                            </tr>
                            <tr>
                                <td width="10%">

                                </td>
                                <td width="40%">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a. Oleh Pejabat
                                </td>
                                <td width="1%">
                                    :
                                </td>
                                <td colspan="2">
                                    <input {{ in_array(Auth::user()->role, ['Admin', 'OPD', 'SKPD']) ? '' : 'readonly' }} required type="text"
                                        name="oleh_pejabat" id="oleh_pejabat" class="form-control border-danger"
                                        value="{{ @$kenaikan_gaji->oleh_pejabat ?? @$gaji_lama->oleh_pejabat }}"
                                        placeholder="Oleh Pejabat">
                                </td>
                            </tr>
                            <tr>
                                <td width="10%">

                                </td>
                                <td width="40%">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;b. Tanggal dan Nomor
                                </td>
                                <td width="1%">
                                    :
                                </td>
                                <td>
                                    <input {{ in_array(Auth::user()->role, ['Admin', 'OPD', 'SKPD']) ? '' : 'readonly' }} required type="date"
                                        name="tgl_dokumen_sebelumnya" id="tgl_dokumen_sebelumnya"
                                        value="{{ @$kenaikan_gaji->tgl_dokumen_sebelumnya ?? @$gaji_lama->tgl_dokumen_sebelumnya }}"
                                        class="form-control border-danger">
                                </td>
                                <td>
                                    <input {{ in_array(Auth::user()->role, ['Admin', 'OPD', 'SKPD']) ? '' : 'readonly' }} required type="text"
                                        name="no_dokumen_sebelumnya" id="no_dokumen_sebelumnya"
                                        class="form-control border-danger"
                                        value="{{ @$kenaikan_gaji->no_dokumen_sebelumnya ?? @$gaji_lama->no_dokumen_sebelumnya }}"
                                        placeholder="Nomor">
                                </td>
                            </tr>
                            <tr>
                                <td width="10%">

                                </td>
                                <td width="40%">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;c. Tanggal berlakunya gaji tersebut
                                </td>
                                <td width="1%">
                                    :
                                </td>
                                <td colspan="2">
                                    <input {{ in_array(Auth::user()->role, ['Admin', 'OPD', 'SKPD']) ? '' : 'readonly' }} required type="date"
                                        name="tgl_berlaku_gaji" id="tgl_berlaku_gaji" class="form-control border-danger"
                                        value="{{ @$kenaikan_gaji->tgl_berlaku_gaji ?? @$gaji_lama->tgl_terhitung_mulai }}">
                                </td>
                            </tr>
                            <tr>
                                <td width="10%">

                                </td>
                                <td width="40%">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;d. Masa Kerja gol. pada tgl tersebut
                                </td>
                                <td width="1%">
                                    :
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input {{ in_array(Auth::user()->role, ['Admin', 'OPD', 'SKPD']) ? '' : 'readonly' }} required
                                            type="number" class="form-control border-danger" placeholder="Tahun"
                                            pattern="^[0-9]{2}$" maxlength="2"
                                            value="{{ @$kenaikan_gaji->masa_kerja_tahun_sebelumnya ?? @$gaji_lama->masa_kerja_tahun_baru }}"
                                            id="masa_kerja_tahun_sebelumnya" name="masa_kerja_tahun_sebelumnya">
                                        <span style="height: 38px;" class="input-group-text border-danger"
                                            id="basic-addon2">Tahun</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input {{ in_array(Auth::user()->role, ['Admin', 'OPD', 'SKPD']) ? '' : 'readonly' }} required
                                            type="number" class="form-control border-danger" placeholder="Bulan"
                                            id="masa_kerja_bulan_sebelumnya"
                                            value="{{ @$kenaikan_gaji->masa_kerja_bulan_sebelumnya ?? @$gaji_lama->masa_kerja_bulan_baru }}"
                                            name="masa_kerja_bulan_sebelumnya" pattern="^[0-9]{2}$" maxlength="2">
                                        <span style="height: 38px;" class="input-group-text border-danger"
                                            id="basic-addon2">Bulan</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td width="10%">

                                </td>
                                <td colspan="4">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Diberikan kenaikan gaji berkala hingga
                                        memperoleh:</u>
                                </td>
                            </tr>
                            <tr>
                                <td width="10%">

                                </td>
                                <td width="40%">
                                    6. Gaji Pokok Baru
                                </td>
                                <td width="1%">
                                    :
                                </td>
                                <td colspan="2">
                                    <input {{ in_array(Auth::user()->role, ['Admin', 'OPD', 'SKPD']) ? '' : 'readonly' }} required type="number"
                                        name="gaji_pokok_baru" id="gaji_pokok_baru" class="form-control border-danger"
                                        value="{{ @$kenaikan_gaji->gaji_pokok_baru }}" placeholder="Gaji Pokok Baru">
                                </td>

                            </tr>
                            <tr>
                                <td width="10%">

                                </td>
                                <td width="40%">
                                    7. Berdasarkan Masa Kerja
                                </td>
                                <td width="1%">
                                    :
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input {{ in_array(Auth::user()->role, ['Admin', 'OPD', 'SKPD']) ? '' : 'readonly' }} required
                                            type="number" class="form-control border-danger" placeholder="Tahun" value="{{ @$kenaikan_gaji->masa_kerja_tahun_baru ??
    @$gaji_lama->masa_kerja_tahun_baru ? @$gaji_lama->masa_kerja_tahun_baru + 2 : 0 }}" id="masa_kerja_tahun_baru"
                                            name="masa_kerja_tahun_baru" pattern="^[0-9]{2}$" maxlength="2">
                                        <span style="height: 38px;" class="input-group-text border-danger"
                                            id="basic-addon2">Tahun</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input {{ in_array(Auth::user()->role, ['Admin', 'OPD', 'SKPD']) ? '' : 'readonly' }} required
                                            type="number" class="form-control border-danger" placeholder="Bulan"
                                            value="{{ @$kenaikan_gaji->masa_kerja_bulan_baru ?? 0 }}"
                                            id="masa_kerja_bulan_baru" name="masa_kerja_bulan_baru" pattern="^[0-9]{2}$"
                                            maxlength="2">
                                        <span style="height: 38px;" class="input-group-text border-danger"
                                            id="basic-addon2">Bulan</span>
                                    </div>
                                </td>

                            </tr>
                            <tr>
                                <td width="10%">

                                </td>
                                <td width="40%">
                                    8. Dalam Golongan
                                </td>
                                <td width="1%">
                                    :
                                </td>
                                <td colspan="2">
                                    <input {{ in_array(Auth::user()->role, ['Admin', 'OPD', 'SKPD']) ? '' : 'readonly' }} required type="text"
                                        placeholder="Dalam Golongan" class="form-control border-danger"
                                        value="{{ @$kenaikan_gaji->golongan ?? @$pangkat[0] }}">
                                </td>

                            </tr>
                            <tr>
                                <td width="10%">

                                </td>
                                <td width="40%">
                                    9. Terhitung Mulai Tanggal
                                </td>
                                <td width="1%">
                                    :
                                </td>
                                <td colspan="2">
                                    <input {{ in_array(Auth::user()->role, ['Admin', 'OPD', 'SKPD']) ? '' : 'readonly' }} required type="date"
                                        name="tgl_terhitung_mulai" id="tgl_terhitung_mulai"
                                        class="form-control border-danger"
                                        value="{{ @$kenaikan_gaji->tgl_terhitung_mulai }}">
                                </td>

                            </tr>
                            <tr>
                                <td width="10%">

                                </td>
                                <td width="40%">
                                    10. Keterangan
                                </td>
                                <td width="1%">
                                    :
                                </td>
                                <td colspan="2">
                                    a. Ybs adalah PNS Daerah
                                </td>

                            </tr>
                            <tr>
                                <td width="10%">

                                </td>
                                <td width="40%">

                                </td>
                                <td width="1%">

                                </td>
                                <td colspan="2">
                                    b. Kenaikan gaji berkala berikutnya pada tanggal
                                    <input {{ in_array(Auth::user()->role, ['Admin', 'OPD', 'SKPD']) ? '' : 'readonly' }} required type="date"
                                        name="tgl_kenaikan_berikutnya" readonly id="tgl_kenaikan_berikutnya"
                                        value="{{ @$kenaikan_gaji->tgl_kenaikan_berikutnya }}"
                                        class="form-control border-danger">
                                </td>

                            </tr>
                            <tr>
                                <td width="10%">
                                </td>
                                <td colspan="4" style="text-align: justify !important;">
                                    <br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    Diharapkan agar sesuai dengan Peraturan Pemerintah Nomor 5 Tahun 2024 tentang <br>
                                    Perubahan ke Sembilan Belas atas Peraturan Pemerintah Nomor 7 Tahun 1977, kepada
                                    Pegawai
                                    <br>
                                    tersebut dapat dibayarkan penghasilannya berdasarkan gaji pokoknya yang baru.
                                </td>
                            </tr>
                        </table>
                        <table width="100%" class="mt-5">
                            <tr>
                                <td width="50%"></td>
                                <td width="50%" class="text-center">
                                    KEPALA BADAN KEPEGAWAIAN DAN <br>
                                    PENGEMBANGAN SUMBER DAYA MANUSIA <br>
                                    KABUPATEN BENGKULU UTARA
                                </td>
                            </tr>
                            <tr>
                                <td width="50%"></td>
                                <td width="50%" class="text-center" style="font-size: 16px;">
                                    <br><br><br><br>
                                </td>
                            </tr>
                            <tr>
                                <td width="50%"></td>
                                <td width="50%" class="text-center" style="font-size: 16px;">
                                    <b>Pilih Kepala Badan Kepegawaian:</b>
                                    <div class="d-flex justify-content-center">
                                        <select {{ Auth::user()->role != 'Admin' ? 'disabled' : ''}} required
                                            style="width: 50%" name="id_profil_kepala" id="id_profil_kepala"
                                            class="border-danger form-control">
                                            @foreach ($instansi2 as $k)
                                                <option {{ @$kenaikan_gaji->id_profil_kepala == $k->id ? 'selected' : '' }}
                                                    value="{{ $k->id }}">{{ $k->name }} - {{ $k->pangkat }} - NIP:
                                                    {{ $k->nip }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <br><br>
                                </td>
                            </tr>
                        </table>
                        <table width="100%">
                            <tr>
                                <td width="5%"></td>
                                <td width="50%">
                                    <u>Tembusan disampaikan kepada Yth:</u> <br>
                                    1. Bupati Bengkulu Utara <br>
                                    2. Kepala BKN Regional VII Palembang <br>
                                    3. Inspektur Kabupaten Bengkulu Utara di Arga Makmur <br>
                                    4. Kepala Cabang PT. Taspen(Persero) Bengkulu di Bengkulu <br>
                                    5. Bendaharawan Gaji PNS yang bersangkutan <br>
                                    6. Pegawai yang bersangkutan <br> <br>
                                    @if (Auth::user()->role == 'Admin' || Auth::user()->role == 'SKPD' || Auth::user()->role == 'OPD')
                                        <label><b>Status Dokumen:</b></label>
                                        <select required style="width: 50%" name="status" id="status"
                                            class="border-danger form-control">
                                            <option {{ $kenaikan_gaji->status == 'Draft' ? 'selected' : ''}}>Draft</option>
                                            <option {{ $kenaikan_gaji->status == 'Rilis' ? 'selected' : ''}}>Rilis</option>
                                        </select>
                                    @endif
                                </td>
                                <td width="50%" class="text-center" style="font-size: 16px;">

                                </td>
                            </tr>
                        </table>
                        <br><br>
                        <hr>
                        <table width="100%">
                            <tr>
                                <td width="5%"></td>
                                <td>
                                    @if (Auth::user()->role == 'Admin' || Auth::user()->role == 'SKPD' || Auth::user()->role == 'OPD')
                                        <button id="tombol_kirim" class="btn btn-primary"
                                            style="border-radius: 8px !important;">Submit</button>
                                    @endif
                                    <a class="btn btn-warning" style="border-radius: 8px !important;"
                                        href="{{ url('kenaikan-gaji') }}">
                                        Kembali
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('script')
    <script>
        // Ambil elemen input
        const tglTerhitungMulai = document.getElementById('tgl_terhitung_mulai');
        const tglKenaikanBerikutnya = document.getElementById('tgl_kenaikan_berikutnya');

        // Tambahkan event listener untuk perubahan tanggal
        tglTerhitungMulai.addEventListener('input', function () {
            const startDate = new Date(tglTerhitungMulai.value);

            // Periksa apakah tanggal valid
            if (!isNaN(startDate)) {
                // Tambahkan 2 tahun ke tanggal terhitung mulai
                startDate.setFullYear(startDate.getFullYear() + 2);

                // Format tanggal menjadi YYYY-MM-DD
                const year = startDate.getFullYear();
                const month = String(startDate.getMonth() + 1).padStart(2, '0');
                const day = String(startDate.getDate()).padStart(2, '0');
                const formattedDate = `${year}-${month}-${day}`;

                // Set nilai input kenaikan berikutnya
                tglKenaikanBerikutnya.value = formattedDate;
            }
        });
        form.onsubmit = (e) => {

            let formData = new FormData(form);

            e.preventDefault();

            document.getElementById("tombol_kirim").disabled = true;

            axios({
                method: 'post',
                url: '/update-kenaikan-gaji',
                data: formData,
            })
                .then(function (res) {
                    //handle success         
                    if (res.data.responCode == 1) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: res.data.respon,
                            timer: 3000,
                            showConfirmButton: false
                        })

                        $("#modal").modal("hide");
                        $('#myTable').DataTable().clear().destroy();
                        getData()

                    } else {
                        //respon 
                        let respon_error = ``
                        Object.entries(res.data.respon).forEach(([field, messages]) => {
                            messages.forEach(message => {
                                respon_error += `<li>${message}</li>`;
                            });
                        });

                        document.getElementById('respon_error').innerHTML = respon_error

                    }

                    document.getElementById("tombol_kirim").disabled = false;
                })
                .catch(function (res) {
                    document.getElementById("tombol_kirim").disabled = false;
                    //handle error
                    console.log(res);
                });
        }
    </script>
@endpush
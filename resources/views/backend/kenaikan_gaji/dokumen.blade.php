<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
@php
                    $instansi = DB::table('instansis')->first();
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
                                    Telp/Fax {{ $instansi->telp_fax }} Arga Makmur Kode Pos {{ $instansi->kode_pos }}
                                    <br>
                                    Laman: {{ $instansi->website }}, Pos-el: {{ $instansi->email }}
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
                        <input required type="hidden" name="id" id="id" value="{{ Request('data') }}">
                        <input required type="hidden" name="id_profil" id="id_profil" value="{{ @$pegawai->id }}">
                        <table width="100%">
                            <tr>
                                <td width="5%"></td>
                                <td width="10%"></td>
                                <td></td>
                                <td width="35%"></td>
                                <td width="5%"></td>
                                <td width="11%">Arga Makmur, </td>
                                <td>
                                {{ $kenaikan_gaji->tgl_dokumen ?? date('Y-m-d') }}
                                </td>
                                <td width="10%"></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td width="10%">Nomor</td>
                                <td>:</td>
                                <td>
                                {{ @$kenaikan_gaji->no_dokumen }}
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
                                {{ @$kenaikan_gaji->lampiran ?? '-' }}
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
                                {{ @$pegawai->name }}
                                </td>
                                <td>
                                {{ @$pegawai->tanggal_lahir }}
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
                                {{ @$pegawai->nip }}
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
                                    {{ @$kenaikan_gaji->pangkat ?? @$pangkat[1] }}
                                </td>
                                <td>
                                {{ @$kenaikan_gaji->jabatan ?? @$pegawai->jabatan }}
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
                                {{ @$kenaikan_gaji->skpd ?? @$kantor->nama_skpd }}
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
                                {{ @$kenaikan_gaji->gaji_pokok_lama ?? @$gaji_lama->gaji_pokok_baru }}
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
                                {{ @$kenaikan_gaji->oleh_pejabat ?? @$gaji_lama->oleh_pejabat }}
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
                                {{ @$kenaikan_gaji->tgl_dokumen_sebelumnya ?? @$gaji_lama->tgl_dokumen_sebelumnya }}
                                </td>
                                <td>
                                {{ @$kenaikan_gaji->no_dokumen_sebelumnya ?? @$gaji_lama->no_dokumen_sebelumnya }}
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
                                {{ @$kenaikan_gaji->tgl_berlaku_gaji ?? @$gaji_lama->tgl_terhitung_mulai }}
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
                                {{ @$kenaikan_gaji->masa_kerja_tahun_sebelumnya ?? @$gaji_lama->masa_kerja_tahun_baru }} Tahun
                                </td>
                                <td>
                                {{ @$kenaikan_gaji->masa_kerja_bulan_sebelumnya ?? @$gaji_lama->masa_kerja_bulan_baru }} Bulan
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
                                {{ @$kenaikan_gaji->gaji_pokok_baru }}
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
                                {{ @$kenaikan_gaji->masa_kerja_tahun_baru ??
    @$gaji_lama->masa_kerja_tahun_baru ? @$gaji_lama->masa_kerja_tahun_baru + 2 : 0 }} Tahun
                                </td>
                                <td>
                                {{ @$kenaikan_gaji->masa_kerja_bulan_baru ?? 0 }} Bulan
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
                                    {{ @$kenaikan_gaji->golongan ?? @$pangkat[0] }}
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
                                {{ @$kenaikan_gaji->tgl_terhitung_mulai }}
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
                                    b. Kenaikan gaji berkala berikutnya pada tanggal <br>
                                    {{ @$kenaikan_gaji->tgl_kenaikan_berikutnya }}
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
                                    
                                    <br>
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
                                    6. Pegawai yang bersangkutan
                                </td>
                                <td width="50%" class="text-center" style="font-size: 16px;">

                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
</body>

</html>
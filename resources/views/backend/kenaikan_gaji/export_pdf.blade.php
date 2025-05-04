<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        th,
        td {
            vertical-align: top;
            font-size: 15px;
        }
    </style>
</head>

<body>
    @php
        $pangkat = explode(" - ", @$data->pangkat_pegawai);
        $kepala = explode(" - ", @$data->pangkat_kepala);
    @endphp
    <table width="100%">
        <tr>
            <td width="15%">
                <!-- <img width="100%" src="https://upload.wikimedia.org/wikipedia/commons/9/9e/INDONESIA_logo.png" alt=""> -->
                <img width="100%" src="https://drive.usercontent.google.com/download?id=1vFbsaC1u0WKoesIPKDwnWW9PynVN_61n&export=view&authuser=0" alt="Gambar dari Google Drive">
                <!-- https://drive.google.com/file/d//view?usp=sharing -->
            </td>
            <td></td>
            <td width="85%">
                <center>
                    <span style="font-size: 16px; font-family: 'Times New Roman', Times, serif;">
                        PEMERINTAH
                        KABUPATEN BENGKULU UTARA <br>
                    </span>
                    <span style="font-size: 25px; font-family: 'Times New Roman', Times, serif;">
                        <b>BADAN KEPEGAWAIAN DAN PENGEMBANGAN <br>
                            SUMBER DAYA MANUSIA</b> <br>
                    </span>
                    <i style="font-family: 'Times New Roman', Times, serif;">Jln. DR.M.Hatta Nomor 11
                        Telp/Fax {{ @$instansi->telp_fax }} Arga Makmur Kode Pos {{ @$instansi->kode_pos }}
                        <br>
                        Laman: {{ @$instansi->website }}, Pos-el: {{ @$instansi->email }}
                    </i>
                </center>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <div style="border-bottom: 3px double #000; padding-bottom: 5px; margin-bottom: 5px;">

                </div>
            </td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="15%">

            </td>
            <td></td>
            <td width="40%">

            </td>
            <td colspan="2" width="50%">
                Arga Makmur,
                {{ \Carbon\Carbon::createFromFormat('Y-m-d', $data->tgl_dokumen)->translatedFormat('d F Y') }}
            </td>
        </tr>
        <tr>
            <td>
                Nomor
            </td>
            <td width="1%">:</td>
            <td>
                {{ @$data->no_dokumen }}
            </td>
            <td width="1%"></td>
            <td width="49%">

            </td>
        </tr>
        <tr>
            <td>
                Lampiran
            </td>
            <td>:</td>
            <td>
                {{ @$data->lampiran ?? '-' }}
            </td>
            <td></td>
            <td>

            </td>
        </tr>
        <tr>
            <td>
                Hal
            </td>
            <td>:</td>
            <td>
                <b>Kenaikan Gaji Berkala</b>
            </td>
            <td></td>
            <td>

            </td>
        </tr>
        <tr>
            <td colspan="3">
                <br>
                Kepada Yth. <br>
                Kepala Badan Keuangan dan Aset Daerah <br>
                Kabupaten Bengkulu Utara <br>
                Di -
            </td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2">
                <b>Arga Makmur</b><br><br>
            </td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="4">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Kepala Badan Kepegawaian dan Pengembangan Sumber Daya Manusia Kabupaten Bengkulu Utara dengan ini
                memberitahukan bahwa berhubung telah dipenuhinya masa kerja dan syarat-syarat lainnya maka kepada :
            </td>
        </tr>
        <tr>
            <td></td>
            <td>1. </td>
            <td>
                Nama dan tanggal lahir
            </td>
            <td>:</td>
            <td>
                {{ @$data->nama_pegawai }}, {{ date('d-m-Y', strtotime(@$data->tanggal_lahir)) }}
            </td>
        </tr>
        <tr>
            <td></td>
            <td>2. </td>
            <td>
                Nomor Induk Pegawai
            </td>
            <td>:</td>
            <td>
                {{ @$data->nip_pegawai }}
            </td>
        </tr>
        <tr>
            <td></td>
            <td>3. </td>
            <td>
                Pangkat / Jabatan
            </td>
            <td>:</td>
            <td>
                {{ @$pangkat[1] }} / {{ @$data->jabatan_pegawai }}
            </td>
        </tr>
        <tr>
            <td></td>
            <td>4. </td>
            <td>
                Kantor / Tempat bekerja
            </td>
            <td>:</td>
            <td>
                {{ @$data->skpd }}
            </td>
        </tr>
        <tr>
            <td></td>
            <td>5.</td>
            <td>
                Gaji Pokok Lama
            </td>
            <td>:</td>
            <td>
                {{ 'Rp. ' . number_format(@$data->gaji_pokok_lama, 0, ',', '.') . ',-' }}
            </td>
        </tr>
        <tr>
            <td></td>
            <td colspan="4">
                atas dasar surat keputusan terakhir tentang gaji/pangkat yang ditetapkan :
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>a. Oleh Pejabat</td>
            <td>:</td>
            <td>
                {{ @$data->oleh_pejabat }}
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>b. Tanggal dan nomor</td>
            <td>:</td>
            <td>
                {{ date('d-m-Y', strtotime(@$data->tgl_dokumen_sebelumnya)) }} &nbsp;
                {{ @$data->no_dokumen_sebelumnya }}
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>c. Tanggal berlakunya gaji tersebut</td>
            <td>:</td>
            <td>
                {{ \Carbon\Carbon::createFromFormat('Y-m-d', @$data->tgl_berlaku_gaji)->translatedFormat('d F Y') }}
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>d. Masa Kerja gol. pada tgl tersebut</td>
            <td>:</td>
            <td>
                {{ @$data->masa_kerja_tahun_sebelumnya != null ? @$data->masa_kerja_tahun_sebelumnya : '0' }} Tahun
                {{ @$data->masa_kerja_bulan_sebelumnya != null ? @$data->masa_kerja_bulan_sebelumnya : '0' }} Bulan
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td colspan="3">
                <u>Diberikan kenaikan gaji berkala hingga memperoleh :</u>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>6.</td>
            <td>
                Gaji pokok baru
            </td>
            <td>:</td>
            <td>
                {{ 'Rp. ' . number_format(@$data->gaji_pokok_baru, 0, ',', '.') . ',-' }}
            </td>
        </tr>
        <tr>
            <td></td>
            <td>7.</td>
            <td>
                Berdasarkan masa kerja
            </td>
            <td>:</td>
            <td>
                {{ @$data->masa_kerja_tahun_baru != null ? @$data->masa_kerja_tahun_baru : '0' }} Tahun
                {{ @$data->masa_kerja_bulan_baru != null ? @$data->masa_kerja_bulan_baru : '0' }} Bulan
            </td>
        </tr>
        <tr>
            <td></td>
            <td>8.</td>
            <td>
                Dalam Golongan
            </td>
            <td>:</td>
            <td>
                {{ @$pangkat[0] }}
            </td>
        </tr>
        <tr>
            <td></td>
            <td>9.</td>
            <td>
                Terhitung Mulai Tanggal
            </td>
            <td>:</td>
            <td>
                {{ \Carbon\Carbon::createFromFormat('Y-m-d', @$data->tgl_terhitung_mulai)->translatedFormat('d F Y') }}
            </td>
        </tr>
        <tr>
            <td></td>
            <td>10.</td>
            <td>
                Keterangan
            </td>
            <td>:</td>
            <td>
                a. Ybs adalah PNS Daerah <br>
                b. Kenaikan gaji berkala berikutnya pada tanggal
                <br> {{ \Carbon\Carbon::createFromFormat('Y-m-d', @$data->tgl_kenaikan_berikutnya)->translatedFormat('d F Y') }}
            </td>
        </tr>
        <tr>
            <td></td>
            <td colspan="4">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Diharapkan agar sesuai dengan Peraturan Pemerintah Nomor 5 Tahun 2024 tentang Perubahan ke Sembilan
                Belas atas Peraturan Pemerintah Nomor 7 Tahun 1977, kepada pegawai tersebut dapat dibayarkan
                penghasilannya berdasarkan gaji pokoknya yang baru.
            </td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td colspan="2">
                <center>
                    <br>
                    KEPALA BADAN KEPEGAWAIAN DAN <br>
                    PENGEMBANGAN SUMBER DAYA MANUSIA <br>
                    KABUPATEN BENGKULU UTARA
                    <br><br><br><br><br>

                    <b><u>{{ @$data->nama_kepala }}</u></b><br>
                    {{ @$kepala[2] }}<br>
                    NIP. {{ @$data->nip_kepala }}
                </center>
            </td>
        </tr>
        <tr>
            <td style="font-size: 14px;" colspan="5">
                <br><br>
                <u>Tembusan disampaikan kepada Yth:</u><br>
                1. Bupati Bengkulu Utara <br>
                2. Kepala BKN Regional VII Palembang <br>
                3. Inspektur Kabupaten Bengkulu Utara di Arga Makmur <br>
                4. Kepala Cabang PT. Taspen (Persero) Bengkulu di Bengkulu <br>
                5. Bendaharawan Gaji PNS yang bersangkutan <br>
                6. Pegawai yang bersangkutan <br>
            </td>
        </tr>
    </table>
</body>

</html>
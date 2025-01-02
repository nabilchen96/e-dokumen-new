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
                                    Telp/Fax 0737-521128 Arga Makmur Kode Pos 38614 <br>
                                    Laman: www.bkpsdm bengkuluutara.go.id, Pos-el: bkpsdm@bengkuluutarakab.go.id
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
                    <table width="100%">
                        <tr>
                            <td width="5%"></td>
                            <td width="10%"></td>
                            <td></td>
                            <td width="35%"></td>
                            <td width="5%"></td>
                            <td width="11%">Arga Makmur, </td>
                            <td>
                                <input type="date" class="form-control border-danger" value="{{ date('Y-m-d') }}">
                            </td>
                            <td width="10%"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td width="10%">Nomor</td>
                            <td>:</td>
                            <td>
                                <input type="text" value="800.1.11.13/510/BKPSDM/IV/2024"
                                    class="form-control border-danger">
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
                                <input type="text" value="-" class="form-control border-danger">
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
                                Bengkulu Utara dengan ini memberitahukan bahwa berhubung telah dipenuhinya masa kerja
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
                                <input type="text" class="form-control border-danger" value="M. Nabil Putra">
                            </td>
                            <td>
                                <input type="date" class="form-control border-danger">
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
                                <input type="text" class="form-control border-danger" value="12345678910">
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
                                <input type="text" class="form-control border-danger" value="Pembina">
                            </td>
                            <td>
                                <input type="text" class="form-control border-danger" value="Guru Madya">
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
                                <input type="text" class="form-control border-danger"
                                    value="SMPN 10 Kabupaten Bengkulu Utara">
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
                                <input type="number" class="form-control border-danger" value="4624300">
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
                                <input type="text" class="form-control border-danger" value="Dinas Pendidikan">
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
                                <input type="date" class="form-control border-danger" value="Dinas Pendidikan">
                            </td>
                            <td>
                                <input type="text" class="form-control border-danger"
                                    value="No: 800/1857/Dispendik/2022">
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
                                <input type="date" class="form-control border-danger">
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
                            <td colspan="2">
                                <input type="text" class="form-control border-danger" value="22 Tahun 00 Bulan">
                            </td>
                        </tr>
                        <tr>
                            <td width="10%">

                            </td>
                            <td colspan="4">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Diberikan kenaikan gaji berkala hingga memperoleh:</u>
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
                                <input type="number" class="form-control border-danger" value="4770000">
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
                            <td colspan="2">
                                <input type="text" class="form-control border-danger" value="24 Tahun 00 Bulan">
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
                                <input type="text" class="form-control border-danger" value="IV/a">
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
                                <input type="date" class="form-control border-danger" value="IV/a">
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
                                <input type="date" class="form-control border-danger">
                            </td>

                        </tr>
                        <tr>
                            <td width="10%">
                            </td>
                            <td colspan="4" style="text-align: justify !important;">
                                <br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                Diharapkan agar sesuai dengan Peraturan Pemerintah Nomor 5 Tahun 2024 tentang <br>
                                Perubahan ke Sembilan Belas atas Peraturan Pemerintah Nomor 7 Tahun 1977, kepada Pegawai
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
                                <b><u>SYARIFAH INAYATI, S.E</u></b> <br>
                                Pembina Tk.I <br>
                                NIP. 197112291998032006
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
                    <br><br>
                    <hr>
                    <table width="100%">
                        <tr>
                            <td width="5%"></td>
                            <td>
                                <button id="tombol_kirim" class="btn btn-primary"
                                    style="border-radius: 8px !important;">Submit</button>
                                <button id="tombol_kirim" class="btn btn-warning"
                                    style="border-radius: 8px !important;">Preview</button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
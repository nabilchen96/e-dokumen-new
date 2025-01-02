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

        table,
        td,
        th {
            white-space: nowrap !important;
            border: 1px solid white !important;
        }
    </style>
@endpush
@section('content')
<div class="row" style="margin-top: -200px;">
    <div class="col-md-12">
        <div class="row">
            <div class="col-12 col-xl-8 mb-xl-0">
                <h3 class="font-weight-bold">Dokumen Kenaikan Gaji</h3>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 mt-4">
        <div class="card w-100">
            <div class="card-body">
                <div id="document-view" style="display: none;">
                    <table width="100%">
                        <tr>
                            <td width="5%"></td>
                            <td width="10%"></td>
                            <td></td>
                            <td width="35%"></td>
                            <td width="5%"></td>
                            <td width="11%">Arga Makmur, </td>
                            <td>
                                <input type="date" class="form-control">
                            </td>
                            <td width="10%"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td width="10%">Nomor</td>
                            <td>:</td>
                            <td>
                                <input type="text" value="800.1.11.13/510/BKPSDM/IV/2024" class="form-control">
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
                                <input type="text" value="-" class="form-control">
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
                    <table width="100%">
                        <tr>
                            <td width="15%">
                            </td>
                            <td width="40%">
                                <b>Arga Makmur</b>
                                <br><br>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td width="10%"></td>
                        </tr>
                        <tr>
                            <td width="10%">
                            </td>
                            <td colspan="4">
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
                                <input type="text" class="form-control" value="M. Nabil Putra">
                            </td>
                            <td>
                                <input type="date" class="form-control">
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
                                <input type="text" class="form-control" value="12345678910">
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
                                <input type="text" class="form-control" value="Pembina">
                            </td>
                            <td>
                                <input type="text" class="form-control" value="Guru Madya">
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
                                <input type="text" class="form-control" value="SMPN 10 Kabupaten Bengkulu Utara">
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
                                <input type="number" class="form-control" value="4624300">
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
                                <input type="text" class="form-control" value="Dinas Pendidikan">
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
                                <input type="date" class="form-control" value="Dinas Pendidikan">
                            </td>
                            <td>
                                <input type="text" class="form-control" value="No: 800/1857/Dispendik/2022">
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
                                <input type="date" class="form-control">
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
                                <input type="text" class="form-control" value="22 Tahun 00 Bulan">
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
                                <input type="number" class="form-control" value="4770000">
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
                                <input type="text" class="form-control" value="24 Tahun 00 Bulan">
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
                                <input type="text" class="form-control" value="IV/a">
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
                                <input type="date" class="form-control" value="IV/a">
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
                                <input type="date" class="form-control">
                            </td>

                        </tr>
                        <tr>
                            <td width="10%">
                            </td>
                            <td colspan="4">
                                <br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                Diharapkan agar sesuai dengan Peraturan Pemerintah Nomor 5 Tahun 2024 tentang <br>
                                Perubahan ke Sembilan Belas atas Peraturan Pemerintah Nomor 7 Tahun 1977, kepada Pegawai
                                <br>
                                tersebut dapat dibayarkan penghasilannya berdasarkan gaji pokoknya yang baru.
                            </td>
                        </tr>
                    </table>
                    <br>
                    <table width="100%" class="mt-5">
                        <tr>
                            <td width="50%"></td>
                            <td width="50%" class="text-center" style="font-size: 16px;">
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
                </div>

                <textarea id="editor"></textarea>
            </div>
        </div>
    </div>
</div>

@endsection
@push('script')
    <script src="https://cdn.tiny.cloud/1/eyiwqpv1cxzo0gjo5u4m5npxqrpotcchlwmbcuj6dtjr0vjb/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        // Inisialisasi TinyMCE
        tinymce.init({
            selector: '#editor',
            height: 800,
            plugins: 'lists link image table',
            toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image table',
            content_style: `
              table {
                border-collapse: collapse;
                width: 100%;
              }
              table, th, td {
                border: none !important;
              }
              td, th {
                padding: 8px;
                text-align: left;
              }
            `,
            setup: function (editor) {
                // Muat konten HTML yang ada ke editor setelah inisialisasi
                editor.on('init', function () {
                    const htmlContent = document.getElementById('document-view').innerHTML;
                    editor.setContent(htmlContent);
                });
            }
        });
    </script>
@endpush
<!DOCTYPE html>
<html>
<head>
    <title>Laporan Buku Tamu</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th, td { border: 1px solid black; padding: 6px; font-size: 9px; text-align: left; }
        th { background-color: #f2f2f2; text-align: center; text-transform: uppercase; }
        h3, h4 { text-align: center; margin-bottom: 10px; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
    <h3>LAPORAN KUNJUNGAN TAMU BKPSDM</h3>
    <hr>

    <!-- TABEL 1: PEGAWAI INTERNAL -->
    <h4>1. DAFTAR TAMU ASN KABUPATEN BENGKULU UTARA</h4>
    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="12%">Waktu</th>
                <th width="15%">NIP</th>
                <th width="15%">Nama Tamu</th>
                <th width="15%">Instansi</th>
                <th>Keperluan</th>
                <th width="15%">Tujuan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($internal as $k => $i)
            <tr>
                <td align="center">{{ $k + 1 }}</td>
                <td>{{ $i->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $i->nip }}</td>
                <td>{{ $i->nama }}</td>
                <td>{{ $i->instansi_asal }}</td>
                <td>{{ $i->keperluan }}</td>
                <td>{{ $i->nama_tujuan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- TABEL 2: PEGAWAI EXTERNAL -->
    <h4>2. DAFTAR TAMU ASN EXTERNAL</h4>
    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="12%">Waktu</th>
                <th width="15%">NIP</th>
                <th width="15%">Nama Tamu</th>
                <th width="15%">Asal Instansi</th>
                <th>Keperluan</th>
                <th width="15%">Tujuan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($external as $k => $i)
            <tr>
                <td align="center">{{ $k + 1 }}</td>
                <td>{{ $i->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $i->nip }}</td>
                <td>{{ $i->nama }}</td>
                <td>{{ $i->instansi_asal }}</td>
                <td>{{ $i->keperluan }}</td>
                <td>{{ $i->nama_tujuan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- TABEL 3: NON-PEGAWAI -->
    <h4>3. DAFTAR TAMU NON-ASN</h4>
    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="12%">Waktu</th>
                <th width="20%">Nama Tamu</th>
                <th width="20%">Asal/Alamat</th>
                <th>Keperluan</th>
                <th width="15%">Tujuan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($nonPegawai as $k => $i)
            <tr>
                <td align="center">{{ $k + 1 }}</td>
                <td>{{ $i->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $i->nama }}</td>
                <td>{{ $i->instansi_asal }}</td>
                <td>{{ $i->keperluan }}</td>
                <td>{{ $i->nama_tujuan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
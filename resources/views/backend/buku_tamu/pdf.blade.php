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
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <h3>LAPORAN KUNJUNGAN TAMU BKPSDM</h3>
    <hr>

    <h4>1. DAFTAR TAMU ASN KABUPATEN BENGKULU UTARA</h4>
    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="10%">Waktu</th>
                <th width="12%">NIP</th>
                <th width="14%">Nama Tamu</th>
                <th width="12%">Instansi</th>
                <th>Keperluan</th>
                <th width="13%">Tujuan</th>
                <th width="10%">Tingkat Kepuasan</th>
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
                <td class="text-center">{{ $i->penilaian ?? 'Belum Dinilai' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h4>2. DAFTAR TAMU ASN EXTERNAL</h4>
    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="10%">Waktu</th>
                <th width="12%">NIP</th>
                <th width="14%">Nama Tamu</th>
                <th width="12%">Asal Instansi</th>
                <th>Keperluan</th>
                <th width="13%">Tujuan</th>
                <th width="10%">Tingkat Kepuasan</th>
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
                <td class="text-center">{{ $i->penilaian ?? 'Belum Dinilai' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h4>3. DAFTAR TAMU NON-ASN</h4>
    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="10%">Waktu</th>
                <th width="16%">Nama Tamu</th>
                <th width="16%">Asal/Alamat</th>
                <th>Keperluan</th>
                <th width="13%">Tujuan</th>
                <th width="10%">Tingkat Kepuasan</th>
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
                <td class="text-center">{{ $i->penilaian ?? 'Belum Dinilai' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @php
        // Gabungkan seluruh data tamu untuk dihitung rekap per petugas
        $semuaDataTamu = collect($internal)->merge($external)->merge($nonPegawai);
        
        // Group data berdasarkan nama petugas (tujuan) dan urutkan berdasarkan nilai tertinggi
        $rekapPetugas = $semuaDataTamu->groupBy('nama_tujuan')->map(function ($items) {
            $totalDinilai = 0;
            $skorTotal = 0;
            $hitung = ['Memuaskan' => 0, 'Sedang' => 0, 'Kurang' => 0, 'Belum' => 0];

            foreach ($items as $item) {
                $nilai = $item->penilaian ?? 'Belum Dinilai';
                if ($nilai === 'Memuaskan') {
                    $skorTotal += 3;
                    $totalDinilai++;
                    $hitung['Memuaskan']++;
                } elseif ($nilai === 'Sedang') {
                    $skorTotal += 2;
                    $totalDinilai++;
                    $hitung['Sedang']++;
                } elseif ($nilai === 'Kurang') {
                    $skorTotal += 1;
                    $totalDinilai++;
                    $hitung['Kurang']++;
                } else {
                    $hitung['Belum']++;
                }
            }

            // Hitung Rata-rata Angka
            $rataRataAngka = $totalDinilai > 0 ? round($skorTotal / $totalDinilai, 2) : 0;
            
            // Tentukan Kategori Rata-rata (Teks)
            $rataRataTeks = 'Belum Dinilai';
            if ($rataRataAngka >= 2.5) {
                $rataRataTeks = 'Memuaskan';
            } elseif ($rataRataAngka >= 1.5) {
                $rataRataTeks = 'Sedang';
            } elseif ($rataRataAngka > 0) {
                $rataRataTeks = 'Kurang';
            }

            return (object) [
                'total_tamu' => $items->count(),
                'rincian' => $hitung,
                'rata_angka' => $rataRataAngka,
                'rata_teks' => $rataRataTeks
            ];
        })->sortByDesc('rata_angka'); // Mengurutkan koleksi dari nilai rata_angka terbesar ke terkecil
    @endphp

    <div class="page-break"></div>
    <h4>4. REKAPITULASI TINGKAT KEPUASAN TAMU PER PETUGAS</h4>
    <table>
        <thead>
            <tr>
                <th width="3%" rowspan="2">No</th>
                <th rowspan="2">Nama Petugas (Tujuan)</th>
                <th width="8%" rowspan="2">Total Tamu</th>
                <th colspan="3">Rincian Tingkat Kepuasan</th>
                <th width="12%" rowspan="2">Belum Dinilai</th>
                <th width="15%" rowspan="2">Rata-rata Tingkat Kepuasan</th>
            </tr>
            <tr>
                <th width="10%">Memuaskan</th>
                <th width="10%">Sedang</th>
                <th width="10%">Kurang</th>
            </tr>
        </thead>
        <tbody>
            @php $noRekap = 1; @endphp
            @forelse($rekapPetugas as $nama_petugas => $data)
            <tr>
                <td align="center">{{ $noRekap++ }}</td>
                <td>{{ $nama_petugas }}</td>
                <td align="center"><b>{{ $data->total_tamu }}</b></td>
                <td align="center">{{ $data->rincian['Memuaskan'] }}</td>
                <td align="center">{{ $data->rincian['Sedang'] }}</td>
                <td align="center">{{ $data->rincian['Kurang'] }}</td>
                <td align="center">{{ $data->rincian['Belum'] }}</td>
                <td align="center">
                    <b>{{ $data->rata_teks }}</b><br>
                    <span style="font-size: 8px;">(Skor: {{ $data->rata_angka }})</span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" align="center">Belum ada data kunjungan tamu.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
                <a>Skor Tingkat Kepuasan</a><br>
                <a>a. Memuaskan : 3</a><br>
                <a>b. Sedang    : 2</a><br>
                <a>c. Kurang    : 1</a><br>
</body>
</html>
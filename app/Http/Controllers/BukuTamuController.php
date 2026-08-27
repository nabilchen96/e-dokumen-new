<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BukuTamu;
use DB;
use Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;

class BukuTamuController extends Controller {
    
    public function index() {
        // Ambil pegawai BKPSDM untuk dropdown tujuan
        $pegawai_bkpsdm = DB::table('users')
            ->leftJoin('profils', 'profils.id_user', '=', 'users.id')
            ->where('profils.instansi_kerja', 'like', '%Badan Kepegawaian dan Pengembangan Sumber Daya Manusia%')
            ->select('users.id', 'users.name', 'profils.nip')->get();

        if (Auth::user()->role == 'Admin' || Auth::user()->role == 'AdminTamu') {
            return view('backend.buku_tamu.admin', compact('pegawai_bkpsdm'));
        } else {
            $profil = DB::table('profils')->where('id_user', Auth::id())->first();
            return view('backend.buku_tamu.pegawai', compact('pegawai_bkpsdm', 'profil'));
        }
    }

    public function data(Request $request) {
        $query = BukuTamu::join('users', 'buku_tamus.id_tujuan', '=', 'users.id')
                    ->select('buku_tamus.*', 'users.name as nama_tujuan', 'users.no_wa as wa_tujuan');
                    
        if (Auth::user()->role == 'Admin' || Auth::user()->role == 'AdminTamu') {
            // Jika request memiliki parameter jenis (untuk tab spesifik), maka di-filter.
            // Jika request tidak memiliki parameter jenis (untuk tab Semua Data), abaikan filter WHERE sehingga semua data ditarik.
            if ($request->has('jenis') && $request->jenis != '') { 
                $query->where('jenis_tamu', $request->jenis);
            }
        } else {
            $profil = DB::table('profils')->where('id_user', Auth::id())->first();
            $query->where('buku_tamus.nip', $profil->nip);
        }
        
        return response()->json(['data' => $query->orderBy('created_at', 'desc')->get()]);
    }

    public function store(Request $request) {
        BukuTamu::create($request->all());
        return response()->json(['responCode' => 1]);
    }

    // Fungsi updateStatus diganti menjadi updatePenilaian
    public function updatePenilaian(Request $request) {
        $tamu = BukuTamu::find($request->id);
        // Menyimpan data penilaian yang dikirim dari SweetAlert di frontend
        $tamu->penilaian = $request->penilaian; 
        $tamu->save();
        return response()->json(['responCode' => 1]);
    }

    public function delete(Request $request) {
        BukuTamu::find($request->id)->delete();
        return response()->json(['responCode' => 1]);
    }

    public function cariPegawai($nip) {
        return response()->json(DB::table('profils')
            ->join('users', 'profils.id_user', '=', 'users.id')
            ->where('profils.nip', $nip)
            ->select('users.name', 'profils.instansi_kerja')
            ->first());
    }

    public function exportExcel() {
        $data = BukuTamu::join('users', 'buku_tamus.id_tujuan', '=', 'users.id')
                    ->select('buku_tamus.*', 'users.name as nama_tujuan')->get();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $sheet->setCellValue('A1', 'NO'); 
        $sheet->setCellValue('B1', 'TANGGAL'); 
        $sheet->setCellValue('C1', 'NIP'); 
        $sheet->setCellValue('D1', 'NAMA TAMU'); 
        $sheet->setCellValue('E1', 'ASAL'); 
        $sheet->setCellValue('F1', 'KEPERLUAN'); 
        $sheet->setCellValue('G1', 'PEGAWAI DITUJU'); 
        // Mengubah header dari STATUS menjadi PENILAIAN
        $sheet->setCellValue('H1', 'PENILAIAN');
        
        $row = 2;
        foreach($data as $i => $d) {
            $sheet->setCellValue('A'.$row, $i+1); 
            $sheet->setCellValue('B'.$row, $d->created_at);
            $sheet->setCellValue('C'.$row, $d->nip ?? '-'); 
            $sheet->setCellValue('D'.$row, $d->nama);
            $sheet->setCellValue('E'.$row, $d->instansi_asal); 
            $sheet->setCellValue('F'.$row, $d->keperluan);
            $sheet->setCellValue('G'.$row, $d->nama_tujuan); 
            // Memasukkan data penilaian
            $sheet->setCellValue('H'.$row, $d->penilaian ?? 'Belum Dinilai'); 
            $row++;
        }
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Laporan_VMS.xlsx"');
        (new Xlsx($spreadsheet))->save('php://output');
    }

    public function exportPdf() {
        // 1. Ambil data Pegawai Internal (Data otomatis dari profil sistem)
        $internal = BukuTamu::join('users', 'buku_tamus.id_tujuan', '=', 'users.id')
                    ->where('jenis_tamu', 'Pegawai Internal')
                    ->select('buku_tamus.*', 'users.name as nama_tujuan')->get();

        // 2. Ambil data Pegawai External (Input NIP manual)
        $external = BukuTamu::join('users', 'buku_tamus.id_tujuan', '=', 'users.id')
                    ->where('jenis_tamu', 'Pegawai External')
                    ->select('buku_tamus.*', 'users.name as nama_tujuan')->get();

        // 3. Ambil data Non-Pegawai (Tanpa NIP)
        $nonPegawai = BukuTamu::join('users', 'buku_tamus.id_tujuan', '=', 'users.id')
                    ->where('jenis_tamu', 'Non-Pegawai')
                    ->select('buku_tamus.*', 'users.name as nama_tujuan')->get();

        $pdf = Pdf::loadView('backend.buku_tamu.pdf', compact('internal', 'external', 'nonPegawai'));
        return $pdf->stream('Laporan_VMS_BKPSDM.pdf');
    }

    public function kirimWaLangsung(Request $request) {
        // 1. Bersihkan karakter selain angka (menghindari format 0812-xxxx-xxxx)
        $nomor_tujuan = preg_replace('/[^0-9]/', '', $request->nomor);
        $pesan = $request->pesan;

        $data = [
            'target' => $nomor_tujuan,
            'message' => $pesan,
            'delay' => '2', 
        ];

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Q6YBrZNnsuaMewvjVueW', // Token Fonnte BKPSDM
                'Content-Type' => 'application/x-www-form-urlencoded',
            ])->asForm()->post('https://api.fonnte.com/send', $data);

            // 2. Ambil respons JSON asli dari Fonnte
            $result = $response->json();

            // 3. Cek apakah Fonnte benar-benar berhasil mengirim (status = true)
            if ($response->successful() && isset($result['status']) && $result['status'] == true) {
                return response()->json(['responCode' => 1, 'pesan' => 'Pesan berhasil dikirim']);
            } else {
                // Jika gagal, tampilkan alasan dari Fonnte (misal: "Device disconnected")
                $alasan = isset($result['reason']) ? $result['reason'] : 'Gagal mengirim pesan';
                return response()->json(['responCode' => 0, 'pesan' => 'Gagal: ' . $alasan]);
            }
        } catch (\Exception $e) {
            return response()->json(['responCode' => 0, 'pesan' => 'Error: ' . $e->getMessage()]);
        }
    }
}
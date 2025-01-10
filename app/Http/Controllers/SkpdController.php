<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Skpd;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;

class SkpdController extends Controller
{
    public function index()
    {
        return view('backend.skpd.index');
    }

    public function data()
    {

        $data = DB::table('skpds')
            // ->join('districts', 'districts.id', '=', 'skpds.district_id')
            // ->join('regencies', 'regencies.id', '=', 'districts.regency_id')
            // ->join('provinces', 'provinces.id', '=', 'regencies.province_id')
            ->select(
                'skpds.*',
                // 'provinces.name as province',
                // 'regencies.name as regency',
                // 'districts.name as district',
            )
            ->get();

        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nama_skpd' => 'required',
            // 'district_id' => 'required',
        ]);

        if ($validator->fails()) {

            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];

        } else {

            $data = Skpd::create([
                'nama_skpd' => $request->nama_skpd,
                'district_id' => 0,
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
                'email' => $request->email,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude
            ]);

            $data = [
                'responCode' => 1,
                'respon' => 'Data Sukses Ditambah'
            ];
        }

        return response()->json($data);
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'nama_skpd' => 'required',
            // 'district_id' => 'required',
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];
        } else {

            $user = Skpd::find($request->id);
            $data = $user->update([
                'nama_skpd' => $request->nama_skpd,
                'district_id' => 0,
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
                'email' => $request->email,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude
            ]);

            $data = [
                'responCode' => 1,
                'respon' => 'Data Sukses Disimpan'
            ];
        }

        return response()->json($data);
    }

    public function delete(Request $request)
    {

        $data = Skpd::find($request->id)->delete();

        $data = [
            'responCode' => 1,
            'respon' => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }

    public function exportExcel()
    {
        // Ambil data dari database
        $data = DB::table('skpds')->get();

        // Buat instance baru dari Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Tambahkan judul kolom
        $headerColumns = [
            'A1' => '#',
            'B1' => 'SKPD',
            'C1' => 'TELEPON',
            'D1' => 'EMAIL',
            'E1' => 'LATITUDE',
            'F1' => 'LONGITUDE',
            'G1' => 'ALAMAT',
            'H1' => 'TGL DIBUAT'
        ];
        foreach ($headerColumns as $cell => $text) {
            $sheet->setCellValue($cell, $text);
        }

        // Tambahkan styling untuk header
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4F81BD']],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN]
            ]
        ];
        $sheet->getStyle('A1:H1')->applyFromArray($headerStyle);

        // Tambahkan data dari database ke spreadsheet
        $row = 2;
        $totalRows = $data->count();
        foreach ($data as $index => $item) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $item->nama_skpd);
            $sheet->setCellValue('C' . $row, $item->telepon);
            $sheet->setCellValue('D' . $row, $item->email);
            $sheet->setCellValue('E' . $row, $item->latitude);
            $sheet->setCellValue('F' . $row, $item->longitude);
            $sheet->setCellValue('G' . $row, $item->alamat);
            $sheet->setCellValue('H' . $row, $item->created_at);

            // Terapkan garis pada setiap baris kecuali baris terakhir
            $sheet->getStyle("A$row:H$row")->applyFromArray([
                'borders' => [
                    'allBorders' => ['borderStyle' => Border::BORDER_THIN]
                ]
            ]);

            $row++;
        }

        // Otomatis menyesuaikan lebar kolom
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Buat writer untuk menulis file Excel
        $writer = new Xlsx($spreadsheet);
        $fileName = 'skpd.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);

        // Tulis file ke lokasi sementara
        $writer->save($temp_file);

        // Berikan respon file kepada pengguna
        return response()->download($temp_file, $fileName)->deleteFileAfterSend(true);
    }

    public function importExcel(Request $request)
    {
        // Validasi input file
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        // Ambil file yang diunggah
        $file = $request->file('file');

        // Baca file menggunakan PhpSpreadsheet
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        $successCount = 0;
        $failCount = 0;

        foreach ($rows as $index => $row) {
            if ($index == 0)
                continue;  // Lewati header

            // Simpan data baru ke database
            $data = Skpd::create([
                'nama_skpd' => $row[0],
                'telepon' => $row[1],
                'email' => $row[2],
                'latitude' => $row[3],  // Hashing password
                'longitude' => $row[4],
                'alamat' => $row[5]
            ]);

            $successCount++;
        }

        return response()->json([
            'message' => 'Proses import selesai.',
            'success_count' => $successCount,
            'fail_count' => $failCount
        ]);
    }
}

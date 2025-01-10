<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Models\UnitKerja;
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

class UnitKerjaController extends Controller
{
    public function index()
    {
        return view('backend.unit_kerja.index');
    }

    public function data()
    {

        $data = DB::table('unit_kerjas')
            ->join('skpds', 'skpds.id', '=', 'unit_kerjas.id_skpd')
            ->select(
                'unit_kerjas.*',
                'skpds.nama_skpd',
            )
            ->get();
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id_skpd' => 'required',
            'unit_kerja' => 'required'
        ]);

        if ($validator->fails()) {

            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];

        } else {

            $data = UnitKerja::create([
                'id_skpd' => $request->id_skpd,
                'unit_kerja' => $request->unit_kerja,
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
            'id_skpd' => 'required',
            'unit_kerja' => 'required',
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];
        } else {

            $user = UnitKerja::find($request->id);
            $data = $user->update([
                'id_skpd' => $request->id_skpd,
                'unit_kerja' => $request->unit_kerja,
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

        $data = UnitKerja::find($request->id)->delete();

        $data = [
            'responCode' => 1,
            'respon' => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }

    public function getUnitKerjaBySkpd($id)
    {
        $unitKerja = DB::table('unit_kerjas')->where('id_skpd', $id)->get();
        return response()->json($unitKerja);
    }

    public function exportExcel()
    {
        // Ambil data dari database
        $data = DB::table('unit_kerjas')
                ->leftjoin('skpds', 'skpds.id', '=', 'unit_kerjas.id_skpd')
                ->select(
                    'unit_kerjas.*',
                    'skpds.nama_skpd'
                )
                ->get();

        // Buat instance baru dari Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Tambahkan judul kolom
        $headerColumns = [
            'A1' => '#',
            'B1' => 'UNIT KERJA',
            'C1' => 'SKPD',
            'D1' => 'TGL DIBUAT'
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
        $sheet->getStyle('A1:D1')->applyFromArray($headerStyle);

        // Tambahkan data dari database ke spreadsheet
        $row = 2;
        $totalRows = $data->count();
        foreach ($data as $index => $item) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $item->unit_kerja);
            $sheet->setCellValue('C' . $row, $item->nama_skpd);
            $sheet->setCellValue('D' . $row, $item->created_at);

            // Terapkan garis pada setiap baris kecuali baris terakhir
            $sheet->getStyle("A$row:D$row")->applyFromArray([
                'borders' => [
                    'allBorders' => ['borderStyle' => Border::BORDER_THIN]
                ]
            ]);

            $row++;
        }

        // Otomatis menyesuaikan lebar kolom
        foreach (range('A', 'D') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Buat writer untuk menulis file Excel
        $writer = new Xlsx($spreadsheet);
        $fileName = 'unit_kerja.xlsx';
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

            $id_skpd = explode("-", $row[1]);

            // Simpan data baru ke database
            $data = UnitKerja::create([
                'unit_kerja' => $row[0],
                'id_skpd' => $id_skpd[0],
            ]);

            $successCount++;
        }

        return response()->json([
            'message' => 'Proses import selesai.',
            'success_count' => $successCount,
            'fail_count' => $failCount
        ]);
    }

    public function exportTemplate()
    {

        // Ambil data dari tabel skpds dan gabungkan id dengan nama_skpd
        $categories = DB::table('skpds')
            ->select('id', 'nama_skpd')
            ->get()
            ->map(function ($item) {
                return "{$item->id} - {$item->nama_skpd}"; // Format id dan nama_skpd
            })->toArray();

        $categoryList = '"' . implode(',', $categories) . '"'; // Format menjadi string untuk formula Excel
        // Buat Spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Tambahkan styling untuk header
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4F81BD']],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN]
            ]
        ];
        $sheet->getStyle('A1:B1')->applyFromArray($headerStyle);

        $contoh = DB::table('skpds')->first();

        // Set header kolom
        $sheet->setCellValue('A1', 'UNIT KERJA');
        $sheet->setCellValue('B1', 'SKPD');
        $sheet->setCellValue('A2', 'DINAS PERHUBUNGAN KOTA');
        $sheet->setCellValue('B2', $contoh->id.' - '.$contoh->nama_skpd);

        $sheet->getStyle("A1:B2")->applyFromArray([
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN]
            ]
        ]);

        // Otomatis menyesuaikan lebar kolom
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);

        // Tambahkan data validation list ke kolom B2
        $dataValidation = $sheet->getCell('B2')->getDataValidation();
        $dataValidation->setType(DataValidation::TYPE_LIST);
        $dataValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
        $dataValidation->setAllowBlank(false);
        $dataValidation->setShowInputMessage(true);
        $dataValidation->setShowErrorMessage(true);
        $dataValidation->setShowDropDown(true);
        $dataValidation->setFormula1($categoryList); // Daftar pilihan

        // Simpan file ke path tertentu
        $writer = new Xlsx($spreadsheet);
        $fileName = 'template_unit_kerja_import.xlsx';
        $filePath = storage_path($fileName);
        $writer->save($filePath);

        return response()->download($filePath, $fileName)->deleteFileAfterSend(true);
    }

}

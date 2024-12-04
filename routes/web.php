<?php

use App\Http\Controllers\PenilaianProposalController;
use Illuminate\Support\Facades\Route;
// use Barryvdh\DomPDF\Facade as PDF; // Import namespace penuh
use Barryvdh\DomPDF\Facade\Pdf;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//LANDING
Route::get('/', function () {
    return view('frontend.app');
});


//LOGIN
Route::get('/login', 'App\Http\Controllers\AuthController@login')->name('login');
Route::post('/loginProses', 'App\Http\Controllers\AuthController@loginProses');
Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

//REGISTER
Route::get('/register', 'App\Http\Controllers\AuthController@register')->name('register');
Route::post('/registerOtp', 'App\Http\Controllers\AuthController@registerOtp');
Route::post('/registerOtpCek', 'App\Http\Controllers\AuthController@registerOtpCek');
Route::get('/register2', 'App\Http\Controllers\AuthController@register2');
Route::post('/registerProses', 'App\Http\Controllers\AuthController@registerProses');

//PENCARIAN DAERAH
Route::get('/search-district', 'App\Http\Controllers\DistrictController@searchDistrict');

//RESET PASSWORD
Route::get('/reset-password', function(){
    return view('frontend.auth.reset_password');
});
Route::post('/resetOtp', 'App\Http\Controllers\AuthController@resetOtp');
Route::post('/reset-password-proses', 'App\Http\Controllers\AuthController@resetPasswordProses');




//BACKEND
Route::group(['middleware' => 'auth'], function () {

    //DASHBOARD
    Route::get('/dashboard', 'App\Http\Controllers\DashboardController@index');
    Route::get('/data-peta', 'App\Http\Controllers\DashboardController@dataPeta');

    //USER
    Route::get('/user', 'App\Http\Controllers\UserController@index');
    Route::get('/data-user', 'App\Http\Controllers\UserController@data');
    Route::post('/store-user', 'App\Http\Controllers\UserController@store');
    Route::post('/update-user', 'App\Http\Controllers\UserController@update');
    Route::post('/delete-user', 'App\Http\Controllers\UserController@delete');

    //JENIS DOKUMEN
    Route::get('/jenis-dokumen', 'App\Http\Controllers\JenisDokumenController@index');
    Route::get('/data-jenis-dokumen', 'App\Http\Controllers\JenisDokumenController@data');
    Route::post('/store-jenis-dokumen', 'App\Http\Controllers\JenisDokumenController@store');
    Route::post('/update-jenis-dokumen', 'App\Http\Controllers\JenisDokumenController@update');
    Route::post('/delete-jenis-dokumen', 'App\Http\Controllers\JenisDokumenController@delete');

    //DISTRICT
    Route::get('/district', 'App\Http\Controllers\DistrictController@index');
    Route::get('/data-district', 'App\Http\Controllers\DistrictController@data');
    Route::post('/store-district', 'App\Http\Controllers\DistrictController@store');
    Route::post('/update-district', 'App\Http\Controllers\DistrictController@update');
    Route::post('/delete-district', 'App\Http\Controllers\DistrictController@delete');

    //DOKUMEN
    Route::get('/file-dokumen', 'App\Http\Controllers\DokumenController@index');
    Route::get('/data-file-dokumen', 'App\Http\Controllers\DokumenController@data');
    Route::post('/store-file-dokumen', 'App\Http\Controllers\DokumenController@store');
    Route::post('/update-file-dokumen', 'App\Http\Controllers\DokumenController@update');
    Route::post('/update-status-dokumen', 'App\Http\Controllers\DokumenController@updateStatusDokumen');
    Route::post('/delete-file-dokumen', 'App\Http\Controllers\DokumenController@delete');

    Route::get('/convert-to-pdf/{filename}', function ($filename) {
        $filePath = public_path('dokumen/' . $filename);

        // Cek apakah file ada
        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        // Cek apakah file sudah PDF
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        if ($extension === 'pdf') {
            // Jika file sudah PDF, langsung tampilkan
            return response()->file($filePath, [
                'Content-Type' => 'application/pdf',
            ]);
        } else {
            // Jika file adalah gambar, konversi ke PDF
            $imageData = base64_encode(file_get_contents($filePath));

            // Buat HTML untuk menampilkan gambar dalam ukuran A4
            $html = '<!DOCTYPE html>
            <html>
            <head>
                <style>
                    body {
                        margin: 0;
                        padding: 0;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 100vh; /* Tinggi penuh layar */
                        width: 100vw; /* Lebar penuh layar */
                        overflow: hidden; /* Sembunyikan bagian yang keluar */
                    }
    
                    img {
                        width: 100%;
                        height: 100%;
                        object-fit: cover;
                    }
                </style>
            </head>
            <body>
                <img src="data:image/png;base64,' . $imageData . '" />
            </body>
            </html>';

            // Generate PDF dengan ukuran A4 dan orientasi portrait
            $pdf = PDF::loadHTML($html)->setPaper('a4', 'portrait');

            // Tampilkan PDF di browser
            return $pdf->stream($filename . '.pdf');
        }
    });

    //USER
    Route::get('/profil', 'App\Http\Controllers\ProfilController@index');
    Route::get('/data-profil', 'App\Http\Controllers\ProfilController@data');
    Route::post('/store-profil', 'App\Http\Controllers\ProfilController@store');
    Route::post('/update-profil', 'App\Http\Controllers\ProfilController@update');
    Route::post('/delete-profil', 'App\Http\Controllers\ProfilController@delete');

});

//LOGOUT
Route::get('/logout', function () {
    Auth::logout();
    return redirect('login');
})->name('logout');

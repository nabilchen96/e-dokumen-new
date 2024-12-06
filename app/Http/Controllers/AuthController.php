<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use App\Models\Otp;
use App\Models\Profil;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;
use DB;
use Illuminate\Support\Carbon;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check() == true) {
            return redirect('dashboard');
        } else {
            return view('frontend.auth.login');
        }

    }

    public function loginProses(Request $request)
    {

        $response_data = [
            'responCode' => 0,
            'respon' => ''
        ];

        // Ambil input dari pengguna
        $identifier = $request->input('nip_email'); // Bisa email atau NIP
        $password = $request->input('password');

        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            // Login dengan email
            $credentials = ['email' => $identifier, 'password' => $password];

            if (Auth::attempt($credentials)) {
                // Login berhasil dengan email
                $role = Auth::user()->role;

                $response_data = [
                    'responCode' => 1,
                    'respon' => $role
                ];
            } else {
                // Login gagal dengan email
                $response_data['respon'] = 'Email atau password salah!';
            }
        } else {
            // Login dengan NIP
            $user = DB::table('users')
                ->join('profils', 'users.id', '=', 'profils.id_user')
                ->where('profils.nip', $identifier)
                ->select('users.*')
                ->first();

            if ($user && Auth::attempt(['email' => $user->email, 'password' => $password])) {
                // Login berhasil dengan NIP
                $role = Auth::user()->role;

                $response_data = [
                    'responCode' => 1,
                    'respon' => $role
                ];
            } else {
                // Login gagal dengan NIP
                $response_data['respon'] = 'NIP atau password salah!';
            }
        }

        return response()->json($response_data);

    }

    public function register()
    {

        return view('frontend.auth.register');
    }

    public function registerOtp(Request $request)
    {
        $noWa = $request->no_wa;

        //validasi apakah nomor sudah terdaftar dengan status aktif
        $cekWa = DB::table('users')->where('no_wa', $noWa)->where('status', 'Aktif')->first();
        if ($cekWa) {
            return response()->json([
                'status' => 'error',
                'respon' => 'Nomor WhatsApp sudah digunakan user lain. Harap mengubungi admin.'
            ]);
        }

        // Validasi input
        if (!$noWa) {
            return response()->json([
                'status' => 'error',
                'respon' => 'Nomor WhatsApp tidak boleh kosong.'
            ]);
        }

        // Simulasi pengiriman OTP (6 digit acak)
        $otp = rand(100000, 999999);

        // Simpan ke database
        Otp::create([
            'no_wa' => $noWa,
            'otp' => $otp,
        ]);

        $data = [
            'Authorization' => 'vFGDkexmx2SZyLsRNrnS', // Ganti dengan token Anda
            'target' => $noWa, // Nomor tujuan
            'message' => 'Kode OTP Anda: *' . $otp . '*. Kode ini hanya dapat digunakan selama satu menit, dan jangan berikan kode ini kepada siapapun', // Isi pesan
        ];

        // Mengirim request POST menggunakan Guzzle
        try {
            $response = Http::withHeaders([
                'Authorization' => 'vFGDkexmx2SZyLsRNrnS',
                'Content-Type' => 'application/x-www-form-urlencoded',
            ])->asForm()->post('https://api.fonnte.com/send', $data);

            // Menangani respons
            if ($response->successful()) {
                $result = $response->json(); // Mendapatkan respons sebagai array
                return response()->json([
                    'status' => 'success',
                    'message' => 'Pesan berhasil dikirim.',
                    'data' => $result,
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal mengirim pesan.',
                    'error' => $response->body(), // Menampilkan pesan error
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengirim pesan.',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function registerOtpCek(Request $request)
    {
        $cekOtp = DB::table('otps')
            ->where('no_wa', $request->no_wa)
            ->where('otp', $request->otp)
            ->first();

        if ($cekOtp) {
            // Bandingkan waktu saat ini dengan created_at
            $otpCreatedAt = Carbon::parse($cekOtp->created_at);
            $currentTime = Carbon::now();

            if ($otpCreatedAt->diffInMinutes($currentTime) <= 1) {
                // Jika OTP masih berlaku
                session(['user_otp' => $cekOtp]);

                $data = [
                    'responCode' => 1,
                    'respon' => 'Data OTP Berhasil Ditemukan!',
                ];
            } else {
                // Jika OTP sudah kadaluarsa
                $data = [
                    'responCode' => 0,
                    'respon' => 'Kode OTP telah kadaluarsa!',
                ];
            }
        } else {
            // Jika OTP tidak ditemukan
            $data = [
                'responCode' => 0,
                'respon' => 'Data OTP Tidak Ditemukan!',
            ];
        }

        return response()->json($data);
    }

    public function register2()
    {
        if (session('user_otp')) {
            return view('frontend.auth.register2');
        } else {
            return redirect('register');

        }
    }

    public function registerProses(Request $request)
    {

        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8',
            'email' => 'unique:users',
            'name' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'no_wa' => 'required',
            'district_id' => 'required'
        ]);

        if ($validator->fails()) {

            $data['respon'] = 'Semua data wajib diisi, silahkan ulangi!';

        } else {
            $data = User::create([
                'name' => $request->name,
                'role' => 'Pegawai',
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'no_wa' => $request->no_wa,
                'status' => 'Aktif'
            ]);

            //ISI DATA KE PROFIL
            $data = Profil::create([
                'nip' => $request->nip,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'id_user' => $data->id,
                'district_id' => $request->district_id,
                'status_pegawai' => $request->status_pegawai
            ]);

            $data = [
                'responCode' => 1,
                'respon' => 'Data Berhasil Didaftarkan!'
            ];

            Auth::attempt([
                'email' => $request->email,
                'password' => $request->password,
            ]);

            //HAPUS SESSION
            session()->forget('user_otp');
        }

        return response()->json($data);
    }

    public function resetOtp(Request $request)
    {
        $noWa = $request->no_wa;

        // Validasi input
        if (!$noWa) {
            return response()->json([
                'status' => 'error',
                'respon' => 'Nomor WhatsApp tidak boleh kosong.'
            ]);
        }

        // Simulasi pengiriman OTP (6 digit acak)
        $otp = rand(100000, 999999);

        // Simpan ke database
        Otp::create([
            'no_wa' => $noWa,
            'otp' => $otp,
        ]);

        $data = [
            'Authorization' => 'vFGDkexmx2SZyLsRNrnS', // Ganti dengan token Anda
            'target' => $noWa, // Nomor tujuan
            'message' => 'Kode OTP Anda: *' . $otp . '*. Kode ini hanya dapat digunakan selama satu menit, dan jangan berikan kode ini kepada siapapun', // Isi pesan
        ];

        // Mengirim request POST menggunakan Guzzle
        try {
            $response = Http::withHeaders([
                'Authorization' => 'vFGDkexmx2SZyLsRNrnS',
                'Content-Type' => 'application/x-www-form-urlencoded',
            ])->asForm()->post('https://api.fonnte.com/send', $data);

            // Menangani respons
            if ($response->successful()) {
                $result = $response->json(); // Mendapatkan respons sebagai array
                return response()->json([
                    'status' => 'success',
                    'message' => 'Pesan berhasil dikirim.',
                    'data' => $result,
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal mengirim pesan.',
                    'error' => $response->body(), // Menampilkan pesan error
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengirim pesan.',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function resetPasswordProses(Request $request)
    {
        $cekOtp = DB::table('otps')
            ->where('no_wa', $request->no_wa)
            ->where('otp', $request->otp)
            ->first();

        if ($cekOtp) {
            // Bandingkan waktu saat ini dengan created_at
            $otpCreatedAt = Carbon::parse($cekOtp->created_at);
            $currentTime = Carbon::now();

            if ($otpCreatedAt->diffInMinutes($currentTime) <= 1) {
                // Cari user berdasarkan no_wa
                $user = DB::table('users')
                    ->where('no_wa', $request->no_wa)
                    ->first();

                if ($user) {
                    // Reset password
                    $newPassword = $request->password; // Pastikan password dikirim dari request
                    $hashedPassword = Hash::make($newPassword);

                    // Update password user di database
                    DB::table('users')
                        ->where('id', $user->id)
                        ->update(['password' => $hashedPassword]);

                    // Login user secara otomatis
                    Auth::loginUsingId($user->id);

                    $data = [
                        'responCode' => 1,
                        'respon' => 'Password berhasil direset, login berhasil!',
                    ];
                } else {
                    $data = [
                        'responCode' => 0,
                        'respon' => 'User tidak ditemukan!',
                    ];
                }
            } else {
                // Jika OTP sudah kadaluarsa
                $data = [
                    'responCode' => 0,
                    'respon' => 'Kode OTP telah kadaluarsa!',
                ];
            }
        } else {
            // Jika OTP tidak ditemukan
            $data = [
                'responCode' => 0,
                'respon' => 'Data OTP Tidak Ditemukan!',
            ];
        }

        return response()->json($data);
    }
}

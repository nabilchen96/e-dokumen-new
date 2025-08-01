<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use App\Models\KirimPesan;

class KirimPesanJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $pesans = KirimPesan::where('status', 'pending')->get();

        foreach ($pesans as $index => $pesan) {
            $data = [
                'target' => $pesan->nomor_tujuan,
                'message' => $pesan->pesan . "\n\n📌 Pesan ini dikirim dari aplikasi https://pandu.bengkuluutarakab.go.id. Jangan lupa simpan nomor ini dengan nama *Pandu App*",
                'delay' => '5', // delay API (opsional, tergantung API)
            ];

            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Q6YBrZNnsuaMewvjVueW',
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ])->asForm()->post('https://api.fonnte.com/send', $data);

                if ($response->successful()) {
                    $pesan->status = 'terkirim';
                    $pesan->save();
                    info("✅ Berhasil kirim ke {$pesan->nomor_tujuan}");
                } else {
                    info("❌ Gagal kirim ke {$pesan->nomor_tujuan}");
                }
            } catch (\Exception $e) {
                info("⚠️ Error kirim ke {$pesan->nomor_tujuan}: " . $e->getMessage());
            }

            // Delay manual agar tidak kirim sekaligus (hindari spam)
            sleep(5);
        }
    }
}

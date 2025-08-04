<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\KirimPesan;

class KirimPesanWhatsapp extends Command
{
    protected $signature = 'pesan:wa';
    protected $description = 'Mengirim pesan WhatsApp ke nomor tujuan berdasarkan data pending di database';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
        public function handle()
    {
        $pesans = KirimPesan::where('status', 'pending')->get();

        foreach ($pesans as $pesan) {
            $data = [
                'target' => $pesan->nomor_tujuan,
                'message' => $pesan->pesan.
                
'📌 Pesan ini dikirim dari aplikasi https://pandu.bengkuluutarakab.go.id. Jangan lupa simpan nomor ini dengan nama *Pandu App*', // Isi pesan,
                'delay' => '5',
            ];

            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Q6YBrZNnsuaMewvjVueW',
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ])->asForm()->post('https://api.fonnte.com/send', $data);

                if ($response->successful()) {
                    $pesan->status = 'terkirim';
                    $pesan->save();
                    $this->info("Berhasil kirim ke {$pesan->nomor_tujuan}");
                } else {
                    $this->error("Gagal kirim ke {$pesan->nomor_tujuan}");
                }
            } catch (\Exception $e) {
                $this->error("Error: " . $e->getMessage());
            }
        }

        return Command::SUCCESS;
    }
}

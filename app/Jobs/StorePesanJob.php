<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use App\Jobs\KirimPesanJob;
use App\Models\User;
use App\Models\KirimPesan;

class StorePesanJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $userIds;
    public $pesanText;
    public $pengirimId;

    public function __construct(array $userIds, string $pesanText, int $pengirimId)
    {
        $this->userIds = $userIds;
        $this->pesanText = $pesanText;
        $this->pengirimId = $pengirimId;
    }

    public function handle()
    {
        foreach ($this->userIds as $id) {

            $user = User::find($id);

            if ($user) {
                $pesan = KirimPesan::create([
                    'nomor_pesan' => strtoupper(Str::random(10)),
                    'pesan' => $this->pesanText,
                    'nomor_tujuan' => $user->no_wa,
                    'id_user' => $user->id,
                    'id_pengirim' => $this->pengirimId,
                    'status' => 'pending',
                ]);

                // Dispatch pengiriman pesan
                KirimPesanJob::dispatch($pesan)->delay(now()->addSeconds(10));
            }
        }
    }
}

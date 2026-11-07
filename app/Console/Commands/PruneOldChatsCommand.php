<?php

namespace App\Console\Commands;

use App\Models\ChatSession;
use Illuminate\Console\Command;

class PruneOldChatsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chat:prune-old {--days=60 : Jumlah hari masa simpan setelah deal tercapai}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menghapus sesi obrolan negosiasi yang sudah mencapai deal dan telah lewat dari 60 hari';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $days = (int) $this->option('days');
        $this->info("Memeriksa sesi chat yang sudah deal lebih dari {$days} hari...");

        $expiredSessions = ChatSession::expiredDeals($days)->get();
        $count = $expiredSessions->count();

        if ($count === 0) {
            $this->info('Tidak ada sesi chat deal yang kedaluwarsa.');

            return self::SUCCESS;
        }

        foreach ($expiredSessions as $session) {
            $code = $session->session_code;
            $customer = $session->customer_name;
            $dealAt = $session->deal_at?->format('Y-m-d');
            $session->delete();
            $this->line(" - Dihapus: [{$code}] {$customer} (Deal pada {$dealAt})");
        }

        $this->info("✓ Berhasil membersihkan {$count} sesi chat negosiasi.");

        return self::SUCCESS;
    }
}

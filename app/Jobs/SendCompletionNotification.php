<?php

namespace App\Jobs;

use App\Mail\MaintenanceCompletedMail;
use App\Models\MaintenanceLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendCompletionNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public int $backoff = 60;

    public function __construct(
        public readonly MaintenanceLog $completedLog,
        public readonly MaintenanceLog $nextScheduled,
    ) {}

    public function handle(): void
    {
        $email = setting('operational_manager_email', config('mail.from.address'));

        try {
            Mail::to($email)->send(new MaintenanceCompletedMail($this->completedLog, $this->nextScheduled));
        } catch (\Throwable $e) {
            Log::warning('Pengiriman email notifikasi gagal, fallback ke log.', [
                'error'     => $e->getMessage(),
                'to'        => $email,
                'log_id'    => $this->completedLog->id,
                'ship'      => $this->completedLog->ship->nama ?? '-',
                'next_date' => $this->nextScheduled->tanggal_servis,
            ]);
        }
    }
}

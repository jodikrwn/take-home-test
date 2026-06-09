<?php

namespace App\Mail;

use App\Models\MaintenanceLog;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MaintenanceCompletedMail extends Mailable
{
    use SerializesModels;

    public function __construct(
        public readonly MaintenanceLog $completedLog,
        public readonly MaintenanceLog $nextScheduled,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Servis Selesai — ' . $this->completedLog->ship->nama,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.maintenance-completed',
        );
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FreeDayStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $approvedDays;
    public $deniedDays;
    public $daysOffLeft;

    public function __construct($user, $approvedDays, $deniedDays, $daysOffLeft)
    {
        $this->user = $user;
        $this->approvedDays = $approvedDays;
        $this->deniedDays = $deniedDays;
        $this->daysOffLeft = $daysOffLeft;
    }

    public function build()
    {
        return $this->view('emails.free_day_status')
                    ->with([
                        'user' => $this->user,
                        'approvedDays' => $this->approvedDays,
                        'deniedDays' => $this->deniedDays,
                        'daysOffLeft' => $this->daysOffLeft, 
                    ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Free Day Status Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.free-day-status',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

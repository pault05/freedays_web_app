<?php

namespace App\Mail;

use AllowDynamicProperties;
use App\Models\FreeDaysRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class FreeDayRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $freeDayRequest;

    /**
     * Create a new message instance.
     */
    public function __construct($freeDayRequest, $user)
    {
        $this->freeDayRequest = $freeDayRequest;
        $this->user = $user;
    }

    public function build()
    {
        return $this->view('emails.free-day-request')
                    ->subject('Your free day request')
                    ->with([
                       'freeDaysRequest' => $this->freeDayRequest,
                       'user' => $this->user
                    ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: 'vacationvault@gmail.com',
            subject: 'Free Day Request',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.free-day-request',
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

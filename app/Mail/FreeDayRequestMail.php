<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FreeDayRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $freeDayRequest;
    public $user; //userul care a facut cererea
    public $admin; //adminii care primesc cererea

    /**
     * Create a new message instance.
     */
    public function __construct($freeDayRequest, $user, $admin)
    {
        $this->freeDayRequest = $freeDayRequest;
        $this->admin = $admin;
        $this->user = $user;

    }

    public function build()
    {
        return $this->view('emails.free-day-request')
                    ->subject('Your free day request')
                    ->with([
                        'freeDaysRequest' => $this->freeDayRequest,
                        'admin' => $this->admin,
                        'user' => $this->user,
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

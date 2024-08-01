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
    public $stats;
    public $day;

    public function __construct($user, $stats, $day)
    {
        $this->user = $user;
        $this->stats = $stats;
        $this->day = $day;
    }

    public function build()
    {
        $approved = 0;
        
        if (isset($this->user->freeDays) && count($this->user->freeDays)) {
            foreach ($this->user->freeDays as $day) {
                if ($day->status == 'Approved' && $day->category->is_subtractable == 1) {
                    if ($day->half_day) {
                        $approved += 0.5;
                    } else {
                        $approved += $day->days;
                    }

                }
            }
        }
       
        $daysOffLeft = 21 - $approved;
        //dd($daysOffLeft);
        return $this->view('emails.free_day_status')
                    ->with([
                        'user' => $this->user,
                        'day' => $this->day,
                        'stats' => $this->stats,
                        'daysOffLeft' => $daysOffLeft
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

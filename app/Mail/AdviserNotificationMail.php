<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdviserNotificationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        protected $attendance
    )
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Student Attendance Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $user = User::where('rfid', $this->attendance->rfid)
                    ->first();

        $type = $this->attendance->type;
        $modifiedType = ($type == 0) ? 'EXITED' : 'ENTERED'; 

        $formattedCreatedAt = $this->attendance->created_at->format('H:i:s F j, Y'); 
        
        return new Content(
            view: 'mail.adviser_notification_mail',
            with: [
                'name' => $user->name,
                'type' => $modifiedType,
                'created_at' => $formattedCreatedAt,
            ]
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

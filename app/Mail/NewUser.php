<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;
use Orchid\Platform\Models\User;

class NewUser extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(protected User $user)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: env('MAIL_FROM_ADDRESS', 'jdaa482@gmail.com'),
            subject: 'Serempre New User',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $createPasswordUrl =URL::temporarySignedRoute(
            'api.createPassword', now()->addHours(24), ['user' => $this->user->id]
        );
        return new Content(
            view: 'sendNewUserEmail',
            with: ['user' => $this->user, 'createPasswordUrl' => $createPasswordUrl]
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

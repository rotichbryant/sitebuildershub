<?php

namespace App\Mail\Landing;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubscriptionExpiryNotification extends Mailable
{
    use Queueable, SerializesModels;

   protected $user;

   protected $subscription;

   protected $data;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $subscription,$data)
    {
        //
        $this->data = (object) $data;
        $this->user = $user;
        $this->subscription = $subscription;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->data->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: $this->data->markdown,
            with: [
                'client_name'       => $this->user->name,
                'subscription_name' => $this->subscription->name,
                'count_down'        => $this->data->count_down ?? 0,
                'end_date'          => $this->data->end_date ?? 0,
                'url'               => $this->data->link,
            ]
        );
    }
}

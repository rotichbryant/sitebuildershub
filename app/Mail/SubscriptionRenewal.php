<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubscriptionRenewal extends Mailable
{
    use Queueable, SerializesModels;

    protected $subscription;

    protected $user_subscription;

    /**
     * Create a new message instance.
     */
    public function __construct($subscription,$user_subscription)
    {
        //
        $this->subscription = $subscription;
        $this->user_subscription = $user_subscription;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Subscription Renewal',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.subscriptions.renewal',
            with: [
                'subscription_name' => $this->subscription->name,
                'end_date'          => $this->user_subscription->end_date,
                'start_date'        => $this->user_subscription->start_date,
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

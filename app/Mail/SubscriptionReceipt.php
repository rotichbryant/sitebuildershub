<?php

namespace App\Mail;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Markdown;
use Illuminate\Queue\SerializesModels;

class SubscriptionReceipt extends Mailable
{
    use Queueable, SerializesModels;

    protected $invoice;

    protected $transaction;

    /**
     * Create a new message instance.
     */
    public function __construct($invoice, $transaction)
    {
        //
        $this->invoice = $invoice;
        $this->transaction = $transaction;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Invoice #{$this->invoice->invoice_number} Receipt",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.receipts.subscription',
            with: [
                'amount'            => $this->transaction->amount,
                'confirmation_code' => $this->transaction->confirmation_code,
                'currency'          => $this->invoice->user->company->currency,
                'invoice_number'    => $this->invoice->invoice_number,
                'paid_at'           => $this->transaction->paid_at->format('jS F Y h:i'),
                'payment_method'    => $this->transaction->payment_method,
                'purpose'           => $this->invoice->source_type == 'subscription' ? 'Payment for subscription' : 'Payment for advert placement'
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
        // Point to the published mail markdown file
        $markdown = new Markdown(view(), config('mail.markdown'));

        $template = $markdown->render(
            'emails.receipts.subscription',
            [
                'amount'            => $this->transaction->amount,
                'confirmation_code' => $this->transaction->confirmation_code,
                'currency'          => $this->invoice->user->company->currency,
                'invoice_number'    => $this->invoice->invoice_number,
                'paid_at'           => $this->transaction->paid_at->format('jS F Y h:i'),
                'payment_method'    => $this->transaction->payment_method,
                'purpose'           => $this->invoice->source_type == 'subscription' ? 'Payment for subscription' : 'Payment for advert placement'
            ]              
        );      

        $pdf = Pdf::loadHTML($template->toHtml())->output();
        
        return [ 
            Attachment::fromData( 
                fn () => $pdf, 
                $this->invoice->invoice_number.'-receipt.pdf'
            )->withMime('application/pdf') 
        ];
    }
}

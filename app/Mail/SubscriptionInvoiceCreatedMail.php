<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Mail\Mailables\Attachment;

class SubscriptionInvoiceCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $invoice;

    /**
     * Create a new message instance.
     */
    public function __construct($invoice)
    {
        //
        $this->invoice = $invoice;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Your invoice subscription #{$this->invoice->invoice_number} has been generated",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.invoices.subscription',
            with: [
                "billing_cycle"     => $this->invoice->targetable->billing_cycle,
                "client_name"       => $this->invoice->user->name,
                "client_email"      => $this->invoice->user->email,
                "company_email"     => $this->invoice->user->company_email,
                "date"              => $this->invoice->created_at->format('jS F Y'),
                "due_date"          => $this->invoice->due_date->format('jS F Y'),                
                "invoice_number"    => $this->invoice->invoice_number,
                "price"             => $this->invoice->sourceable->currency_price,
                "subscription_name" => $this->invoice->sourceable->name,
                "total_amount"      => $this->invoice->user->company->currency.' '.($this->invoice->targetable->billing_cycle == 'yearly' ? 12 : 1) * $this->invoice->sourceable->price,
                "url"               => route('landing.invoices.pay',[ 'invoice_number' => $this->invoice->invoice_number ])
            ]            
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    // public function attachments(): array
    // {
    //     $pdf = Pdf::loadView(
    //         'emails.invoices.subscription',
    // [
                // "billing_cycle"     => $this->invoice->targetable->billing_cycle,    
    //     "client_name"       => $this->invoice->user->name,
    //     "client_email"      => $this->invoice->user->email,
    //     "date"              => $this->invoice->created_at->format('jS F Y'),
    //     "due_date"          => $this->invoice->due_date->format('jS F Y'),                
    //     "invoice_number"    => $this->invoice->invoice_number,
    //     "price"             => $this->invoice->sourceable->currency_price,
    //     "subscription_name" => $this->invoice->sourceable->name,
    //     "total_amount"      => $this->invoice->user->company->currency.' '.($this->invoice->targetable->billing_cycle == 'yearly' ? 12 : 1) * $this->invoice->sourceable->price,
    //     "url"               => route('landing.invoices.pay',[ 'invoice_number' => $this->invoice->invoice_number ])
    // ] 
    //     )->output();

    //     return [ 
    //         Attachment::fromData( 
    //             fn () => $pdf, 
    //             $this->invoice->invoice_number.'.pdf'
    //         )->withMime('application/pdf') 
    //     ];
    // }
}

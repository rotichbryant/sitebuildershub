<x-mail::message>
<div style="text-align: center;">
    <h1> 
        Payment Successful 
    </h1>
</div>

<x-mail::panel>
<div style="text-align: center;">
    <h1 style="color: #28a745; margin-bottom: 10px;">
        {{ $currency }} {{ number_format($amount, 2) }}
    </h1>
    <p style="color: #6c757d;">Thank you for your payment</p>
</div>
</x-mail::panel>

### Transaction Details

<x-mail::table>
| Description | Details |
| :--- | :--- |
| **Invoice Number** | #{{ $invoice_number }} |
| **Invoice Purpose** | {{ $purpose }} |
| **Transaction ID** | {{ $confirmation_code }} |
| **Date** | {{ $paid_at}} |
| **Payment Method** | {{ $payment_method }} |
</x-mail::table>

<small style="color: #6c757d; display: block; text-align: center; margin-top: 20px;">
    A copy of this receipt has been saved to your account history.
</small>

Thank you for your continued partnership!
Regards,  
**{{ config('app.name') }} Team**
</x-mail::message>

<x-mail::message> 
# Advert Placement Invoice
<x-mail::panel>
## **Invoice Details**
<div style="display: table; width: 100%;">
    <div style="display: table-row;">
        <div style="display: table-cell; text-align: left; padding-bottom: 10px;">
            <strong>Invoice Number</strong>
        </div>
        <div style="display: table-cell; text-align: right; padding-bottom: 10px;">
            <strong> #{{ $invoice_number }} </strong>
        </div>
    </div>
    <div style="display: table-row;">
        <div style="display: table-cell; text-align: left; padding-bottom: 10px;">
            <strong>Issued</strong>
        </div>
        <div style="display: table-cell; text-align: right; padding-bottom: 10px;">
            <strong> {{ $date }} </strong>
        </div>
    </div>
    <div style="display: table-row;">
        <div style="display: table-cell; text-align: left; padding-bottom: 10px;">
            <strong>Due Date</strong>
        </div>
        <div style="display: table-cell; text-align: right; padding-bottom: 10px;">
            <strong> {{ $due_date }} </strong>
        </div>
    </div>        
</div>
</x-mail::panel>

<x-mail::panel>
## **Client Details**
<div style="display: table; width: 100%;">
    <div style="display: table-row;">
        <div style="display: table-cell; text-align: left; padding-bottom: 10px;">
            <strong>Name</strong>
        </div>
        <div style="display: table-cell; text-align: right; padding-bottom: 10px;">
            <strong> {{ $client_name }} </strong>
        </div>
    </div>
    <div style="display: table-row;">
        <div style="display: table-cell; text-align: left; padding-bottom: 10px;">
            <strong>Email</strong>
        </div>
        <div style="display: table-cell; text-align: right; padding-bottom: 10px;">
            <strong> {{ $client_email }} </strong>
        </div>
    </div>        
</div>
</x-mail::panel>

<x-mail::panel>
## **Advert Details**
<div style="display: table; width: 100%;">
    <div style="display: table-row;">
        <div style="display: table-cell; text-align: left; padding-bottom: 10px;">
            <strong>Name</strong>
        </div>
        <div style="display: table-cell; text-align: right; padding-bottom: 10px;">
            {{ $advert_name }}
        </div>
    </div>
    <div style="display: table-row;">
        <div style="display: table-cell; text-align: left; border-top: 1px solid #edeff2; padding-top: 10px;">
            <strong style="font-size: 18px;">Total Due:</strong>
        </div>
        <div style="display: table-cell; text-align: right; border-top: 1px solid #edeff2; padding-top: 10px;">
            <strong style="font-size: 18px;">{{ $total_amount }}</strong>
        </div>
    </div>
</div>
</x-mail::panel>

<x-mail::button :url="$url" color="success" size="log">
Pay {{ $total_amount }}
</x-mail::button>

Thank you for your continued partnership!
Regards,  
**{{ config('app.name') }} Team**
</x-mail::message>
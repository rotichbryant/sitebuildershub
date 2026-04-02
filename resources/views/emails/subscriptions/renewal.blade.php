<x-mail::message> 
# Subscription Renewal Notice
<x-mail::panel>
## **Details**
<div style="display: table; width: 100%;">
    <div style="display: table-row;">
        <div style="display: table-cell; text-align: left; padding-bottom: 10px;">
            <strong>Subscription Name</strong>
        </div>
        <div style="display: table-cell; text-align: right; padding-bottom: 10px;">
            <strong> {{ $subscription_name }} </strong>
        </div>
    </div> 
    <div style="display: table-row;">
        <div style="display: table-cell; text-align: left; padding-bottom: 10px;">
            <strong>Start Date</strong>
        </div>
        <div style="display: table-cell; text-align: right; padding-bottom: 10px;">
            <strong> {{ $start_date }} </strong>
        </div>
    </div> 
    <div style="display: table-row;">
        <div style="display: table-cell; text-align: left; padding-bottom: 10px;">
            <strong>End Date</strong>
        </div>
        <div style="display: table-cell; text-align: right; padding-bottom: 10px;">
            <strong> {{ $end_date }} </strong>
        </div>
    </div>                        
</div>
</x-mail::panel>

Thank you for your continued partnership!
Regards,  
**{{ config('app.name') }} Team**
</x-mail::message>
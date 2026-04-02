<x-mail::message>
Hi {{ $client_name }},

This is your final reminder that your {{ $subscription_name }} subscription expires today. 
To avoid a service interruption, please renew your plan within the next few hours.

<x-mail::button :url="$url">
Renew Subscription
</x-mail::button>

Thanks for being with us,
{{ config('app.name') }} Team
</x-mail::message>

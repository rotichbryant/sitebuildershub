<x-mail::message>
Hi {{ $client_name }},

This is a friendly reminder that your {{ $subscription_name }} subscription is set to expire in {{ $count_down }} days. 
On {{ $end_date }}, your account will automatically revert to our Basic Tier.

<strong>Keep your momentum going:</strong>
Don’t worry—renewing takes less than a minute. Click below to keep your current features and prevent any service interruptions.

<x-mail::button :url="$url">
Renew Subscription
</x-mail::button>

Thanks for being with us,
{{ config('app.name') }} Team
</x-mail::message>

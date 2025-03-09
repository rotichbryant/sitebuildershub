<x-mail::message>
Hello {{ $name }},

Welcome to {{ $company_name }}!

To complete your registration, please verify your email address by clicking the link below:
    
<x-mail::button :url="$url">
Verify
</x-mail::button>

This will help us ensure that you can access your account.

Thanks for joining us!,<br>
Best regards, <br>
{{ config('app.name') }}
</x-mail::message>

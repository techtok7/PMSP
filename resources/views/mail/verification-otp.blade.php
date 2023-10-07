<x-mail::message>
    # OTP Verification

    Dear {{ $name }},

    Your OTP is for verification is {{ $otp }}.

    Thanks,

    {{ config('app.name') }}
</x-mail::message>

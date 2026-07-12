<x-mail::message>
# Halo, {{ $userName }}

{!! nl2br(e($messageContent)) !!}

<x-mail::button :url="config('app.url')">
Buka Aplikasi Smart RW
</x-mail::button>

Terima kasih,<br>
Pengurus Lingkungan<br>
Sistem Smart RW
</x-mail::message>

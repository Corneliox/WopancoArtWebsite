<x-mail::message>
# Hello {{ $submission->name }},

{{ $replyMessage }}

---

**Original Message:**

> {{ $submission->feedback }}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

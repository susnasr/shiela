<!-- resources/views/emails/contact/submitted.blade.php -->
@component('mail::message')
    # New Contact Form Submission

    **Name:** {{ $contact->name }}
    **Email:** {{ $contact->email }}
    **Subject:** {{ $contact->subject }}

    **Message:**
    {{ $contact->message }}

    @component('mail::button', ['url' => url('/admin/contacts/' . $contact->id)])
        View in Dashboard
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent

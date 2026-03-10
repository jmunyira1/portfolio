@component('mail::message')
    # New message from {{ $data['name'] }}

    **From:** {{ $data['name'] }} ({{ $data['email'] }})
    @if(!empty($data['subject']))
        **Subject:** {{ $data['subject'] }}
    @endif

    ---

    {{ $data['message'] }}

    ---
    *Sent from your portfolio contact form*
@endcomponent

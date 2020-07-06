@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => route('home')])
            <img src="{{url('/assets/images/logo.jpeg')}}" alt="{{ get_option('site_name') }} Logo">
            {{-- {{ get_option('site_name') }} --}}
        @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}

    {{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ get_option('site_name') }}. @lang('All rights reserved.')
        @endcomponent
    @endslot
@endcomponent

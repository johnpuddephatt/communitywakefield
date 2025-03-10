<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('settings.name', 'Community Wakefield') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Yantramanav:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-1VR0PEFEDG"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-1VR0PEFEDG');
    </script>

    <script src="{{ mix('js/app.js') }}" defer></script>

</head>

<body class="{{ $classes ?? ''}}  {{ config('settings.slug')}}">
    <div id="app">
        @if(env('APP_ALERT'))
        <div class="notice">
            <div class="container">
                <strong>{!! env('APP_ALERT') !!}</strong>
            </div>
        </div>
        @endif
        @include('components.navbar')
        <main>
            @yield('content')
        </main>
        @include('components.footer')
    </div>
</body>

</html>
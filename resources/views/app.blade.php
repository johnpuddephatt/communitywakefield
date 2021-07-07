<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    {{-- <link rel="preconnect" href="https://fonts.gstatic.com"> --}}
    {{-- <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet"> --}}

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/admin.css') }}">

    <!-- Scripts -->
    @routes
    {{-- <script src="https://maps.googleapis.com/maps/api/js?key={{ config('app.google_maps_key') }}&libraries=places">
    </script> --}}
    <script>
        window.google_maps_key = "{{ config('app.google_maps_key') }}"
    </script>
    <script defer src="{{ mix('js/admin.js') }}" defer></script>
</head>

<body class="font-sans antialiased bg-gradient-to-b from-indigo-50 to-white ">
    @impersonating($guard = null)
    <div class="py-2 text-xs font-semibold text-center text-green-800 bg-green-100 border-b border-green-400">
        You are currently impersonating {{ Auth::user()->name }}. <a class="underline"
            href="{{ route('impersonate.leave') }}">Leave impersonation</a>
    </div>
    @endImpersonating

    @inertia
</body>

</html>
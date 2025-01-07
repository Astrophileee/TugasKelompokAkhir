<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="business">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="success-message" content="{{ session('success') }}">
    <meta name="error-message" content="{{ session('error') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-base-300">
    <div class="drawer lg:drawer-open">
        <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content flex flex-col">
            @include('layouts.navigation')

            <main class="flex-1 p-4">
                {{ $slot }}
            </main>

            @include('layouts.footer')
        </div>

        @include('layouts.sidebar')
    </div>
</body>
</html>

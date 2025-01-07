<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="fantasy">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-base-300">
    <div class="flex flex-col justify-center min-h-screen">
        <div class="container mx-auto px-4 py-8">
            <div class="card bg-base-100 max-w-md mx-auto shadow-xl">
                <div class="card-body">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>
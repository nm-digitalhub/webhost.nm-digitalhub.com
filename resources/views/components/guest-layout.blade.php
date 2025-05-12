<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title : config('app.name', 'NM-DigitalHUB') }}</title>
    <meta name="description" content="Find the perfect domain for your project, business, or personal brand with NM-DigitalHUB.">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite('resources/css/app.css')

    <!-- Scripts -->
    @vite('resources/js/app.js')

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F9FAFB;
        }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased bg-gray-50">
    {{ $slot }}
</body>
</html>

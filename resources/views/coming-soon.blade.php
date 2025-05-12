<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ ucfirst($page) }} - NM-DigitalHUB</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite('resources/css/app.css')

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0B1120;
            color: #FFFFFF;
        }
    </style>
</head>
<body class="antialiased">
    <div class="min-h-screen flex flex-col items-center justify-center px-4 text-center">
        <div class="mb-8">
            <a href="{{ route('home') }}" class="text-[#0084FF] font-bold text-3xl">NM<span class="text-white">Digital<span class="font-bold">HUBV2</span></span></a>
        </div>

        <h1 class="text-4xl sm:text-5xl font-bold mb-6">{{ ucfirst($page) }} Coming Soon</h1>

        <p class="text-xl text-gray-300 max-w-md mx-auto mb-10">
            We're working hard to bring you our {{ $page }} services. Check back soon!
        </p>

        <a href="{{ route('home') }}" class="px-6 py-3 bg-[#0084FF] hover:bg-[#006FDB] text-white font-medium rounded-md transition-colors">
            Return to Homepage
        </a>
    </div>
</body>
</html>

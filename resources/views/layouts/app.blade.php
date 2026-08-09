<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PT Konsultan Halal Indonesia') }}</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
        }
        /* Custom scrollbar rapi untuk sidebar */
        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="min-h-screen antialiased text-slate-800">

    <!-- Navigasi Komponen (Sidebar Desktop & Mobile + Topbar) -->
    @include('layouts.navigation')

    <!-- Kontainer Konten Utama -->
    <main class="min-h-screen pt-16 transition-all duration-300 lg:pl-64">
        <div class="px-2 py-2 mx-auto sm:px-6 lg:px-8 max-w-7xl">
            {{ $slot }}
        </div>
    </main>

</body>
</html>

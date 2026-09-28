<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#002612]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'The Money Circle') }} - Portal Login</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN + Brand Palette -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-green': '#00381B',
                        'brand-green-dark': '#002612',
                        'brand-green-light': '#0A552C',
                        'brand-gold': '#C59121',
                        'brand-gold-light': '#DFC16B',
                        'brand-gold-dark': '#9A7015',
                        'brand-surface': '#F8FAF9',
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                }
            }
        }
    </script>
</head>
<body class="font-sans antialiased text-gray-800 bg-[#002612] selection:bg-brand-gold selection:text-brand-green-dark min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8 relative overflow-x-hidden">

    <!-- Ambient Glow Effects -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
        <div class="absolute -top-32 left-1/2 -translate-x-1/2 w-[600px] h-[400px] bg-emerald-600/15 rounded-full blur-[140px]"></div>
        <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-brand-gold/10 rounded-full blur-[140px]"></div>
    </div>

    <!-- Main Container -->
    <div class="sm:mx-auto sm:w-full sm:max-w-md relative z-10 text-center px-4">
        
        <!-- Brand Icon -->
        <a href="{{ url('/') }}" class="inline-flex flex-col items-center group">
            <img src="{{ asset('images/logo.png') }}" alt="The Money Circle" class="w-16 h-16 rounded-2xl object-contain shadow-xl shadow-brand-gold/25 group-hover:scale-105 transition-transform duration-200" />
            <h1 class="mt-4 text-2xl font-black tracking-tight text-white">The Money Circle</h1>
            <p class="text-xs font-bold text-brand-gold-light tracking-widest uppercase mt-0.5">Coach & Admin Command Center</p>
        </a>

    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md relative z-10 px-4">
        <div class="bg-white/95 backdrop-blur-xl py-8 px-6 sm:px-10 shadow-2xl shadow-black/40 rounded-3xl border border-white/20">
            {{ $slot }}
        </div>

        <div class="text-center mt-6">
            <a href="{{ url('/') }}" class="text-xs font-semibold text-emerald-200/70 hover:text-brand-gold transition-colors inline-flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Return to Welcome Page</span>
            </a>
        </div>
    </div>

</body>
</html>
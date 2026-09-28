<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#002612]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'The Money Circle') }} - Financial Coaching & Wealth Acceleration</title>

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
<body class="font-sans antialiased text-gray-100 bg-[#002612] selection:bg-brand-gold selection:text-brand-green-dark flex flex-col min-h-screen">

    <!-- Ambient Glow Effects -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
        <div class="absolute -top-40 left-1/2 -translate-x-1/2 w-[700px] h-[500px] bg-emerald-600/15 rounded-full blur-[140px]"></div>
        <div class="absolute top-1/3 -right-40 w-[500px] h-[500px] bg-brand-gold/10 rounded-full blur-[140px]"></div>
        <div class="absolute bottom-10 -left-40 w-[500px] h-[500px] bg-emerald-800/20 rounded-full blur-[140px]"></div>
    </div>

    <!-- Navigation Header -->
    <header class="relative z-20 border-b border-white/10 bg-brand-green/80 backdrop-blur-md sticky top-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            
            <!-- Brand Logo -->
            <a href="{{ url('/') }}" class="flex items-center gap-3.5 group">
                <img src="{{ asset('images/logo.png') }}" alt="The Money Circle" class="w-11 h-11 rounded-2xl object-contain shadow-lg shadow-brand-gold/25 group-hover:scale-105 transition-transform duration-200" />
                <div>
                    <span class="text-lg font-black tracking-tight text-white block leading-tight">The Money Circle</span>
                    <span class="text-[11px] font-bold text-brand-gold-light tracking-wider uppercase block">Financial Coaching & Advisory</span>
                </div>
            </a>

            <!-- Navigation Actions -->
            <div class="flex items-center gap-3 sm:gap-4">
                @auth
                    <a href="{{ route('coach.dashboard') }}" 
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-bold text-sm bg-gradient-to-r from-brand-gold-light to-brand-gold text-brand-green-dark shadow-md shadow-brand-gold/20 hover:brightness-110 hover:scale-[1.02] active:scale-[0.98] transition-all">
                        <span>Command Center</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                @else
                    <a href="{{ route('login') }}" 
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-bold text-sm bg-gradient-to-r from-brand-gold-light to-brand-gold text-brand-green-dark shadow-md shadow-brand-gold/20 hover:brightness-110 hover:scale-[1.02] active:scale-[0.98] transition-all">
                        <span>Coach Portal Login</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1 relative z-10 flex flex-col justify-center">

        <!-- Hero Section -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-20 text-center">
            
            <!-- Top Tagline Pill -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-brand-gold/30 backdrop-blur-md mb-8 shadow-inner">
                <span class="text-brand-gold font-black text-xs">★</span>
                <span class="text-xs font-bold text-brand-gold-light tracking-wide uppercase">Wealth Acceleration & Financial Independence</span>
            </div>

            <!-- Main Heading -->
            <h1 class="text-4xl sm:text-6xl lg:text-7xl font-extrabold text-white tracking-tight leading-[1.1] max-w-4xl mx-auto">
                Guiding Every Member <br/>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-gold-light via-brand-gold to-amber-200">
                    From Debt to Sustainable Wealth.
                </span>
            </h1>

            <!-- Subtitle -->
            <p class="mt-6 text-lg sm:text-xl text-emerald-100/80 max-w-2xl mx-auto leading-relaxed font-normal">
                The centralized command center for personal finance coaching, active portfolio oversight, debt elimination tracking, and community accountability.
            </p>

            <!-- Call to Action Buttons -->
            <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4 max-w-md mx-auto">
                @auth
                    <a href="{{ route('coach.dashboard') }}" 
                       class="w-full sm:w-auto inline-flex items-center justify-center gap-3 px-8 py-4 rounded-xl font-extrabold text-base bg-gradient-to-r from-brand-gold-light via-brand-gold to-brand-gold-dark text-brand-green-dark shadow-xl shadow-brand-gold/25 hover:brightness-110 hover:scale-[1.02] active:scale-[0.98] transition-all">
                        <span>Access Coach Command Center</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                @else
                    <a href="{{ route('login') }}" 
                       class="w-full sm:w-auto inline-flex items-center justify-center gap-3 px-8 py-4 rounded-xl font-extrabold text-base bg-gradient-to-r from-brand-gold-light via-brand-gold to-brand-gold-dark text-brand-green-dark shadow-xl shadow-brand-gold/25 hover:brightness-110 hover:scale-[1.02] active:scale-[0.98] transition-all">
                        <span>Coach & Admin Portal Login</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                @endauth
            </div>

            <!-- Portal Feature Highlights Grid -->
            <div class="mt-20 grid grid-cols-1 md:grid-cols-3 gap-6 text-left max-w-5xl mx-auto">
                
                <!-- Card 1: 360 Portfolios -->
                <div class="p-6 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-md hover:border-brand-gold/40 transition-colors group">
                    <div class="w-12 h-12 rounded-xl bg-brand-green-light border border-white/10 flex items-center justify-center text-brand-gold mb-5 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">360° Member Oversight</h3>
                    <p class="text-sm text-emerald-100/70 leading-relaxed">
                        Track income, category spending, emergency cushions, and proactive "At Risk" overspending alerts in real-time.
                    </p>
                </div>

                <!-- Card 2: Debt & Wealth Coaching -->
                <div class="p-6 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-md hover:border-brand-gold/40 transition-colors group">
                    <div class="w-12 h-12 rounded-xl bg-brand-green-light border border-white/10 flex items-center justify-center text-brand-gold mb-5 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Debt Snowball & Investments</h3>
                    <p class="text-sm text-emerald-100/70 leading-relaxed">
                        Leave direct coaching guidance on loans, high-yield Money Market Funds, savings milestones, and monthly reflections.
                    </p>
                </div>

                <!-- Card 3: Community & Wins Wall -->
                <div class="p-6 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-md hover:border-brand-gold/40 transition-colors group">
                    <div class="w-12 h-12 rounded-xl bg-brand-green-light border border-white/10 flex items-center justify-center text-brand-gold mb-5 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Interactive Community Hub</h3>
                    <p class="text-sm text-emerald-100/70 leading-relaxed">
                        Broadcast official announcements, schedule live group coaching calls, publish resource PDFs, and resolve Q&A queries.
                    </p>
                </div>
            </div>

        </section>
    </main>

    <!-- Footer -->
    <footer class="relative z-10 border-t border-white/10 bg-brand-green/60 py-6 text-center text-xs text-emerald-200/60">
        <div class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p>&copy; {{ date('Y') }} The Money Circle. All rights reserved.</p>
            <div class="flex items-center gap-6">
                <a href="{{ route('login') }}" class="hover:text-brand-gold transition-colors font-medium">Coach & Admin Portal</a>
                <span class="text-white/20">&bull;</span>
                <span class="text-brand-gold-light font-semibold">TMC Executive Suite v2.0</span>
            </div>
        </div>
    </footer>

</body>
</html>
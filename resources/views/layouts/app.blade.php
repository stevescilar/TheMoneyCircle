<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#F8FAF9]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'The Money Circle - Coach Backoffice') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN + Custom Configuration -->
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

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="h-full font-sans antialiased text-gray-800 bg-brand-surface" x-data="{ sidebarOpen: false }">

    <div class="min-h-full flex flex-col lg:flex-row">
        
        <!-- Mobile Sidebar Backdrop -->
        <div 
            x-show="sidebarOpen" 
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="sidebarOpen = false"
            class="fixed inset-0 z-40 bg-black/60 lg:hidden"
            x-cloak>
        </div>

        <!-- Sidebar Navigation -->
        <aside 
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            class="fixed inset-y-0 left-0 z-50 w-72 bg-brand-green-dark text-white flex flex-col transition-transform duration-300 ease-in-out lg:static lg:translate-x-0 border-r border-emerald-950/40 shadow-2xl">
            
            <!-- Brand Header -->
            <div class="h-20 flex items-center justify-between px-6 border-b border-white/10 bg-brand-green">
                <a href="{{ route('coach.dashboard') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-brand-gold flex items-center justify-center text-brand-green-dark font-extrabold shadow-md shadow-brand-gold/20 group-hover:scale-105 transition-transform">
                        <svg class="w-6 h-6 text-brand-green" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-base font-bold tracking-tight text-white leading-tight">The Money Circle</h1>
                        <span class="text-xs font-semibold text-brand-gold tracking-wide uppercase">Coach Portal</span>
                    </div>
                </a>

                <button @click="sidebarOpen = false" class="lg:hidden text-white/70 hover:text-white p-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Navigation Links -->
            <div class="flex-1 overflow-y-auto py-6 px-4 space-y-6">
                
                <!-- Main Section -->
                <div>
                    <p class="px-3 text-[11px] font-bold uppercase tracking-wider text-emerald-300/60 mb-2">Coaching Operations</p>
                    <nav class="space-y-1">
                        <a href="{{ route('coach.dashboard') }}" 
                           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('coach.dashboard') && !request()->has('filter') ? 'bg-brand-gold text-brand-green-dark shadow-md shadow-brand-gold/10' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span>Dashboard Overview</span>
                        </a>

                        <a href="{{ route('coach.dashboard', ['filter' => 'all']) }}" 
                           class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->get('filter') === 'all' ? 'bg-brand-gold text-brand-green-dark shadow-md' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <span>Coached Members</span>
                            </div>
                        </a>

                        <a href="{{ route('coach.dashboard', ['filter' => 'at_risk']) }}" 
                           class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->get('filter') === 'at_risk' ? 'bg-red-500 text-white shadow-md' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                <span>At Risk Tracker</span>
                            </div>
                            <span class="px-2 py-0.5 text-xs font-bold rounded-full bg-red-400/20 text-red-300">Alerts</span>
                        </a>

                        <a href="{{ route('coach.dashboard', ['filter' => 'needs_notes']) }}" 
                           class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->get('filter') === 'needs_notes' ? 'bg-brand-gold text-brand-green-dark shadow-md' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                <span>Pending Reviews</span>
                            </div>
                        </a>
                    </nav>
                </div>

                <!-- Community Operations (Phase 2 & 3 Integration) -->
                <div>
                    <div class="flex items-center justify-between px-3 mb-2">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-emerald-300/60">Community Hub</p>
                        <span class="text-[10px] font-extrabold uppercase px-1.5 py-0.5 rounded bg-brand-gold/20 text-brand-gold">App Sync</span>
                    </div>
                    <nav class="space-y-1">
                        <div class="flex items-center justify-between px-3.5 py-2 rounded-xl text-sm font-medium text-white/50 hover:bg-white/5 cursor-not-allowed">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                                </svg>
                                <span>Announcements</span>
                            </div>
                            <span class="text-[10px] bg-white/10 px-2 py-0.5 rounded font-mono text-emerald-200">Phase 2</span>
                        </div>

                        <div class="flex items-center justify-between px-3.5 py-2 rounded-xl text-sm font-medium text-white/50 hover:bg-white/5 cursor-not-allowed">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                                <span>Live Sessions</span>
                            </div>
                            <span class="text-[10px] bg-white/10 px-2 py-0.5 rounded font-mono text-emerald-200">Phase 2</span>
                        </div>

                        <div class="flex items-center justify-between px-3.5 py-2 rounded-xl text-sm font-medium text-white/50 hover:bg-white/5 cursor-not-allowed">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                <span>Resource Library</span>
                            </div>
                            <span class="text-[10px] bg-white/10 px-2 py-0.5 rounded font-mono text-emerald-200">Phase 2</span>
                        </div>

                        <div class="flex items-center justify-between px-3.5 py-2 rounded-xl text-sm font-medium text-white/50 hover:bg-white/5 cursor-not-allowed">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>Coach Q&A Desk</span>
                            </div>
                            <span class="text-[10px] bg-white/10 px-2 py-0.5 rounded font-mono text-amber-200">Phase 3</span>
                        </div>

                        <div class="flex items-center justify-between px-3.5 py-2 rounded-xl text-sm font-medium text-white/50 hover:bg-white/5 cursor-not-allowed">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg>
                                <span>Wins Wall</span>
                            </div>
                            <span class="text-[10px] bg-white/10 px-2 py-0.5 rounded font-mono text-amber-200">Phase 3</span>
                        </div>
                    </nav>
                </div>

            </div>

            <!-- Coach Profile Footer -->
            <div class="p-4 border-t border-white/10 bg-black/20">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-brand-green-light border-2 border-brand-gold flex items-center justify-center font-bold text-white shadow-inner">
                            {{ strtoupper(substr(Auth::user()->name ?? 'C', 0, 2)) }}
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name ?? 'Coach Steve' }}</p>
                            <p class="text-xs text-emerald-300/70 truncate">{{ Auth::user()->email ?? 'coach@themoneycircle.com' }}</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" title="Log Out" class="p-2 text-white/70 hover:text-white hover:bg-white/10 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

        </aside>

        <!-- Main Content Column -->
        <div class="flex-1 flex flex-col min-w-0">
            
            <!-- Top Navbar -->
            <header class="h-20 bg-white border-b border-gray-200/80 sticky top-0 z-30 flex items-center justify-between px-4 sm:px-8 shadow-sm">
                
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="lg:hidden p-2 text-gray-600 hover:text-gray-900 rounded-lg focus:outline-none hover:bg-gray-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                    <div>
                        @isset($header)
                            {{ $header }}
                        @else
                            <h2 class="text-xl font-bold text-gray-900 leading-tight">Coach Dashboard</h2>
                        @endisset
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="hidden sm:flex items-center gap-2 text-xs font-semibold px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200/60">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>{{ now()->format('l, j F Y') }}</span>
                    </div>

                    <a href="{{ route('coach.dashboard') }}" class="px-3.5 py-1.5 text-xs font-bold rounded-lg bg-brand-green text-white hover:bg-brand-green-light transition-colors shadow-sm">
                        Refresh
                    </a>
                </div>

            </header>

            <!-- Page Body -->
            <main class="flex-1 p-4 sm:p-8 max-w-7xl w-full mx-auto">
                {{ $slot }}
            </main>

            <!-- Backoffice Footer -->
            <footer class="py-4 px-8 border-t border-gray-200 text-center text-xs text-gray-400 bg-white">
                &copy; {{ date('Y') }} The Money Circle — Financial Coaching Platform &bull; All Rights Reserved
            </footer>

        </div>

    </div>

</body>
</html>

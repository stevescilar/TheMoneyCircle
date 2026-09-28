<!DOCTYPE html>
<html lang="en" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>The Money Circle | Mobile App & Financial Coaching</title>
    
    <!-- Meta & Social -->
    <meta name="description" content="Download The Money Circle app. Track your daily expenses, clear debts, grow emergency funds in MMFs, and get direct personal advice from your Expert Coach.">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <!-- Google Fonts: Plus Jakarta Sans (Modern, Clean, Human) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-green': '#00381B',
                        'brand-green-dark': '#002411',
                        'brand-green-light': '#0A552C',
                        'brand-gold': '#C59121',
                        'brand-gold-light': '#DFC16B',
                        'brand-gold-dark': '#9A7015',
                        'surface': '#FBFDFB',
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                }
            }
        }
    </script>
</head>
<body class="font-sans antialiased text-gray-900 bg-surface selection:bg-brand-gold/30 selection:text-brand-green-dark flex flex-col min-h-screen">

    <!-- Top Announcement Bar -->
    <div class="bg-brand-green-dark text-white text-xs py-2 px-4 text-center font-medium border-b border-emerald-950/40">
        <span>✨ The Money Circle Android App v1.0 is now live for Circle Members.</span>
        <a href="#download" class="underline text-brand-gold-light ml-1.5 hover:text-white transition-colors">Download free below &darr;</a>
    </div>

    <!-- Navigation -->
    <header class="border-b border-gray-100 bg-white/90 backdrop-blur-md sticky top-0 z-40">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 h-20 flex items-center justify-between">
            
            <!-- Logo -->
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                <img src="{{ asset('images/logo.png') }}" alt="The Money Circle" class="w-10 h-10 rounded-xl object-contain shadow-xs group-hover:scale-105 transition-transform" />
                <div>
                    <span class="text-base font-extrabold text-brand-green-dark tracking-tight block leading-tight">The Money Circle</span>
                    <span class="text-[11px] font-semibold text-gray-500 tracking-wide block">Personal Financial Coaching</span>
                </div>
            </a>

            <!-- Nav Actions -->
            <div class="flex items-center gap-3">
                <a href="#how-it-works" class="hidden sm:inline-block text-xs font-semibold text-gray-600 hover:text-brand-green transition-colors px-3 py-2">
                    How It Works
                </a>
                <a href="#install-guide" class="hidden sm:inline-block text-xs font-semibold text-gray-600 hover:text-brand-green transition-colors px-3 py-2">
                    Install Guide
                </a>
                
                <a href="#download" class="inline-flex items-center gap-2 bg-brand-green text-white text-xs font-bold px-4 py-2.5 rounded-xl hover:bg-brand-green-light transition-all shadow-sm shadow-brand-green/20">
                    <svg class="w-4 h-4 text-brand-gold" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/>
                    </svg>
                    <span>Get APK</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1">

        <!-- Hero Section -->
        <section class="max-w-6xl mx-auto px-4 sm:px-6 pt-12 pb-20 lg:pt-16 lg:pb-24">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
                
                <!-- Left: Human Copy -->
                <div class="lg:col-span-7 text-center lg:text-left">
                    
                    <!-- Badge -->
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-50 border border-emerald-200/60 mb-6">
                        <span class="w-2 h-2 rounded-full bg-emerald-600 animate-pulse"></span>
                        <span class="text-xs font-bold text-emerald-800 uppercase tracking-wider">Official Companion App</span>
                    </div>

                    <!-- Heading -->
                    <h1 class="text-3xl sm:text-5xl lg:text-5xl font-extrabold text-brand-green-dark tracking-tight leading-[1.15]">
                        Take control of your money. <br class="hidden sm:inline"/>
                        <span class="text-brand-gold-dark">Guided by real coaching,</span> <br class="hidden sm:inline"/>
                        every step of the way.
                    </h1>

                    <!-- Description -->
                    <p class="mt-5 text-base sm:text-lg text-gray-600 leading-relaxed max-w-xl mx-auto lg:mx-0">
                        Stop budgeting on complex spreadsheets that get abandoned. The Money Circle app connects your everyday spending in Kenya with personal advice from your <b>Expert Coach</b>—so you actually clear your debts, save for emergencies in MMFs, and grow real wealth.
                    </p>

                    <!-- CTAs -->
                    <div id="download" class="mt-8 flex flex-col sm:flex-row items-center gap-4 justify-center lg:justify-start">
                        <a href="{{ url('/downloads/TheMoneyCircle.apk') }}" 
                           class="w-full sm:w-auto inline-flex items-center justify-center gap-3 bg-brand-green hover:bg-brand-green-light active:scale-[0.98] text-white px-7 py-4 rounded-2xl font-bold text-base shadow-xl shadow-brand-green/20 transition-all group">
                            <svg class="w-6 h-6 text-brand-gold-light group-hover:translate-y-0.5 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/>
                            </svg>
                            <div class="text-left leading-tight">
                                <span class="block text-[11px] text-emerald-200 font-semibold uppercase tracking-wider">Direct Android Download</span>
                                <span class="block text-base font-extrabold">Download APK (v1.0)</span>
                            </div>
                        </a>

                        <div class="text-xs text-gray-500 flex flex-col items-center lg:items-start">
                            <span class="flex items-center gap-1 font-semibold text-gray-700">
                                <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Verified Clean • Size: ~24 MB
                            </span>
                            <span class="mt-0.5 text-gray-500">Android 8.0 or newer</span>
                        </div>
                    </div>

                    <!-- Coach Signoff -->
                    <div class="mt-8 pt-6 border-t border-gray-100 flex items-center gap-4 justify-center lg:justify-start">
                        <div class="w-12 h-12 rounded-full bg-brand-green text-brand-gold flex items-center justify-center font-bold text-base shadow-sm">
                            <svg class="w-6 h-6 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                        </div>
                        <div class="text-left text-xs">
                            <p class="font-bold text-gray-900">Expert Coach</p>
                            <p class="text-gray-500">Lead Wealth Coach &bull; The Money Circle</p>
                        </div>
                    </div>

                </div>

                <!-- Right: Realistic Mobile Phone Mockup -->
                <div class="lg:col-span-5 flex justify-center">
                    
                    <!-- Phone Body Frame -->
                    <div class="w-[300px] sm:w-[320px] rounded-[42px] bg-gray-900 p-3 shadow-2xl shadow-emerald-950/30 border-4 border-gray-800 relative">
                        
                        <!-- Speaker / Camera Notch -->
                        <div class="absolute top-5 left-1/2 -translate-x-1/2 w-28 h-4 bg-gray-950 rounded-full z-20"></div>

                        <!-- Phone Inner Screen -->
                        <div class="bg-[#F8FAF9] rounded-[34px] overflow-hidden pt-7 pb-4 px-4 text-gray-800 text-left relative z-10 flex flex-col space-y-3.5">
                            
                            <!-- App Header -->
                            <div class="flex items-center justify-between pt-1">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-brand-green text-brand-gold flex items-center justify-center text-xs font-bold">
                                        AW
                                    </div>
                                    <div>
                                        <p class="text-[10px] text-gray-500 uppercase font-semibold">Welcome back,</p>
                                        <p class="text-xs font-bold text-brand-green-dark leading-tight">Alex Wambui</p>
                                    </div>
                                </div>
                                <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold">Circle Active</span>
                            </div>

                            <!-- Net Worth / Budget Card -->
                            <div class="bg-gradient-to-br from-brand-green to-brand-green-dark text-white rounded-2xl p-4 shadow-sm relative overflow-hidden">
                                <p class="text-[10px] text-emerald-200 uppercase tracking-wider font-semibold">This Month's Spending</p>
                                <p class="text-xl font-black mt-0.5 tracking-tight">Ksh 42,300 <span class="text-xs font-normal text-emerald-300">/ Ksh 70,000</span></p>
                                
                                <!-- Progress Bar -->
                                <div class="w-full bg-white/20 h-1.5 rounded-full mt-2.5 overflow-hidden">
                                    <div class="bg-brand-gold h-full rounded-full" style="width: 60%"></div>
                                </div>
                                <div class="flex justify-between items-center text-[10px] text-emerald-200 mt-1.5">
                                    <span>60% Used</span>
                                    <span>Ksh 27,700 Remaining</span>
                                </div>
                            </div>

                            <!-- Direct Coach Note Card -->
                            <div class="bg-amber-50/80 border border-amber-200/70 rounded-xl p-3">
                                <div class="flex items-center gap-1.5 mb-1 text-[11px] font-bold text-amber-900">
                                    <span class="text-brand-gold">★</span>
                                    <span>Coach's Advice</span>
                                </div>
                                <p class="text-[10px] text-amber-950 leading-relaxed font-medium">
                                    "Great discipline on discretionary spending this week! Put that Ksh 5,000 surplus straight into the Sacco loan."
                                </p>
                            </div>

                            <!-- Emergency Fund & Debt Grid -->
                            <div class="grid grid-cols-2 gap-2">
                                <div class="bg-white p-2.5 rounded-xl border border-gray-200/80 shadow-xs">
                                    <p class="text-[9px] text-gray-500 font-semibold uppercase">Emergency Fund</p>
                                    <p class="text-xs font-bold text-brand-green-dark mt-0.5">Ksh 45,000</p>
                                    <p class="text-[9px] text-emerald-700 font-medium">In CIC MMF (11.5%)</p>
                                </div>
                                <div class="bg-white p-2.5 rounded-xl border border-gray-200/80 shadow-xs">
                                    <p class="text-[9px] text-gray-500 font-semibold uppercase">Debt Snowball</p>
                                    <p class="text-xs font-bold text-red-600 mt-0.5">-Ksh 120,000</p>
                                    <p class="text-[9px] text-gray-500 font-medium">Next: Payoff in Dec</p>
                                </div>
                            </div>

                            <!-- Recent Transaction Snippet -->
                            <div class="bg-white rounded-xl p-2.5 border border-gray-200/80 shadow-xs">
                                <div class="flex justify-between items-center text-[10px]">
                                    <span class="font-bold text-gray-800">Quick Log</span>
                                    <span class="text-emerald-700 font-semibold">+ Add Entry</span>
                                </div>
                                <div class="flex items-center justify-between text-[10px] mt-1.5 text-gray-600">
                                    <span>🛒 Naivas Groceries</span>
                                    <span class="font-bold text-gray-900">-Ksh 3,200</span>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </section>

        <!-- Real Human Features (No Jargon) -->
        <section id="how-it-works" class="bg-white border-y border-gray-100 py-16 sm:py-20">
            <div class="max-w-6xl mx-auto px-4 sm:px-6">
                
                <div class="text-center max-w-2xl mx-auto mb-14">
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-brand-green-dark tracking-tight">
                        Built for real financial habits, not theory.
                    </h2>
                    <p class="mt-3 text-sm sm:text-base text-gray-600">
                        Everything in the app is built around the exact principles we teach in coaching circles.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    
                    <!-- Feature 1 -->
                    <div class="p-6 rounded-2xl bg-surface border border-gray-200/70 hover:border-brand-green/30 transition-all">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 text-brand-green flex items-center justify-center font-bold mb-4">
                            1
                        </div>
                        <h3 class="text-base font-bold text-gray-900 mb-2">Track in Under 10 Seconds</h3>
                        <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                            Log your M-Pesa, cash, or card expenses on the go with categories that actually make sense for Kenya (Rent, Groceries, Chama/Sacco, Family Support, and Fun).
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="p-6 rounded-2xl bg-surface border border-gray-200/70 hover:border-brand-green/30 transition-all">
                        <div class="w-10 h-10 rounded-xl bg-amber-100 text-brand-gold-dark flex items-center justify-center font-bold mb-4">
                            2
                        </div>
                        <h3 class="text-base font-bold text-gray-900 mb-2">Real Coach Feedback</h3>
                        <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                            Submit your Monthly Reflection inside the app. Your coach reviews your actual numbers and leaves actionable advice on where to optimize and celebrate.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="p-6 rounded-2xl bg-surface border border-gray-200/70 hover:border-brand-green/30 transition-all">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 text-brand-green flex items-center justify-center font-bold mb-4">
                            3
                        </div>
                        <h3 class="text-base font-bold text-gray-900 mb-2">Community Q&A & Wins</h3>
                        <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                            Ask financial questions to get coach-verified answers, celebrate milestones (debt paid off, emergency funds hit), and cheer fellow circle members.
                        </p>
                    </div>

                </div>

            </div>
        </section>

        <!-- Install Guide (How to install APK on Android) -->
        <section id="install-guide" class="py-16 sm:py-20 max-w-5xl mx-auto px-4 sm:px-6">
            <div class="bg-emerald-50/60 rounded-3xl p-8 sm:p-12 border border-emerald-100">
                <div class="max-w-2xl">
                    <span class="text-xs font-bold text-emerald-800 uppercase tracking-wider">Quick & Safe Installation</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-brand-green-dark tracking-tight mt-1">
                        How to install on your Android phone
                    </h2>
                    <p class="mt-3 text-xs sm:text-sm text-gray-600 leading-relaxed">
                        Because you are downloading the direct APK from our secure portal, Android will simply ask for permission to install it. It takes under 30 seconds:
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mt-8">
                    
                    <div class="bg-white p-5 rounded-2xl border border-emerald-100 shadow-xs">
                        <span class="text-xs font-extrabold text-brand-gold bg-amber-50 px-2.5 py-1 rounded-md">STEP 1</span>
                        <h4 class="font-bold text-sm text-gray-900 mt-3">Download the APK</h4>
                        <p class="text-xs text-gray-500 mt-1.5 leading-relaxed">
                            Tap the <b>Download APK</b> button. Your browser will start downloading the file.
                        </p>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-emerald-100 shadow-xs">
                        <span class="text-xs font-extrabold text-brand-gold bg-amber-50 px-2.5 py-1 rounded-md">STEP 2</span>
                        <h4 class="font-bold text-sm text-gray-900 mt-3">Allow Installation</h4>
                        <p class="text-xs text-gray-500 mt-1.5 leading-relaxed">
                            If Android displays a prompt, tap <b>Settings</b> and toggle on <b>"Allow from this source"</b>.
                        </p>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-emerald-100 shadow-xs">
                        <span class="text-xs font-extrabold text-brand-gold bg-amber-50 px-2.5 py-1 rounded-md">STEP 3</span>
                        <h4 class="font-bold text-sm text-gray-900 mt-3">Open & Log In</h4>
                        <p class="text-xs text-gray-500 mt-1.5 leading-relaxed">
                            Tap <b>Install</b>, open the app, and log in with your registered member email and password.
                        </p>
                    </div>

                </div>

                <div class="mt-8 pt-6 border-t border-emerald-200/60 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p class="text-xs text-gray-600">
                        Need help or didn't get your login credentials yet? Ask in the circle WhatsApp group.
                    </p>
                    <a href="{{ url('/downloads/TheMoneyCircle.apk') }}" class="inline-flex items-center gap-2 text-xs font-bold text-brand-green hover:text-brand-green-dark">
                        <span>Download APK File Now</span> &rarr;
                    </a>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="border-t border-gray-100 bg-white py-10 text-xs text-gray-500">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="The Money Circle" class="w-6 h-6 object-contain" />
                <p>&copy; {{ date('Y') }} The Money Circle. All rights reserved.</p>
            </div>
            <div class="flex items-center gap-6">
                <a href="#download" class="hover:text-brand-green transition-colors font-semibold">Download Android App</a>
                
            </div>
        </div>
    </footer>

</body>
</html>
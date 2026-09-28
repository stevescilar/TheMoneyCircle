<x-guest-layout>
    <!-- Header inside card -->
    <div class="mb-6 text-center">
        <h2 class="text-xl font-extrabold text-brand-green-dark">Welcome to your Portal</h2>
        <p class="text-xs text-gray-500 mt-1">Enter your coach or super admin credentials to proceed</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                Email Address
            </label>
            <div class="relative rounded-xl shadow-xs">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"/>
                    </svg>
                </div>
                <input id="email" 
                       type="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       required 
                       autofocus 
                       autocomplete="username"
                       placeholder="coach@themoneycircle.com"
                       class="block w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-brand-gold focus:border-brand-gold transition-all" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                    Password
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs font-semibold text-brand-gold-dark hover:text-brand-green transition-colors">
                        Forgot password?
                    </a>
                @endif
            </div>
            <div class="relative rounded-xl shadow-xs">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <input id="password" 
                       type="password" 
                       name="password" 
                       required 
                       autocomplete="current-password"
                       placeholder="••••••••••••"
                       class="block w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-brand-gold focus:border-brand-gold transition-all" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <!-- Remember Me Checkbox -->
        <div class="flex items-center justify-between pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" 
                       type="checkbox" 
                       name="remember" 
                       class="w-4 h-4 rounded text-brand-gold border-gray-300 focus:ring-brand-gold focus:ring-offset-0 cursor-pointer">
                <span class="ms-2 text-xs font-medium text-gray-600">Keep me logged in</span>
            </label>
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" 
                    class="w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl font-extrabold text-sm bg-gradient-to-r from-brand-gold-light via-brand-gold to-brand-gold-dark text-brand-green-dark shadow-lg shadow-brand-gold/25 hover:brightness-110 hover:scale-[1.01] active:scale-[0.99] transition-all cursor-pointer">
                <span>Sign In to Command Center</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </button>
        </div>
    </form>

    <!-- Security Micro-Badge -->
    <div class="mt-6 pt-5 border-t border-gray-100 flex items-center justify-center gap-2 text-[11px] text-gray-400">
        <svg class="w-3.5 h-3.5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        <span>Secure 256-bit Encrypted Backoffice Session</span>
    </div>
</x-guest-layout>
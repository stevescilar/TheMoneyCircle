<section class="space-y-5">
    <header class="border-b border-gray-100 pb-3">
        <h2 class="text-base font-extrabold text-gray-900">
            Coach Credentials & Public Bio
        </h2>
        <p class="mt-1 text-xs text-gray-500">
            Update your professional title, WhatsApp direct line, and coaching philosophy shown to members across the app.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-4">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Full Name -->
            <div>
                <label for="name" class="block text-xs font-bold text-gray-700 mb-1">Coach Full Name *</label>
                <input id="name" name="name" type="text" 
                       class="w-full text-xs border border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-brand-green focus:border-brand-green" 
                       value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                @if ($errors->has('name'))
                    <p class="text-xs text-red-600 mt-1">{{ $errors->first('name') }}</p>
                @endif
            </div>

            <!-- Professional Title -->
            <div>
                <label for="title" class="block text-xs font-bold text-gray-700 mb-1">Professional Title</label>
                <input id="title" name="title" type="text" 
                       placeholder="e.g. Lead Wealth & Debt Elimination Coach"
                       class="w-full text-xs border border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-brand-green focus:border-brand-green" 
                       value="{{ old('title', $user->title) }}" />
                @if ($errors->has('title'))
                    <p class="text-xs text-red-600 mt-1">{{ $errors->first('title') }}</p>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Email -->
            <div>
                <label for="email" class="block text-xs font-bold text-gray-700 mb-1">Official Coach Email *</label>
                <input id="email" name="email" type="email" 
                       class="w-full text-xs border border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-brand-green focus:border-brand-green" 
                       value="{{ old('email', $user->email) }}" required autocomplete="username" />
                @if ($errors->has('email'))
                    <p class="text-xs text-red-600 mt-1">{{ $errors->first('email') }}</p>
                @endif

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-2 text-xs text-amber-700 bg-amber-50 p-2 rounded-lg border border-amber-200">
                        <span>Your email address is unverified.</span>
                        <button form="send-verification" class="underline font-bold text-brand-green hover:text-brand-green-light ml-1">
                            Resend verification link
                        </button>
                    </div>
                @endif
            </div>

            <!-- Phone / WhatsApp -->
            <div>
                <label for="phone" class="block text-xs font-bold text-gray-700 mb-1">Phone / WhatsApp Direct Line</label>
                <input id="phone" name="phone" type="text" 
                       placeholder="+254 712 345 678"
                       class="w-full text-xs border border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-brand-green focus:border-brand-green" 
                       value="{{ old('phone', $user->phone) }}" />
                <span class="text-[10px] text-gray-400 mt-0.5 block">Used for 1-click WhatsApp messaging from Member 360 profile</span>
                @if ($errors->has('phone'))
                    <p class="text-xs text-red-600 mt-1">{{ $errors->first('phone') }}</p>
                @endif
            </div>
        </div>

        <!-- Coaching Specialties -->
        <div>
            <label for="specialties" class="block text-xs font-bold text-gray-700 mb-1">Coaching Core Specialties</label>
            <input id="specialties" name="specialties" type="text" 
                   placeholder="e.g. Debt Snowball / Avalanche, Money Market Funds, Emergency Buffers, Zero-Based Budgeting"
                   class="w-full text-xs border border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-brand-green focus:border-brand-green" 
                   value="{{ old('specialties', $user->specialties) }}" />
            @if ($errors->has('specialties'))
                <p class="text-xs text-red-600 mt-1">{{ $errors->first('specialties') }}</p>
            @endif
        </div>

        <!-- Bio & Philosophy -->
        <div>
            <label for="bio" class="block text-xs font-bold text-gray-700 mb-1">Coaching Bio & Advisory Philosophy</label>
            <textarea id="bio" name="bio" rows="4" 
                      placeholder="Share your background, coaching approach, and words of encouragement for circle members..."
                      class="w-full text-xs border border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-brand-green focus:border-brand-green">{{ old('bio', $user->bio) }}</textarea>
            @if ($errors->has('bio'))
                <p class="text-xs text-red-600 mt-1">{{ $errors->first('bio') }}</p>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" 
                    class="px-5 py-2.5 bg-brand-green text-white text-xs font-extrabold rounded-xl hover:bg-brand-green-light transition-all shadow-md flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Save Profile Changes</span>
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }"
                   x-show="show"
                   x-transition
                   x-init="setTimeout(() => show = false, 3000)"
                   class="text-xs font-bold text-emerald-600 flex items-center gap-1">
                    <span>✓</span> Saved successfully.
                </p>
            @endif
        </div>
    </form>
</section>

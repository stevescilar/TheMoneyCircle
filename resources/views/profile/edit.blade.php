<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <h2 class="font-extrabold text-2xl text-brand-green leading-tight">
                Coach Profile & Settings
            </h2>
            <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full bg-brand-green/10 text-brand-green">
                Executive Account
            </span>
        </div>
    </x-slot>

    <div class="space-y-6">

        <!-- Coach Overview Hero Card -->
        <div class="rounded-2xl p-6 bg-gradient-to-r from-brand-green via-brand-green-light to-brand-green text-white shadow-lg relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-brand-gold/10 rounded-full blur-2xl -mr-16 -mt-16 pointer-events-none"></div>

            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-5">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-brand-green-dark border-2 border-brand-gold flex items-center justify-center font-black text-2xl text-brand-gold shadow-md">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="font-extrabold text-xl text-white">{{ $user->name }}</h3>
                            @if ($user->isSuperAdmin())
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-brand-gold text-brand-green-dark flex items-center gap-1 shadow-xs">
                                    <span>★</span> SUPER ADMIN
                                </span>
                            @else
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-brand-gold text-brand-green-dark flex items-center gap-1 shadow-xs">
                                    <span>★</span> VERIFIED COACH
                                </span>
                            @endif
                        </div>
                        <p class="text-xs text-brand-gold mt-0.5 font-semibold">
                            {{ $user->title ?: 'Financial Coach & Circle Advisor' }}
                        </p>
                        <p class="text-[11px] text-white/70 mt-1 flex items-center gap-2">
                            <span>📧 {{ $user->email }}</span>
                            @if ($user->phone)
                                <span>&bull; 📱 {{ $user->phone }}</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3 border-t sm:border-t-0 pt-3 sm:pt-0 border-white/10">
                    <div class="px-4 py-2 rounded-xl bg-white/10 backdrop-blur-xs text-center border border-white/10">
                        <div class="text-lg font-black text-white">{{ $stats['total_members'] ?? 0 }}</div>
                        <div class="text-[10px] text-white/70 font-semibold uppercase tracking-wider">Members Coached</div>
                    </div>
                    <div class="px-4 py-2 rounded-xl bg-white/10 backdrop-blur-xs text-center border border-white/10">
                        <div class="text-xs font-bold text-white mt-1">{{ $stats['joined_date'] ?? 'Active' }}</div>
                        <div class="text-[10px] text-white/70 font-semibold uppercase tracking-wider">Coach Since</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 1: Credentials & Bio -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            @include('profile.partials.update-profile-information-form')
        </div>

        <!-- Section 2: Security & Password Update -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Section 3: Account Deletion (Danger Zone) -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>

    </div>
</x-app-layout>

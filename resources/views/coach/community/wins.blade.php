<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-600 flex items-center justify-center font-bold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-extrabold text-2xl text-brand-green leading-tight">
                        Community Wins Wall
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">Celebrate financial milestones, savings breakthroughs & debt payoffs</p>
                </div>
            </div>
            <div>
                <button type="button"
                        onclick="window.dispatchEvent(new CustomEvent('open-create-win'))"
                        class="px-4 py-2 bg-brand-green text-white text-xs font-bold rounded-xl hover:bg-brand-green-light transition-all shadow-md flex items-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Publish Spotlight Win</span>
                </button>
            </div>
        </div>
    </x-slot>

    <div x-data="{ showCreateModal: false }" @open-create-win.window="showCreateModal = true" class="space-y-6">

        <!-- Status Notification Toast -->
        @if (session('status'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-sm font-semibold flex items-center gap-2 shadow-xs">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <!-- Executive Metrics Bar -->
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
            <!-- Metric 1: Total Celebrations -->
            <div class="bg-white rounded-2xl p-5 shadow-xs border border-gray-100 flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400">Total Milestones</span>
                    <div class="text-2xl font-black text-gray-900 mt-1">{{ $stats['total_wins'] }}</div>
                    <p class="text-xs text-gray-500 mt-0.5">Published stories</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                    🏆
                </div>
            </div>

            <!-- Metric 2: Total Community Cheers -->
            <div class="bg-white rounded-2xl p-5 shadow-xs border border-gray-100 flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-red-500">Community Cheers</span>
                    <div class="text-2xl font-black text-red-600 mt-1">{{ number_format($stats['total_cheers']) }}</div>
                    <p class="text-xs text-gray-500 mt-0.5">Encouragement sent</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center font-bold">
                    🎉
                </div>
            </div>

            <!-- Metric 3: Total Money Celebrated -->
            <div class="bg-white rounded-2xl p-5 shadow-xs border border-gray-100 flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-700">Funds Celebrated</span>
                    <div class="text-xl font-black text-emerald-700 mt-1">Ksh {{ number_format($stats['total_amount_celebrated']) }}</div>
                    <p class="text-xs text-gray-500 mt-0.5">Paid off or accumulated</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold">
                    💰
                </div>
            </div>

            <!-- Metric 4: Debt Cleared Count -->
            <div class="bg-white rounded-2xl p-5 shadow-xs border border-gray-100 flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-brand-green">Debt-Free Wins</span>
                    <div class="text-2xl font-black text-brand-green mt-1">{{ $stats['debt_cleared_count'] }}</div>
                    <p class="text-xs text-gray-500 mt-0.5">Loans completely cleared</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-brand-green/10 text-brand-green flex items-center justify-center font-bold">
                    📉
                </div>
            </div>
        </div>

        <!-- Filter & Search Console -->
        <div class="bg-white rounded-2xl p-5 shadow-xs border border-gray-100 space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                
                <!-- Category Tabs -->
                <div class="flex items-center gap-1.5 overflow-x-auto pb-1 sm:pb-0 text-xs font-bold">
                    <a href="{{ route('coach.wins.index', request()->except('category')) }}"
                       class="px-3 py-1.5 rounded-xl transition-all shrink-0 {{ empty($selectedCategory) ? 'bg-brand-green text-white shadow-xs' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        All Wins ({{ $stats['total_wins'] }})
                    </a>
                    @foreach ([
                        'debt_cleared' => 'Debt Cleared 📉',
                        'emergency_fund' => 'Emergency Fund 🛡️',
                        'savings_goal' => 'Savings Goal 🎯',
                        'budget_habit' => 'Budget Habit ⚡',
                        'general' => 'General 💡'
                    ] as $catKey => $catLabel)
                        <a href="{{ route('coach.wins.index', array_merge(request()->query(), ['category' => $catKey])) }}"
                           class="px-3 py-1.5 rounded-xl transition-all shrink-0 {{ $selectedCategory === $catKey ? 'bg-brand-green text-white shadow-xs' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                            {{ $catLabel }}
                        </a>
                    @endforeach
                </div>

                <!-- Search Form -->
                <form method="GET" action="{{ route('coach.wins.index') }}" class="flex items-center gap-2">
                    @if ($selectedCategory)
                        <input type="hidden" name="category" value="{{ $selectedCategory }}">
                    @endif
                    <div class="relative w-full sm:w-60">
                        <input type="text" 
                               name="search" 
                               value="{{ $searchQuery }}" 
                               placeholder="Search member, story..." 
                               class="w-full text-xs rounded-xl border border-gray-200 pl-8 pr-3 py-2 focus:ring-2 focus:ring-brand-green focus:border-brand-green transition-all">
                        <svg class="w-4 h-4 text-gray-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    @if ($searchQuery)
                        <a href="{{ route('coach.wins.index', array_merge(request()->except('search'))) }}" 
                           class="text-xs text-gray-500 hover:text-red-500 font-bold px-2 py-2">
                            Clear
                        </a>
                    @endif
                </form>
            </div>
        </div>

        <!-- Wins Grid -->
        @if ($wins->isEmpty())
            <div class="bg-white rounded-2xl p-12 text-center border border-gray-100 shadow-xs space-y-3">
                <div class="w-16 h-16 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center mx-auto text-2xl font-bold">
                    🎉
                </div>
                <h3 class="text-base font-bold text-gray-900">No Milestones Found</h3>
                <p class="text-xs text-gray-500 max-w-md mx-auto">
                    No community wins match the current category or search criteria. Click above to spotlight a new milestone or clear filters.
                </p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach ($wins as $win)
                    @php
                        $categoryBadges = [
                            'debt_cleared' => ['label' => 'Debt Cleared', 'color' => 'bg-emerald-50 text-emerald-800 border-emerald-200', 'icon' => '📉'],
                            'emergency_fund' => ['label' => 'Emergency Fund', 'color' => 'bg-blue-50 text-blue-800 border-blue-200', 'icon' => '🛡️'],
                            'savings_goal' => ['label' => 'Savings Goal', 'color' => 'bg-purple-50 text-purple-800 border-purple-200', 'icon' => '🎯'],
                            'budget_habit' => ['label' => 'Budget Habit', 'color' => 'bg-amber-50 text-amber-800 border-amber-200', 'icon' => '⚡'],
                            'general' => ['label' => 'Milestone', 'color' => 'bg-gray-50 text-gray-700 border-gray-200', 'icon' => '💡'],
                        ];
                        $badge = $categoryBadges[$win->category] ?? $categoryBadges['general'];
                    @endphp

                    <div class="bg-white rounded-2xl p-6 shadow-xs border border-gray-100 flex flex-col justify-between hover:shadow-md transition-all space-y-4">
                        <div class="space-y-3">
                            <!-- Card Header -->
                            <div class="flex items-center justify-between pb-3 border-b border-gray-50">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-9 h-9 rounded-full bg-brand-green/10 text-brand-green flex items-center justify-center font-black text-xs">
                                        {{ strtoupper(substr($win->member_name ?? 'M', 0, 2)) }}
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-bold text-gray-900">{{ $win->member_name }}</h4>
                                        <p class="text-[10px] text-gray-400">{{ $win->created_at ? $win->created_at->diffForHumans() : 'Recently' }}</p>
                                    </div>
                                </div>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $badge['color'] }} flex items-center gap-1">
                                    <span>{{ $badge['icon'] }}</span>
                                    <span>{{ $badge['label'] }}</span>
                                </span>
                            </div>

                            <!-- Title -->
                            <h3 class="text-sm font-extrabold text-gray-900 leading-snug">
                                {{ $win->title }}
                            </h3>

                            <!-- Amount celebrated pill (if any) -->
                            @if ($win->amount_celebrated)
                                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-black">
                                    <span>💰</span>
                                    <span>Ksh {{ number_format($win->amount_celebrated, 2) }}</span>
                                </div>
                            @endif

                            <!-- Story -->
                            <p class="text-xs text-gray-600 leading-relaxed whitespace-pre-line">
                                {{ $win->story }}
                            </p>
                        </div>

                        <!-- Card Footer -->
                        <div class="pt-3 border-t border-gray-100 flex items-center justify-between text-xs">
                            <!-- Cheer Action -->
                            <form method="POST" action="{{ route('coach.wins.cheer', $win) }}">
                                @csrf
                                <button type="submit" 
                                        class="px-3 py-1.5 rounded-xl bg-red-50 text-red-600 hover:bg-red-100 border border-red-100 transition-colors font-bold flex items-center gap-1.5 cursor-pointer">
                                    <span>❤️ Cheer</span>
                                    <span class="font-extrabold font-mono text-[11px]">{{ $win->cheers_count }}</span>
                                </button>
                            </form>

                            <!-- Delete Action -->
                            <form method="POST" action="{{ route('coach.wins.destroy', $win) }}" onsubmit="return confirm('Remove this win celebration from the wall?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                                        title="Delete Milestone">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $wins->links() }}
            </div>
        @endif

        <!-- Publish Spotlight Win Modal -->
        <div x-show="showCreateModal" 
             style="display: none;"
             class="fixed inset-0 z-50 overflow-y-auto" 
             aria-labelledby="modal-title" 
             role="dialog" 
             aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showCreateModal" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-gray-900/60 backdrop-blur-xs transition-opacity" 
                     @click="showCreateModal = false"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="showCreateModal" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    
                    <form method="POST" action="{{ route('coach.wins.store') }}">
                        @csrf
                        <div class="p-6 sm:p-8 space-y-5">
                            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                                <h3 class="text-lg font-extrabold text-brand-green">
                                    Publish Spotlight Win 🎉
                                </h3>
                                <button type="button" @click="showCreateModal = false" class="text-gray-400 hover:text-gray-600 text-sm font-bold">
                                    ✕
                                </button>
                            </div>

                            <!-- Member Name -->
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-1.5">
                                    Member Name / Alias *
                                </label>
                                <input type="text" 
                                       name="member_name" 
                                       required 
                                       placeholder="e.g. Wanjiku M. or Brian O." 
                                       class="w-full text-xs rounded-xl border border-gray-200 px-3.5 py-2.5 focus:ring-2 focus:ring-brand-green focus:border-brand-green">
                            </div>

                            <!-- Category -->
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-1.5">
                                    Milestone Category *
                                </label>
                                <select name="category" 
                                        required 
                                        class="w-full text-xs rounded-xl border border-gray-200 px-3.5 py-2.5 focus:ring-2 focus:ring-brand-green focus:border-brand-green">
                                    <option value="debt_cleared">Debt Cleared (Credit card, Sacco, mobile loans)</option>
                                    <option value="emergency_fund">Emergency Fund (Hit 3-6 months cushion)</option>
                                    <option value="savings_goal">Savings Goal (Major target achieved)</option>
                                    <option value="budget_habit">Budget Habit (Impulse control, expense discipline)</option>
                                    <option value="general">General Financial Breakthrough</option>
                                </select>
                            </div>

                            <!-- Amount Celebrated -->
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-1.5">
                                    Amount Celebrated (Ksh - Optional)
                                </label>
                                <input type="number" 
                                       step="0.01" 
                                       name="amount_celebrated" 
                                       placeholder="e.g. 50000" 
                                       class="w-full text-xs rounded-xl border border-gray-200 px-3.5 py-2.5 focus:ring-2 focus:ring-brand-green focus:border-brand-green">
                            </div>

                            <!-- Title -->
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-1.5">
                                    Celebration Headline *
                                </label>
                                <input type="text" 
                                       name="title" 
                                       required 
                                       placeholder="e.g. Cleared my Stanbic Credit Card in Full!" 
                                       class="w-full text-xs rounded-xl border border-gray-200 px-3.5 py-2.5 focus:ring-2 focus:ring-brand-green focus:border-brand-green">
                            </div>

                            <!-- Story -->
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-1.5">
                                    Story & Background *
                                </label>
                                <textarea name="story" 
                                          rows="4" 
                                          required 
                                          placeholder="Share the journey, sacrifices made, budgeting habits that enabled this breakthrough, and words of encouragement..." 
                                          class="w-full text-xs rounded-xl border border-gray-200 p-3.5 focus:ring-2 focus:ring-brand-green focus:border-brand-green"></textarea>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-6 py-4 flex items-center justify-end gap-3 border-t border-gray-100">
                            <button type="button" 
                                    @click="showCreateModal = false" 
                                    class="px-4 py-2 text-xs font-bold text-gray-600 hover:text-gray-800">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="px-5 py-2 bg-brand-green text-white text-xs font-bold rounded-xl hover:bg-brand-green-light transition-all shadow-md">
                                Publish to Wins Wall
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>


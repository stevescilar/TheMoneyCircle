<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-600 flex items-center justify-center font-bold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-extrabold text-2xl text-brand-green leading-tight">
                        Coach Q&A Desk
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">Answer member financial questions with official verified coaching advice</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                @if ($stats['pending_coach'] > 0)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-amber-50 border border-amber-200 text-amber-800 text-xs font-bold animate-pulse">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        {{ $stats['pending_coach'] }} Pending Coach Advice
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold">
                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                        All Caught Up!
                    </span>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">

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
            <!-- Metric 1: Total Inquiries -->
            <div class="bg-white rounded-2xl p-5 shadow-xs border border-gray-100 flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400">Total Discussions</span>
                    <div class="text-2xl font-black text-gray-900 mt-1">{{ $stats['total'] }}</div>
                    <p class="text-xs text-gray-500 mt-0.5">{{ $stats['total_answers'] }} community replies</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-gray-100 text-gray-600 flex items-center justify-center font-bold">
                    💬
                </div>
            </div>

            <!-- Metric 2: Awaiting Coach Advice -->
            <div class="bg-white rounded-2xl p-5 shadow-xs border {{ $stats['pending_coach'] > 0 ? 'border-amber-200 bg-amber-50/20' : 'border-gray-100' }} flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-amber-700">Needs Coach Advice</span>
                    <div class="text-2xl font-black {{ $stats['pending_coach'] > 0 ? 'text-amber-600' : 'text-gray-900' }} mt-1">
                        {{ $stats['pending_coach'] }}
                    </div>
                    <p class="text-xs text-gray-500 mt-0.5">Zero coach responses yet</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center font-bold">
                    ⏳
                </div>
            </div>

            <!-- Metric 3: Coach Answered -->
            <div class="bg-white rounded-2xl p-5 shadow-xs border border-gray-100 flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-brand-green">Coach Answered</span>
                    <div class="text-2xl font-black text-brand-green mt-1">{{ $stats['coach_answered'] }}</div>
                    <p class="text-xs text-gray-500 mt-0.5">Official verified guidance</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-brand-gold/20 text-brand-gold-dark flex items-center justify-center font-bold">
                    ⭐
                </div>
            </div>

            <!-- Metric 4: Resolved Discussions -->
            <div class="bg-white rounded-2xl p-5 shadow-xs border border-gray-100 flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-700">Resolved Threads</span>
                    <div class="text-2xl font-black text-emerald-700 mt-1">{{ $stats['resolved'] }}</div>
                    <p class="text-xs text-gray-500 mt-0.5">Completed inquiries</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold">
                    ✅
                </div>
            </div>
        </div>

        <!-- Filter & Search Console -->
        <div class="bg-white rounded-2xl p-5 shadow-xs border border-gray-100 space-y-4">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                
                <!-- Status Filter Pills -->
                <div class="flex items-center gap-1.5 overflow-x-auto pb-1 sm:pb-0">
                    <a href="{{ route('coach.questions.index', array_merge(request()->query(), ['filter' => 'all'])) }}"
                       class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all shrink-0 {{ $selectedFilter === 'all' ? 'bg-brand-green text-white shadow-xs' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        All Questions ({{ $stats['total'] }})
                    </a>
                    <a href="{{ route('coach.questions.index', array_merge(request()->query(), ['filter' => 'pending_coach'])) }}"
                       class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all shrink-0 flex items-center gap-1.5 {{ $selectedFilter === 'pending_coach' ? 'bg-amber-500 text-white shadow-xs' : 'bg-amber-50 text-amber-700 hover:bg-amber-100' }}">
                        <span>Needs Coach Advice</span>
                        <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $selectedFilter === 'pending_coach' ? 'bg-white/20 text-white' : 'bg-amber-200 text-amber-800' }} font-mono">
                            {{ $stats['pending_coach'] }}
                        </span>
                    </a>
                    <a href="{{ route('coach.questions.index', array_merge(request()->query(), ['filter' => 'coach_answered'])) }}"
                       class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all shrink-0 {{ $selectedFilter === 'coach_answered' ? 'bg-brand-gold text-brand-green-dark shadow-xs' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Coach Answered ⭐
                    </a>
                    <a href="{{ route('coach.questions.index', array_merge(request()->query(), ['filter' => 'resolved'])) }}"
                       class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all shrink-0 {{ $selectedFilter === 'resolved' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Resolved ✅
                    </a>
                </div>

                <!-- Search Input Form -->
                <form method="GET" action="{{ route('coach.questions.index') }}" class="flex items-center gap-2">
                    @if ($selectedFilter !== 'all')
                        <input type="hidden" name="filter" value="{{ $selectedFilter }}">
                    @endif
                    @if ($selectedCategory)
                        <input type="hidden" name="category" value="{{ $selectedCategory }}">
                    @endif
                    <div class="relative w-full sm:w-64">
                        <input type="text" 
                               name="search" 
                               value="{{ $searchQuery }}" 
                               placeholder="Search questions or author..." 
                               class="w-full text-xs rounded-xl border border-gray-200 pl-8 pr-3 py-2 focus:ring-2 focus:ring-brand-green focus:border-brand-green transition-all">
                        <svg class="w-4 h-4 text-gray-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    @if ($searchQuery)
                        <a href="{{ route('coach.questions.index', array_merge(request()->except('search'))) }}" 
                           class="text-xs text-gray-500 hover:text-red-500 font-bold px-2 py-2">
                            Clear
                        </a>
                    @endif
                </form>
            </div>

            <!-- Categories Filter -->
            <div class="flex items-center gap-2 pt-2 border-t border-gray-100 overflow-x-auto text-xs">
                <span class="text-gray-400 font-bold uppercase tracking-wider text-[10px] shrink-0">Category:</span>
                <a href="{{ route('coach.questions.index', array_merge(request()->except('category'))) }}"
                   class="px-2.5 py-1 rounded-lg font-medium transition-colors shrink-0 {{ empty($selectedCategory) ? 'bg-gray-900 text-white font-bold' : 'text-gray-600 hover:bg-gray-100' }}">
                    All
                </a>
                @foreach (['saving' => 'Saving 💰', 'debt' => 'Debt 📉', 'investing' => 'Investing 📈', 'budgeting' => 'Budgeting 🧾', 'general' => 'General 💡'] as $catKey => $catName)
                    <a href="{{ route('coach.questions.index', array_merge(request()->query(), ['category' => $catKey])) }}"
                       class="px-2.5 py-1 rounded-lg font-medium transition-colors shrink-0 {{ $selectedCategory === $catKey ? 'bg-brand-green text-white font-bold' : 'text-gray-600 hover:bg-gray-100' }}">
                        {{ $catName }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Questions Feed -->
        @if ($questions->isEmpty())
            <div class="bg-white rounded-2xl p-12 text-center border border-gray-100 shadow-xs space-y-3">
                <div class="w-16 h-16 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center mx-auto text-2xl font-bold">
                    💬
                </div>
                <h3 class="text-base font-bold text-gray-900">No Questions Match Your Filter</h3>
                <p class="text-xs text-gray-500 max-w-md mx-auto">
                    There are currently no community questions matching the selected status or category filters. Check back or clear filters to view all questions.
                </p>
                <div class="pt-2">
                    <a href="{{ route('coach.questions.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 text-xs font-bold rounded-xl hover:bg-gray-200 transition-colors">
                        Reset All Filters
                    </a>
                </div>
            </div>
        @else
            <div class="space-y-4">
                @foreach ($questions as $q)
                    @php
                        $hasCoachAnswer = $q->answers->contains(fn($ans) => (bool) $ans->is_coach_verified);
                        $categoryColors = [
                            'saving' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
                            'debt' => 'bg-red-50 text-red-800 border-red-200',
                            'investing' => 'bg-purple-50 text-purple-800 border-purple-200',
                            'budgeting' => 'bg-blue-50 text-blue-800 border-blue-200',
                            'general' => 'bg-gray-50 text-gray-700 border-gray-200',
                        ];
                        $catBadge = $categoryColors[$q->category] ?? 'bg-gray-50 text-gray-700 border-gray-200';
                    @endphp

                    <div class="bg-white rounded-2xl p-6 shadow-xs border transition-all hover:shadow-md {{ $hasCoachAnswer ? 'border-gray-100' : 'border-amber-200 bg-amber-50/10' }}">
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                            
                            <!-- Question Info -->
                            <div class="flex-1 space-y-2">
                                <!-- Top Badges Row -->
                                <div class="flex flex-wrap items-center gap-2 text-xs">
                                    <span class="px-2.5 py-0.5 rounded-full font-bold border uppercase tracking-wider text-[10px] {{ $catBadge }}">
                                        {{ ucfirst($q->category) }}
                                    </span>

                                    @if ($hasCoachAnswer)
                                        <span class="px-2.5 py-0.5 rounded-full font-bold bg-amber-100 text-amber-900 border border-amber-200 text-[10px] flex items-center gap-1">
                                            <span>⭐</span>
                                            <span>Coach Answered</span>
                                        </span>
                                    @else
                                        <span class="px-2.5 py-0.5 rounded-full font-bold bg-amber-500 text-white text-[10px] flex items-center gap-1 shadow-xs">
                                            <span>⏳</span>
                                            <span>Awaiting Coach Advice</span>
                                        </span>
                                    @endif

                                    @if ($q->is_resolved)
                                        <span class="px-2 py-0.5 rounded-full font-bold bg-emerald-100 text-emerald-800 text-[10px]">
                                            Resolved ✓
                                        </span>
                                    @endif

                                    <span class="text-gray-400 text-xs">•</span>
                                    <span class="text-gray-500 font-medium">Asked by <strong class="text-gray-900">{{ $q->author_name }}</strong></span>
                                    <span class="text-gray-400 text-xs">•</span>
                                    <span class="text-gray-400 text-xs">{{ $q->created_at ? $q->created_at->diffForHumans() : 'Recently' }}</span>
                                </div>

                                <!-- Question Title -->
                                <h3 class="text-base font-bold text-gray-900 hover:text-brand-green transition-colors">
                                    <a href="{{ route('coach.questions.show', $q) }}">
                                        {{ $q->title }}
                                    </a>
                                </h3>

                                <!-- Body Snippet -->
                                <p class="text-xs text-gray-600 line-clamp-2 leading-relaxed">
                                    {{ $q->body }}
                                </p>

                                <!-- Thread Meta -->
                                <div class="flex items-center gap-4 text-xs text-gray-400 pt-1">
                                    <span class="flex items-center gap-1 font-medium text-gray-600">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                        </svg>
                                        {{ $q->answers_count }} {{ Str::plural('reply', $q->answers_count) }}
                                    </span>
                                    <span>•</span>
                                    <span>{{ $q->views_count }} views</span>
                                </div>
                            </div>

                            <!-- Actions Column -->
                            <div class="flex sm:flex-row lg:flex-col items-stretch lg:items-end justify-between sm:justify-end gap-2 border-t lg:border-t-0 pt-4 lg:pt-0 shrink-0">
                                <a href="{{ route('coach.questions.show', $q) }}" 
                                   class="px-4 py-2 rounded-xl text-xs font-bold transition-all shadow-xs flex items-center justify-center gap-1.5 {{ $hasCoachAnswer ? 'bg-gray-100 text-gray-800 hover:bg-gray-200' : 'bg-brand-green text-white hover:bg-brand-green-light' }}">
                                    @if ($hasCoachAnswer)
                                        <span>View Discussion</span>
                                    @else
                                        <span>Provide Coach Advice ✍️</span>
                                    @endif
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>

                                <div class="flex items-center gap-1.5">
                                    <!-- Toggle Resolve Button -->
                                    <form method="POST" action="{{ route('coach.questions.resolve', $q) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                title="{{ $q->is_resolved ? 'Mark unresolved' : 'Mark as resolved' }}"
                                                class="px-2.5 py-1.5 rounded-lg text-xs font-semibold border transition-colors flex items-center gap-1 {{ $q->is_resolved ? 'border-gray-200 text-gray-600 hover:bg-gray-50' : 'border-emerald-200 text-emerald-700 bg-emerald-50 hover:bg-emerald-100' }}">
                                            {{ $q->is_resolved ? 'Re-open' : 'Resolve ✓' }}
                                        </button>
                                    </form>

                                    <!-- Delete Question Button -->
                                    <form method="POST" action="{{ route('coach.questions.destroy', $q) }}" onsubmit="return confirm('Delete this question thread entirely? This action cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                title="Delete Question Thread" 
                                                class="p-1.5 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $questions->links() }}
            </div>
        @endif

    </div>
</x-app-layout>


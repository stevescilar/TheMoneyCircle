<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('coach.questions.index') }}" 
                   class="p-2 rounded-xl bg-white/10 hover:bg-white/20 text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div>
                    <h2 class="font-extrabold text-2xl text-brand-green leading-tight">
                        Discussion Thread
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">Coach Q&A Desk & Community Advisory</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <!-- Resolve Toggle -->
                <form method="POST" action="{{ route('coach.questions.resolve', $question) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" 
                            class="px-4 py-2 text-xs font-bold rounded-xl border transition-all shadow-xs flex items-center gap-2 {{ $question->is_resolved ? 'bg-gray-100 text-gray-700 hover:bg-gray-200 border-gray-300' : 'bg-emerald-50 text-emerald-800 border-emerald-300 hover:bg-emerald-100' }}">
                        <span>{{ $question->is_resolved ? 'Mark Incomplete' : 'Mark as Resolved ✓' }}</span>
                    </button>
                </form>

                <!-- Delete Question -->
                <form method="POST" action="{{ route('coach.questions.destroy', $question) }}" onsubmit="return confirm('Permanently delete this question and all answers?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-2 rounded-xl text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors" title="Delete Question">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">

        <!-- Status Toast -->
        @if (session('status'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-sm font-semibold flex items-center gap-2 shadow-xs">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <!-- Question Card -->
        <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-xs border border-gray-100 space-y-5">
            <!-- Badges & Author -->
            <div class="flex flex-wrap items-center justify-between gap-3 pb-4 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-brand-green/10 text-brand-green flex items-center justify-center font-bold text-sm">
                        {{ strtoupper(substr($question->author_name ?? 'M', 0, 2)) }}
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-900">{{ $question->author_name }}</h4>
                        <p class="text-xs text-gray-400">Asked {{ $question->created_at ? $question->created_at->format('M d, Y • h:i A') : 'Recently' }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-gray-100 text-gray-700">
                        {{ ucfirst($question->category) }}
                    </span>
                    @if ($question->is_resolved)
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                            Resolved ✓
                        </span>
                    @else
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
                            Active Question
                        </span>
                    @endif
                </div>
            </div>

            <!-- Title & Body -->
            <div class="space-y-3">
                <h1 class="text-xl sm:text-2xl font-black text-gray-900 leading-snug">
                    {{ $question->title }}
                </h1>
                <div class="text-sm sm:text-base text-gray-700 leading-relaxed whitespace-pre-line">
                    {{ $question->body }}
                </div>
            </div>

            <!-- Meta info -->
            <div class="pt-2 text-xs text-gray-400 flex items-center gap-4">
                <span>{{ $question->views_count }} views</span>
                <span>•</span>
                <span>{{ $question->answers->count() }} replies</span>
            </div>
        </div>

        <!-- Coach Answer Composer Box -->
        <div class="bg-gradient-to-br from-brand-green-dark via-brand-green to-brand-green-light rounded-2xl p-6 sm:p-7 text-white shadow-lg space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-brand-gold text-brand-green-dark flex items-center justify-center font-bold text-base shadow-sm">
                        ⭐
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-white flex items-center gap-2">
                            <span>Post Verified Coach Answer</span>
                            <span class="px-2 py-0.5 rounded-md bg-brand-gold text-brand-green-dark text-[10px] font-black uppercase tracking-wider">
                                Official Advice
                            </span>
                        </h3>
                        <p class="text-xs text-white/75 mt-0.5">Your answer will be styled in gold with the Verified Coach badge on all member devices.</p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('coach.questions.answers.store', $question) }}" class="space-y-4">
                @csrf
                <div>
                    <textarea name="body" 
                              rows="5" 
                              required 
                              placeholder="Provide actionable coaching, math breakdowns, loan payoff rules, or budgeting frameworks..." 
                              class="w-full text-sm text-gray-900 rounded-xl p-4 bg-white border border-transparent focus:ring-4 focus:ring-brand-gold/30 focus:border-brand-gold transition-all resize-y shadow-inner"></textarea>
                    @error('body')
                        <p class="text-xs text-red-200 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between pt-1">
                    <div class="text-xs text-white/70">
                        Posting as: <strong class="text-brand-gold">{{ Auth::user()->name ?? 'Coach Steve' }}</strong>
                    </div>
                    <button type="submit" 
                            class="px-5 py-2.5 bg-brand-gold text-brand-green-dark font-extrabold text-xs rounded-xl hover:bg-yellow-400 transition-all shadow-md flex items-center gap-2 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        <span>Publish Verified Answer</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Answers Section -->
        <div class="space-y-4">
            <h3 class="text-base font-extrabold text-gray-900 flex items-center gap-2">
                <span>Community Replies</span>
                <span class="px-2 py-0.5 rounded-full bg-gray-100 text-gray-600 text-xs font-bold">
                    {{ $question->answers->count() }}
                </span>
            </h3>

            @if ($question->answers->isEmpty())
                <div class="bg-white rounded-2xl p-8 text-center border border-gray-100 shadow-xs space-y-2">
                    <p class="text-xs text-gray-500 font-medium">No replies yet for this inquiry. Be the first to provide expert guidance above!</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($question->answers as $ans)
                        @if ($ans->is_coach_verified)
                            <!-- Coach Verified Answer Card -->
                            <div class="bg-amber-50/50 rounded-2xl p-6 border-2 border-brand-gold shadow-sm space-y-4">
                                <div class="flex items-center justify-between pb-3 border-b border-amber-200/60">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-brand-green text-white border-2 border-brand-gold flex items-center justify-center font-bold text-sm shadow-xs">
                                            {{ strtoupper(substr($ans->author_name ?? 'C', 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <h4 class="text-sm font-extrabold text-gray-900">{{ $ans->author_name }}</h4>
                                                <span class="px-2 py-0.5 rounded-full bg-brand-gold text-brand-green-dark text-[10px] font-black tracking-wider uppercase flex items-center gap-1 shadow-2xs">
                                                    <span>⭐</span>
                                                    <span>VERIFIED COACH</span>
                                                </span>
                                            </div>
                                            <p class="text-xs text-gray-500 mt-0.5">Answered {{ $ans->created_at ? $ans->created_at->diffForHumans() : 'Recently' }}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-3">
                                        <span class="text-xs font-bold text-amber-800 bg-amber-100 px-2.5 py-1 rounded-lg">
                                            👍 {{ $ans->upvotes_count }} {{ Str::plural('upvote', $ans->upvotes_count) }}
                                        </span>
                                        <form method="POST" action="{{ route('coach.answers.destroy', $ans) }}" onsubmit="return confirm('Delete this coach answer?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors" title="Delete Answer">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <div class="text-sm text-gray-800 leading-relaxed whitespace-pre-line font-medium">
                                    {{ $ans->body }}
                                </div>
                            </div>
                        @else
                            <!-- Member Reply Card -->
                            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-xs space-y-3">
                                <div class="flex items-center justify-between pb-2 border-b border-gray-50">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-gray-100 text-gray-700 flex items-center justify-center font-bold text-xs">
                                            {{ strtoupper(substr($ans->author_name ?? 'M', 0, 2)) }}
                                        </div>
                                        <div>
                                            <h4 class="text-xs font-bold text-gray-900">{{ $ans->author_name }}</h4>
                                            <p class="text-[10px] text-gray-400">{{ $ans->created_at ? $ans->created_at->diffForHumans() : 'Recently' }}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <span class="text-xs text-gray-500 font-medium">
                                            👍 {{ $ans->upvotes_count }}
                                        </span>
                                        <form method="POST" action="{{ route('coach.answers.destroy', $ans) }}" onsubmit="return confirm('Moderate and remove this member reply?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1 rounded-md text-gray-300 hover:text-red-500 hover:bg-red-50 transition-colors" title="Delete Reply">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <div class="text-xs text-gray-700 leading-relaxed whitespace-pre-line">
                                    {{ $ans->body }}
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</x-app-layout>


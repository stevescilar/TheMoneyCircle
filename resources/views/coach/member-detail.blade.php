<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('coach.dashboard') }}" 
                   class="p-2 rounded-xl bg-white border border-gray-200 text-gray-600 hover:text-brand-green hover:border-brand-green transition-all shadow-sm group" 
                   title="Back to Dashboard">
                    <svg class="w-5 h-5 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div>
                    <div class="flex items-center gap-2.5">
                        <h2 class="font-extrabold text-2xl text-gray-900 leading-tight">
                            {{ $member->name }}
                        </h2>
                        <span class="px-2.5 py-0.5 text-xs font-bold rounded-full bg-emerald-100 text-emerald-800">
                            Active Coachee
                        </span>
                    </div>
                    <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-gray-500 mt-1">
                        <span>{{ $member->email }}</span>
                        @if($member->phone)
                            <span>&bull;</span>
                            <span>{{ $member->phone }}</span>
                        @endif
                        <span>&bull;</span>
                        <span>Member since {{ $member->created_at ? $member->created_at->format('M Y') : '2026' }}</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions (WhatsApp & Outreach) -->
            <div class="flex items-center gap-2">
                @if($member->phone)
                    @php
                        $cleanPhone = preg_replace('/[^0-9]/', '', $member->phone);
                        if (str_starts_with($cleanPhone, '0')) {
                            $cleanPhone = '254' . substr($cleanPhone, 1);
                        }
                        $waText = urlencode("Hi {$member->name}, Coach Steve here from The Money Circle. I was just reviewing your financial plan and wanted to check in...");
                    @endphp
                    <a href="https://wa.me/{{ $cleanPhone }}?text={{ $waText }}" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-emerald-600 text-white text-xs font-bold hover:bg-emerald-700 transition-all shadow-sm hover:scale-105">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/>
                        </svg>
                        <span>WhatsApp Message</span>
                    </a>
                @endif
                <a href="mailto:{{ $member->email }}" 
                   class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span>Email</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">

        <!-- Status Toast Banner -->
        @if (session('status'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center gap-3 shadow-sm animate-fade-in">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <!-- Executive Financial Vital Signs -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            
            <!-- Net Worth -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <span class="text-xs font-bold uppercase tracking-wider text-gray-400">Estimated Net Worth</span>
                <div class="text-2xl font-extrabold mt-1 {{ $vitals['estimated_net_worth'] >= 0 ? 'text-brand-green' : 'text-red-600' }}">
                    Ksh {{ number_format($vitals['estimated_net_worth'], 0) }}
                </div>
                <p class="text-[11px] text-gray-400 mt-0.5">Assets (Ksh {{ number_format($vitals['total_assets'], 0) }}) - Debts</p>
            </div>

            <!-- Net Cashflow -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <span class="text-xs font-bold uppercase tracking-wider text-gray-400">Monthly Net Cashflow</span>
                <div class="text-2xl font-extrabold mt-1 {{ $vitals['net_cashflow'] >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                    {{ $vitals['net_cashflow'] >= 0 ? '+' : '' }}Ksh {{ number_format($vitals['net_cashflow'], 0) }}
                </div>
                <p class="text-[11px] text-gray-400 mt-0.5">
                    {{ $vitals['net_cashflow'] >= 0 ? 'Cashflow surplus' : 'Running a cash deficit' }}
                </p>
            </div>

            <!-- Total Debt Load -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <span class="text-xs font-bold uppercase tracking-wider text-red-600">Total Outstanding Debt</span>
                <div class="text-2xl font-extrabold text-red-600 mt-1">
                    Ksh {{ number_format($totalDebt, 0) }}
                </div>
                <p class="text-[11px] text-gray-400 mt-0.5">{{ count($debts) }} active loan(s) recorded</p>
            </div>

            <!-- Emergency Fund Runway -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <span class="text-xs font-bold uppercase tracking-wider text-brand-gold-dark">Emergency Cash Runway</span>
                <div class="text-2xl font-extrabold text-gray-900 mt-1">
                    {{ $vitals['emergency_runway_months'] }} <span class="text-sm font-semibold text-gray-500">months</span>
                </div>
                <p class="text-[11px] text-gray-400 mt-0.5">
                    Ksh {{ number_format($emergencyFund?->current_balance ?? 0, 0) }} in liquid reserve
                </p>
            </div>

        </div>

        <!-- 2-Column Responsive Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <!-- LEFT COLUMN: Cash Flow & Day-to-Day Operations (7 Cols) -->
            <div class="lg:col-span-7 space-y-6">

                <!-- Budget Categories & Granular Coach Nudges -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 space-y-4">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                        <div>
                            <h3 class="font-extrabold text-lg text-gray-900">Budget Categories</h3>
                            <p class="text-xs text-gray-500">Track spending and add coaching guidance per category</p>
                        </div>
                        <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-brand-green/10 text-brand-green">
                            {{ count($categories) }} Categories
                        </span>
                    </div>

                    <div class="space-y-4">
                        @forelse ($categories as $row)
                            <div class="p-4 rounded-xl border border-gray-100 bg-gray-50/50 hover:bg-white hover:border-gray-200 transition-all space-y-3">
                                
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-gray-900">{{ $row['category']->name }}</span>
                                        @if ($row['is_overspent'])
                                            <span class="px-2 py-0.5 text-[10px] font-extrabold rounded-full bg-red-100 text-red-700">
                                                Overspent
                                            </span>
                                        @elseif ($row['percent'] >= 80)
                                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-amber-100 text-amber-800">
                                                Near Limit
                                            </span>
                                        @else
                                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-emerald-100 text-emerald-800">
                                                On Track
                                            </span>
                                        @endif
                                    </div>

                                    <div class="text-right">
                                        <span class="font-bold text-sm text-gray-900">
                                            Ksh {{ number_format($row['spent'], 0) }}
                                        </span>
                                        <span class="text-xs text-gray-400">
                                            / Ksh {{ number_format($row['category']->planned_amount, 0) }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Progress bar -->
                                <div>
                                    <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                        @php
                                            $barWidth = min($row['percent'], 100);
                                            $barColor = $row['is_overspent'] ? 'bg-red-500' : ($row['percent'] >= 80 ? 'bg-brand-gold' : 'bg-brand-green');
                                        @endphp
                                        <div class="{{ $barColor }} h-2 rounded-full" style="width: {{ $barWidth }}%"></div>
                                    </div>
                                    <div class="flex justify-between items-center text-[11px] text-gray-400 mt-1">
                                        <span class="font-bold {{ $row['is_overspent'] ? 'text-red-600' : 'text-gray-600' }}">
                                            {{ $row['percent'] }}% spent
                                        </span>
                                        <span>
                                            {{ $row['remaining'] >= 0 ? 'Remaining: Ksh ' . number_format($row['remaining'], 0) : 'Over budget by Ksh ' . number_format(abs($row['remaining']), 0) }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Existing Coach Note Callout (if present) -->
                                @if($row['category']->coach_notes)
                                    <div class="p-2.5 rounded-lg bg-amber-50/80 border border-amber-200 text-xs text-amber-900 flex items-start gap-2">
                                        <span class="text-brand-gold-dark font-extrabold shrink-0 mt-0.5">💬 Coach Advice:</span>
                                        <span class="italic">{{ $row['category']->coach_notes }}</span>
                                    </div>
                                @endif

                                <!-- Inline Coach Nudge / Comment Form -->
                                <form method="POST" action="{{ route('members.categories.notes', [$member, $row['category']]) }}" class="pt-2 border-t border-gray-100 flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <input type="text" 
                                           name="coach_notes" 
                                           value="{{ $row['category']->coach_notes }}" 
                                           placeholder="Coach advice on {{ strtolower($row['category']->name) }} (e.g. Let's cap dining out at 10k)..." 
                                           class="flex-1 px-3 py-1.5 text-xs bg-white border border-gray-200 rounded-lg focus:ring-1 focus:ring-brand-green focus:border-brand-green">
                                    <button type="submit" class="px-3 py-1.5 bg-brand-green text-white text-xs font-bold rounded-lg hover:bg-brand-green-light transition-colors shrink-0 shadow-sm">
                                        Save Note
                                    </button>
                                </form>

                            </div>
                        @empty
                            <p class="text-gray-400 text-sm italic py-4">No budget categories recorded yet.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Monthly Reflections & Coach Feedback History -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 space-y-4">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                        <div>
                            <h3 class="font-extrabold text-lg text-gray-900">Monthly Reflections</h3>
                            <p class="text-xs text-gray-500">Member self-assessments and coach guidance history</p>
                        </div>
                        <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-brand-gold/20 text-brand-gold-dark">
                            {{ count($reflections) }} Submitted
                        </span>
                    </div>

                    <div class="space-y-4">
                        @forelse ($reflections as $reflection)
                            <div class="p-4 rounded-xl border border-gray-100 bg-gray-50/60 space-y-3">
                                
                                <div class="flex items-center justify-between">
                                    <span class="font-extrabold text-sm text-gray-900">
                                        {{ $reflection->period_month->format('F Y') }}
                                    </span>
                                    <span class="px-2.5 py-0.5 text-xs font-bold rounded-full bg-brand-green text-white shadow-sm">
                                        Score: {{ $reflection->financial_score }}/10
                                    </span>
                                </div>

                                @if ($reflection->wins)
                                    <div class="text-xs text-gray-700 bg-emerald-50/80 p-2.5 rounded-lg border border-emerald-100">
                                        <strong class="text-emerald-900">🎉 Member Wins:</strong> {{ $reflection->wins }}
                                    </div>
                                @endif

                                @if ($reflection->challenges)
                                    <div class="text-xs text-gray-700 bg-red-50/80 p-2.5 rounded-lg border border-red-100">
                                        <strong class="text-red-900">⚠️ Challenges:</strong> {{ $reflection->challenges }}
                                    </div>
                                @endif

                                <!-- Coach Feedback Form -->
                                <form method="POST" action="{{ route('members.reflections.notes', [$member, $reflection]) }}" class="space-y-2 pt-2 border-t border-gray-200/60">
                                    @csrf
                                    @method('PATCH')
                                    <label class="block text-xs font-bold text-gray-700">Coach Feedback & Action Items</label>
                                    <textarea name="coach_notes" 
                                              rows="2" 
                                              placeholder="Provide coaching advice, action steps, or congratulations..." 
                                              class="w-full text-xs bg-white border border-gray-200 rounded-lg p-2.5 focus:ring-1 focus:ring-brand-green focus:border-brand-green">{{ $reflection->coach_notes }}</textarea>
                                    <div class="flex justify-end">
                                        <button type="submit" class="px-3.5 py-1.5 bg-brand-green text-white text-xs font-bold rounded-lg hover:bg-brand-green-light transition-colors shadow-sm">
                                            Save Reflection Notes
                                        </button>
                                    </div>
                                </form>

                            </div>
                        @empty
                            <p class="text-gray-400 text-sm italic py-4">No monthly reflections submitted yet.</p>
                        @endforelse
                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN: Balance Sheet & Wealth Acceleration (5 Cols) -->
            <div class="lg:col-span-5 space-y-6">

                <!-- Debts Payoff Center & Specific Loan Comments -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 space-y-4">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                        <div>
                            <h3 class="font-extrabold text-lg text-red-600">Debts & Loans</h3>
                            <p class="text-xs text-gray-500">Target payoff tracking & specific loan advice</p>
                        </div>
                        <span class="text-xs font-extrabold text-red-600 bg-red-50 px-2.5 py-1 rounded-full border border-red-100">
                            Total: Ksh {{ number_format($totalDebt, 0) }}
                        </span>
                    </div>

                    <div class="space-y-4">
                        @forelse ($debts as $row)
                            <div class="p-4 rounded-xl border border-red-100 bg-red-50/20 space-y-3">
                                
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="font-bold text-gray-900">{{ $row['debt']->lender }}</h4>
                                        <p class="text-xs text-red-600 font-bold mt-0.5">
                                            Balance: Ksh {{ number_format($row['debt']->current_balance, 2) }}
                                        </p>
                                    </div>
                                    @if ($row['months_remaining'] !== null)
                                        <span class="text-xs font-semibold px-2 py-1 rounded-md bg-white border border-gray-200 text-gray-700">
                                            {{ $row['months_remaining'] }} mo. left
                                        </span>
                                    @endif
                                </div>

                                @if ($row['months_remaining'] !== null)
                                    <div class="text-[11px] text-gray-500 bg-white p-2 rounded-md border border-gray-100">
                                        Target: {{ $row['debt']->target_payoff_date ? $row['debt']->target_payoff_date->format('M Y') : 'N/A' }} &bull;
                                        Needs <strong>Ksh {{ number_format($row['required_monthly_payment'], 0) }}/mo</strong> to payoff on schedule.
                                    </div>
                                @endif

                                <!-- Existing Coach Debt Note -->
                                @if($row['debt']->coach_notes)
                                    <div class="p-2.5 rounded-lg bg-amber-50 border border-amber-200 text-xs text-amber-900 space-y-1">
                                        <span class="font-bold text-brand-gold-dark block">💬 Coach Action Prompt:</span>
                                        <p class="italic">{{ $row['debt']->coach_notes }}</p>
                                    </div>
                                @endif

                                <!-- Debt Coach Nudge Form -->
                                <form method="POST" action="{{ route('members.debts.notes', [$member, $row['debt']]) }}" class="space-y-2 pt-2 border-t border-red-100/80">
                                    @csrf
                                    @method('PATCH')
                                    <label class="block text-[11px] font-bold text-gray-700">
                                        Coach Prompt for {{ $row['debt']->lender }}
                                    </label>
                                    <textarea name="coach_notes" 
                                              rows="2" 
                                              placeholder="e.g. When are we clearing this loan? Let's allocate any bonus or extra cash directly here..." 
                                              class="w-full text-xs bg-white border border-gray-200 rounded-lg p-2 focus:ring-1 focus:ring-red-500 focus:border-red-500">{{ $row['debt']->coach_notes }}</textarea>
                                    <div class="flex justify-between items-center">
                                        <span class="text-[10px] text-gray-400">Syncs to member's app</span>
                                        <button type="submit" class="px-3 py-1 bg-red-600 text-white text-xs font-bold rounded-lg hover:bg-red-700 transition-colors shadow-sm">
                                            Save Loan Advice
                                        </button>
                                    </div>
                                </form>

                            </div>
                        @empty
                            <div class="p-4 text-center rounded-xl bg-emerald-50 text-emerald-800 text-xs font-semibold">
                                &check; Debt Free! No active loans recorded for this member.
                            </div>
                        @endforelse

                        @if(isset($clearedDebts) && $clearedDebts->isNotEmpty())
                            <div class="p-4 rounded-xl border border-emerald-200 bg-emerald-50/50 space-y-2 mt-4">
                                <div class="flex items-center gap-2 text-emerald-800 font-bold text-xs">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>Cleared & Fully Paid Off ({{ $clearedDebts->count() }})</span>
                                </div>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($clearedDebts as $cleared)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-white border border-emerald-200 text-xs font-semibold text-emerald-700 shadow-sm">
                                            <span>&check; {{ $cleared->lender }}</span>
                                            <span class="text-[10px] text-emerald-500 font-bold">Cleared</span>
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Emergency Fund Card -->
                @if ($emergencyFund)
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 space-y-3">
                        <div class="flex items-center justify-between">
                            <h3 class="font-extrabold text-base text-gray-900">Emergency Reserve</h3>
                            <span class="text-xs font-bold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800">
                                {{ $emergencyFund->percentFunded() }}% Funded
                            </span>
                        </div>

                        <div class="flex justify-between items-center text-xs">
                            <span class="font-bold text-gray-900">
                                Ksh {{ number_format($emergencyFund->current_balance, 0) }}
                            </span>
                            <span class="text-gray-400">
                                Target: Ksh {{ number_format($emergencyFund->target_amount, 0) }}
                            </span>
                        </div>

                        <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                            <div class="bg-brand-gold h-2 rounded-full" style="width: {{ min($emergencyFund->percentFunded(), 100) }}%"></div>
                        </div>

                        @if($emergencyFund->coach_notes)
                            <div class="p-2 rounded-lg bg-amber-50 text-xs text-amber-900 italic">
                                <strong>Coach Note:</strong> {{ $emergencyFund->coach_notes }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('members.emergency-fund.notes', $member) }}" class="pt-2 flex items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <input type="text" 
                                   name="coach_notes" 
                                   value="{{ $emergencyFund->coach_notes }}" 
                                   placeholder="Coach advice on emergency fund..." 
                                   class="flex-1 px-3 py-1.5 text-xs bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-1 focus:ring-brand-green">
                            <button type="submit" class="px-3 py-1.5 bg-brand-green text-white text-xs font-bold rounded-lg shrink-0">
                                Save
                            </button>
                        </form>
                    </div>
                @endif

                <!-- Savings Goals -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 space-y-4">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                        <h3 class="font-extrabold text-base text-gray-900">Savings Goals</h3>
                        <span class="text-xs font-bold px-2.5 py-0.5 rounded-full bg-brand-gold/15 text-brand-gold-dark">
                            {{ count($savingsGoals) }} Goals
                        </span>
                    </div>

                    <div class="space-y-3">
                        @forelse ($savingsGoals as $goal)
                            <div class="p-3 rounded-xl border border-gray-100 bg-gray-50/50 space-y-2">
                                <div class="flex justify-between items-center">
                                    <span class="font-bold text-xs text-gray-900">{{ $goal->goal_name }}</span>
                                    <span class="text-xs font-bold text-brand-gold-dark">{{ $goal->percentComplete() }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-brand-gold h-1.5 rounded-full" style="width: {{ min($goal->percentComplete(), 100) }}%"></div>
                                </div>
                                <div class="flex justify-between text-[11px] text-gray-400">
                                    <span>Ksh {{ number_format($goal->saved_amount, 0) }}</span>
                                    <span>Target: Ksh {{ number_format($goal->target_amount, 0) }}</span>
                                </div>

                                @if($goal->coach_notes)
                                    <div class="p-2 rounded-lg bg-amber-50 text-[11px] text-amber-900 italic">
                                        <strong>Coach Note:</strong> {{ $goal->coach_notes }}
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('members.savings-goals.notes', [$member, $goal]) }}" class="pt-1 flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <input type="text" 
                                           name="coach_notes" 
                                           value="{{ $goal->coach_notes }}" 
                                           placeholder="Coach note for {{ strtolower($goal->goal_name) }}..." 
                                           class="flex-1 px-2.5 py-1 text-xs bg-white border border-gray-200 rounded-lg">
                                    <button type="submit" class="px-2.5 py-1 bg-brand-green text-white text-xs font-bold rounded-lg shrink-0">
                                        Save
                                    </button>
                                </form>
                            </div>
                        @empty
                            <p class="text-gray-400 text-xs italic py-2">No active savings goals recorded.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Investment Portfolio -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 space-y-4">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                        <div>
                            <h3 class="font-extrabold text-base text-gray-900">Investments</h3>
                            <p class="text-xs text-gray-400">Asset allocation</p>
                        </div>
                        <span class="text-xs font-extrabold text-brand-green bg-emerald-50 px-2.5 py-1 rounded-full">
                            Total: Ksh {{ number_format($totalInvestments, 0) }}
                        </span>
                    </div>

                    <div class="space-y-2">
                        @forelse ($investmentsByType as $type => $balance)
                            <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-0 text-xs">
                                <span class="font-bold text-gray-700 uppercase tracking-wide">{{ $type }}</span>
                                <span class="font-extrabold text-gray-900">Ksh {{ number_format($balance, 2) }}</span>
                            </div>
                        @empty
                            <p class="text-gray-400 text-xs italic py-2">No investments recorded yet.</p>
                        @endforelse
                    </div>
                </div>

            </div>

        </div>

    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <h2 class="font-extrabold text-2xl text-brand-green leading-tight">
                Coach Command Center
            </h2>
            <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full bg-brand-green/10 text-brand-green">
                Live Overview
            </span>
        </div>
    </x-slot>

    <div class="space-y-8">

        <!-- Executive KPI Stat Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            
            <!-- Card 1: Total Coached Members -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-24 h-24 bg-brand-green/5 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-500">Total Members</span>
                    <div class="w-10 h-10 rounded-xl bg-brand-green/10 text-brand-green flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-extrabold text-gray-900 tracking-tight">
                    {{ $kpis['total_members'] ?? count($members) }}
                </div>
                <p class="text-xs text-gray-500 mt-1">Active coachees in your circle</p>
            </div>

            <!-- Card 2: Members At Risk -->
            <a href="{{ route('coach.dashboard', ['filter' => 'at_risk']) }}" 
               class="bg-white rounded-2xl p-5 shadow-sm border border-red-100 hover:border-red-300 hover:shadow-md transition-all relative overflow-hidden group block">
                <div class="absolute top-0 right-0 w-24 h-24 bg-red-500/5 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-red-600">Members At Risk</span>
                    <div class="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-extrabold text-red-600 tracking-tight">
                    {{ $kpis['at_risk_count'] ?? 0 }}
                </div>
                <p class="text-xs text-red-500 mt-1 flex items-center gap-1 font-medium">
                    <span>Over budget / intervention needed</span>
                    <span class="text-xs">&rarr;</span>
                </p>
            </a>

            <!-- Card 3: Tracked Circle Wealth -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-24 h-24 bg-brand-gold/10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-500">Tracked Circle Wealth</span>
                    <div class="w-10 h-10 rounded-xl bg-brand-gold/20 text-brand-gold-dark flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                </div>
                <div class="text-2xl font-extrabold text-gray-900 tracking-tight">
                    Ksh {{ number_format($kpis['total_wealth_tracked'] ?? 0, 0) }}
                </div>
                <p class="text-xs text-gray-500 mt-1">Savings goals + Investment assets</p>
            </div>

            <!-- Card 4: Pending Reflection Reviews -->
            <a href="{{ route('coach.dashboard', ['filter' => 'needs_notes']) }}" 
               class="bg-white rounded-2xl p-5 shadow-sm border border-amber-100 hover:border-amber-300 hover:shadow-md transition-all relative overflow-hidden group block">
                <div class="absolute top-0 right-0 w-24 h-24 bg-amber-500/5 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-amber-700">Reflections Awaiting Notes</span>
                    <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-extrabold text-amber-700 tracking-tight">
                    {{ $kpis['pending_reflections_count'] ?? 0 }}
                </div>
                <p class="text-xs text-amber-600 mt-1 flex items-center gap-1 font-medium">
                    <span>Awaiting your coach advice</span>
                    <span class="text-xs">&rarr;</span>
                </p>
            </a>

        </div>

        <!-- Controls: Search & Filters -->
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex flex-col md:flex-row items-center justify-between gap-4">
            
            <!-- Search Bar -->
            <form method="GET" action="{{ route('coach.dashboard') }}" class="w-full md:w-96 flex items-center">
                @if(request('filter'))
                    <input type="hidden" name="filter" value="{{ request('filter') }}">
                @endif
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" 
                           name="search" 
                           value="{{ $search ?? '' }}" 
                           placeholder="Search member name, email or phone..." 
                           class="w-full pl-10 pr-20 py-2 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-brand-green/20 focus:border-brand-green transition-colors">
                    @if(!empty($search))
                        <a href="{{ route('coach.dashboard', ['filter' => $filter]) }}" class="absolute right-12 top-2.5 text-xs text-gray-400 hover:text-gray-700">Clear</a>
                    @endif
                    <button type="submit" class="absolute right-1.5 top-1 px-3 py-1 bg-brand-green text-white text-xs font-semibold rounded-lg hover:bg-brand-green-light transition-colors">
                        Search
                    </button>
                </div>
            </form>

            <!-- Filter Badges -->
            <div class="flex items-center gap-2 overflow-x-auto w-full md:w-auto pb-1 md:pb-0">
                <a href="{{ route('coach.dashboard', array_merge(request()->query(), ['filter' => 'all'])) }}"
                   class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all whitespace-nowrap {{ $filter === 'all' ? 'bg-brand-green text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    All Members ({{ $kpis['total_members'] ?? count($members) }})
                </a>
                
                <a href="{{ route('coach.dashboard', array_merge(request()->query(), ['filter' => 'at_risk'])) }}"
                   class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all whitespace-nowrap flex items-center gap-1.5 {{ $filter === 'at_risk' ? 'bg-red-600 text-white shadow-sm' : 'bg-red-50 text-red-700 hover:bg-red-100' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $filter === 'at_risk' ? 'bg-white' : 'bg-red-600' }}"></span>
                    At Risk ({{ $kpis['at_risk_count'] ?? 0 }})
                </a>

                <a href="{{ route('coach.dashboard', array_merge(request()->query(), ['filter' => 'needs_notes'])) }}"
                   class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all whitespace-nowrap flex items-center gap-1.5 {{ $filter === 'needs_notes' ? 'bg-amber-600 text-white shadow-sm' : 'bg-amber-50 text-amber-800 hover:bg-amber-100' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $filter === 'needs_notes' ? 'bg-white' : 'bg-amber-600' }}"></span>
                    Needs Notes ({{ $kpis['pending_reflections_count'] ?? 0 }})
                </a>
            </div>

        </div>

        <!-- Member Health Table Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="font-extrabold text-base text-gray-900">Coached Members</h3>
                    <p class="text-xs text-gray-500">Monitor budget adherence, monthly reflections, and financial status</p>
                </div>
                <span class="text-xs font-semibold text-gray-400">
                    Showing {{ count($members) }} member(s)
                </span>
            </div>

            <!-- Desktop Table -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/70 border-b border-gray-100 text-[11px] font-bold uppercase tracking-wider text-gray-400">
                            <th class="py-3.5 px-6">Member Details</th>
                            <th class="py-3.5 px-6">Budget Consumption</th>
                            <th class="py-3.5 px-6">Financial Health</th>
                            <th class="py-3.5 px-6">Latest Reflection</th>
                            <th class="py-3.5 px-6 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse ($members as $row)
                            <tr class="hover:bg-emerald-50/30 transition-colors">
                                
                                <!-- Member Details -->
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-brand-green/10 text-brand-green font-bold flex items-center justify-center text-sm border border-brand-green/20 shrink-0">
                                            {{ strtoupper(substr($row['member']->name ?? 'M', 0, 2)) }}
                                        </div>
                                        <div>
                                            <a href="{{ route('members.show', $row['member']) }}" class="font-bold text-gray-900 hover:text-brand-green transition-colors block">
                                                {{ $row['member']->name }}
                                            </a>
                                            <div class="flex items-center gap-2 text-xs text-gray-500 mt-0.5">
                                                <span>{{ $row['member']->email }}</span>
                                                @if($row['member']->phone)
                                                    <span>&bull;</span>
                                                    <span>{{ $row['member']->phone }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Budget Consumption -->
                                <td class="py-4 px-6 min-w-[220px]">
                                    <div class="flex justify-between items-center text-xs mb-1">
                                        <span class="font-semibold text-gray-700">
                                            Ksh {{ number_format($row['total_spent'], 0) }}
                                        </span>
                                        <span class="text-gray-400">
                                            of Ksh {{ number_format($row['total_budgeted'], 0) }}
                                        </span>
                                    </div>
                                    
                                    <!-- Progress Bar -->
                                    <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                                        @php
                                            $pct = min($row['percent_spent'], 100);
                                            $barColor = 'bg-brand-green';
                                            if ($row['is_overspent']) {
                                                $barColor = 'bg-red-500';
                                            } elseif ($row['percent_spent'] >= 80) {
                                                $barColor = 'bg-brand-gold';
                                            }
                                        @endphp
                                        <div class="{{ $barColor }} h-2 rounded-full transition-all duration-500" style="width: {{ $pct }}%"></div>
                                    </div>

                                    <div class="flex items-center justify-between mt-1 text-[11px]">
                                        <span class="font-bold {{ $row['is_overspent'] ? 'text-red-600' : ($row['percent_spent'] >= 80 ? 'text-brand-gold-dark' : 'text-emerald-700') }}">
                                            {{ $row['percent_spent'] }}% spent
                                        </span>
                                        @if($row['total_budgeted'] > 0)
                                            <span class="text-gray-400">
                                                {{ $row['total_budgeted'] > $row['total_spent'] ? 'Ksh ' . number_format($row['total_budgeted'] - $row['total_spent'], 0) . ' left' : 'Over by Ksh ' . number_format($row['total_spent'] - $row['total_budgeted'], 0) }}
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Health Status -->
                                <td class="py-4 px-6">
                                    @if ($row['is_overspent'])
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-600 animate-pulse"></span>
                                            At Risk (Overspent)
                                        </span>
                                    @elseif ($row['total_budgeted'] == 0)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                            No Budget Set
                                        </span>
                                    @elseif ($row['percent_spent'] >= 80)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            Near Budget Limit
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            On Track
                                        </span>
                                    @endif
                                </td>

                                <!-- Latest Reflection -->
                                <td class="py-4 px-6">
                                    @if ($row['latest_reflection'])
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="text-xs font-bold text-gray-900">
                                                    {{ $row['latest_reflection']->period_month->format('M Y') }}
                                                </span>
                                                <span class="px-2 py-0.5 text-[11px] font-bold rounded-md bg-brand-green/10 text-brand-green">
                                                    Score: {{ $row['latest_reflection']->financial_score }}/10
                                                </span>
                                            </div>
                                            @if(empty($row['latest_reflection']->coach_notes))
                                                <span class="inline-block mt-1 text-[11px] font-semibold text-amber-700 bg-amber-50 px-2 py-0.5 rounded border border-amber-200">
                                                    Needs Notes
                                                </span>
                                            @else
                                                <span class="inline-block mt-1 text-[11px] font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded">
                                                    Feedback Given &check;
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-400 italic">No reflection yet</span>
                                    @endif
                                </td>

                                <!-- Action Button -->
                                <td class="py-4 px-6 text-right">
                                    <a href="{{ route('members.show', $row['member']) }}" 
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-brand-green text-white text-xs font-bold hover:bg-brand-green-light transition-all shadow-sm shadow-brand-green/10 hover:scale-105">
                                        <span>360&deg; Profile</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-gray-500">
                                    <div class="max-w-sm mx-auto space-y-3">
                                        <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mx-auto text-gray-400">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                        </div>
                                        <p class="font-bold text-gray-700">No members match your criteria</p>
                                        <p class="text-xs text-gray-400">Try changing your search keywords or switching filter tabs.</p>
                                        <a href="{{ route('coach.dashboard') }}" class="inline-block px-4 py-2 rounded-xl bg-brand-green text-white text-xs font-bold">
                                            Clear All Filters
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile View: Cards -->
            <div class="md:hidden divide-y divide-gray-100">
                @forelse ($members as $row)
                    <div class="p-4 space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-brand-green/10 text-brand-green font-bold flex items-center justify-center text-sm border border-brand-green/20">
                                    {{ strtoupper(substr($row['member']->name ?? 'M', 0, 2)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900">{{ $row['member']->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $row['member']->email }}</p>
                                </div>
                            </div>
                            @if ($row['is_overspent'])
                                <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-red-100 text-red-700">At Risk</span>
                            @else
                                <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-emerald-100 text-emerald-800">On Track</span>
                            @endif
                        </div>

                        <!-- Budget bar -->
                        <div class="space-y-1">
                            <div class="flex justify-between text-xs">
                                <span class="text-gray-500">Budget Spent</span>
                                <span class="font-bold text-gray-900">{{ $row['percent_spent'] }}%</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                                @php
                                    $pct = min($row['percent_spent'], 100);
                                    $barColor = $row['is_overspent'] ? 'bg-red-500' : ($row['percent_spent'] >= 80 ? 'bg-brand-gold' : 'bg-brand-green');
                                @endphp
                                <div class="{{ $barColor }} h-2 rounded-full" style="width: {{ $pct }}%"></div>
                            </div>
                            <div class="flex justify-between text-[11px] text-gray-400">
                                <span>Ksh {{ number_format($row['total_spent'], 0) }}</span>
                                <span>Planned: Ksh {{ number_format($row['total_budgeted'], 0) }}</span>
                            </div>
                        </div>

                        <div class="pt-2 flex items-center justify-between border-t border-gray-100">
                            @if ($row['latest_reflection'])
                                <span class="text-xs text-gray-600 font-medium">
                                    Score: <strong class="text-brand-green">{{ $row['latest_reflection']->financial_score }}/10</strong> ({{ $row['latest_reflection']->period_month->format('M Y') }})
                                </span>
                            @else
                                <span class="text-xs text-gray-400 italic">No reflection</span>
                            @endif

                            <a href="{{ route('members.show', $row['member']) }}" class="px-3 py-1 bg-brand-green text-white text-xs font-bold rounded-lg">
                                View Profile &rarr;
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-500 text-sm">
                        No members found.
                    </div>
                @endforelse
            </div>

        </div>

    </div>
</x-app-layout>
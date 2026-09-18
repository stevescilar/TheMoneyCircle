<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-brand-green leading-tight">
            {{ $member->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="font-semibold text-brand-green mb-4">Budget Categories</h3>
                @forelse ($categories as $row)
                    <div class="flex justify-between py-2 border-b last:border-0">
                        <span>{{ $row['category']->name }}</span>
                        <span class="text-sm text-gray-600">
                            Ksh {{ number_format($row['spent'], 2) }} / Ksh {{ number_format($row['category']->planned_amount, 2) }}
                            ({{ $row['percent'] }}%)
                        </span>
                    </div>
                @empty
                    <p class="text-gray-500">No categories yet.</p>
                @endforelse
            </div>

            <div class="bg-white shadow-sm rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-semibold text-brand-green">Debts</h3>
                    <span class="text-sm text-gray-600">Total: Ksh {{ number_format($totalDebt, 2) }}</span>
                </div>
                @forelse ($debts as $row)
                    <div class="py-2 border-b last:border-0">
                        <div class="flex justify-between">
                            <span>{{ $row['debt']->lender }}</span>
                            <span class="text-sm text-gray-600">Ksh {{ number_format($row['debt']->current_balance, 2) }}</span>
                        </div>
                        @if ($row['months_remaining'] !== null)
                            <p class="text-xs text-gray-500 mt-1">
                                {{ $row['months_remaining'] }} month(s) to target payoff —
                                needs Ksh {{ number_format($row['required_monthly_payment'], 2) }}/month
                            </p>
                        @else
                            <p class="text-xs text-gray-400 mt-1">No target payoff date set</p>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-500">No debts recorded.</p>
                @endforelse
            </div>

            @if ($emergencyFund)
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h3 class="font-semibold text-brand-green mb-4">Emergency Fund</h3>
                    <p class="text-sm text-gray-600">
                        Ksh {{ number_format($emergencyFund->current_balance, 2) }} of Ksh {{ number_format($emergencyFund->target_amount, 2) }}
                        ({{ $emergencyFund->percentFunded() }}%)
                    </p>
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="font-semibold text-brand-green mb-4">Savings Goals</h3>
                @forelse ($savingsGoals as $goal)
                    <div class="flex justify-between py-2 border-b last:border-0">
                        <span>{{ $goal->goal_name }}</span>
                        <span class="text-sm text-gray-600">
                            Ksh {{ number_format($goal->saved_amount, 2) }} / Ksh {{ number_format($goal->target_amount, 2) }}
                            ({{ $goal->percentComplete() }}%)
                        </span>
                    </div>
                @empty
                    <p class="text-gray-500">No savings goals yet.</p>
                @endforelse
            </div>

            <div class="bg-white shadow-sm rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-semibold text-brand-green">Investment Portfolio</h3>
                    <span class="text-sm text-gray-600">Total: Ksh {{ number_format($totalInvestments, 2) }}</span>
                </div>
                @forelse ($investmentsByType as $type => $balance)
                    <div class="flex justify-between py-2 border-b last:border-0">
                        <span>{{ strtoupper($type) }}</span>
                        <span class="text-sm text-gray-600">Ksh {{ number_format($balance, 2) }}</span>
                    </div>
                @empty
                    <p class="text-gray-500">No investments recorded.</p>
                @endforelse
            </div>

            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="font-semibold text-brand-green mb-4">Monthly Reflections</h3>

                @if (session('status'))
                    <p class="text-sm text-green-600 mb-4">{{ session('status') }}</p>
                @endif

                @forelse ($reflections as $reflection)
                    <div class="py-4 border-b last:border-0">
                        <div class="flex justify-between items-center">
                            <span class="font-medium">{{ $reflection->period_month->format('F Y') }}</span>
                            <span class="text-sm text-gray-600">Score: {{ $reflection->financial_score }}/10</span>
                        </div>

                        @if ($reflection->wins)
                            <p class="text-sm text-gray-600 mt-1"><strong>Wins:</strong> {{ $reflection->wins }}</p>
                        @endif
                        @if ($reflection->challenges)
                            <p class="text-sm text-gray-600 mt-1"><strong>Challenges:</strong> {{ $reflection->challenges }}</p>
                        @endif

                        <form method="POST" action="{{ route('members.reflections.notes', [$member, $reflection]) }}" class="mt-3">
                            @csrf
                            @method('PATCH')
                            <label class="block text-xs text-gray-500 mb-1">Coach Notes</label>
                            <textarea name="coach_notes" rows="2" class="w-full text-sm border-gray-300 rounded">{{ $reflection->coach_notes }}</textarea>
                            <button type="submit" class="mt-2 px-3 py-1 bg-brand-green text-white text-sm rounded">Save Notes</button>
                        </form>
                    </div>
                @empty
                    <p class="text-gray-500">No reflections submitted yet.</p>
                @endforelse
            </div>

            

        </div>
    </div>
</x-app-layout>
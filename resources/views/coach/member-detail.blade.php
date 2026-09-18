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
                <h3 class="font-semibold text-brand-green mb-4">Debts</h3>
                @forelse ($debts as $debt)
                    <div class="flex justify-between py-2 border-b last:border-0">
                        <span>{{ $debt->lender }}</span>
                        <span class="text-sm text-gray-600">Ksh {{ number_format($debt->current_balance, 2) }}</span>
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
                <h3 class="font-semibold text-brand-green mb-4">Investments</h3>
                @forelse ($investments as $investment)
                    <div class="flex justify-between py-2 border-b last:border-0">
                        <span>{{ strtoupper($investment->type) }} {{ $investment->label ? "— {$investment->label}" : '' }}</span>
                        <span class="text-sm text-gray-600">Ksh {{ number_format($investment->balance, 2) }}</span>
                    </div>
                @empty
                    <p class="text-gray-500">No investments recorded.</p>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
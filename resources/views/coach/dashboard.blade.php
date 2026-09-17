<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-brand-green leading-tight">
            Coach Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg divide-y divide-gray-200">

                @forelse ($members as $row)
                    <div class="p-6 flex items-center justify-between">
                        <div>
                            <p class="font-semibold text-lg">{{ $row['member']->name }}</p>
                            <p class="text-sm text-gray-500">
                                Ksh {{ number_format($row['total_spent'], 2) }} of Ksh {{ number_format($row['total_budgeted'], 2) }}
                            </p>
                        </div>

                        <div class="flex items-center gap-4">
                            <span class="text-sm font-medium {{ $row['is_overspent'] ? 'text-red-600' : 'text-brand-gold' }}">
                                {{ $row['percent_spent'] }}%
                            </span>

                            @if ($row['is_overspent'])
                                <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-700">Overspent</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-gray-500">No members yet.</div>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>
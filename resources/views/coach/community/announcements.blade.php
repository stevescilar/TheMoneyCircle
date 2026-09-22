<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <h2 class="font-extrabold text-2xl text-brand-green leading-tight">
                    Community Announcements
                </h2>
                <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full bg-brand-green/10 text-brand-green">
                    App Broadcast Hub
                </span>
            </div>
            <div>
                <button type="button"
                        onclick="window.dispatchEvent(new CustomEvent('open-create-announcement'))"
                        @click="window.dispatchEvent(new CustomEvent('open-create-announcement'))" 
                        class="px-4 py-2 bg-brand-green text-white text-xs font-bold rounded-xl hover:bg-brand-green-light transition-all shadow-md flex items-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>New Announcement</span>
                </button>
            </div>
        </div>
    </x-slot>

    <div x-data="{ showCreateModal: false }" @open-create-announcement.window="showCreateModal = true" class="space-y-6">

        <!-- Status Toast -->
        @if (session('status'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-sm font-semibold flex items-center gap-2 shadow-xs">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <!-- Executive Stat Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <!-- Stat 1: Total Broadcasts -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-500">Total Broadcasts</span>
                    <div class="text-2xl font-extrabold text-gray-900 mt-1">{{ $stats['total'] }}</div>
                    <p class="text-xs text-gray-400 mt-0.5">Live on member devices</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-brand-green/10 text-brand-green flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                    </svg>
                </div>
            </div>

            <!-- Stat 2: Pinned Highlights -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-brand-gold-dark">Pinned Highlights</span>
                    <div class="text-2xl font-extrabold text-gray-900 mt-1">{{ $stats['pinned'] }}</div>
                    <p class="text-xs text-gray-400 mt-0.5">Anchored at top of feed</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-brand-gold/20 text-brand-gold-dark flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M16 9V4l1 0c.55 0 1-.45 1-1s-.45-1-1-1H7c-.55 0-1 .45-1 1s.45 1 1 1l1 0v5c0 1.66-1.34 3-3 3v2h5.97v7l1 1 1-1v-7H19v-2c-1.66 0-3-1.34-3-3z"/>
                    </svg>
                </div>
            </div>

            <!-- Stat 3: With Action Routes -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-700">In-App Action Routes</span>
                    <div class="text-2xl font-extrabold text-gray-900 mt-1">{{ $stats['with_actions'] }}</div>
                    <p class="text-xs text-gray-400 mt-0.5">Direct 1-tap navigation</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Announcements Feed -->
        <div class="space-y-4">
            @forelse ($announcements as $announcement)
                <div class="bg-white rounded-2xl p-5 shadow-sm border transition-all {{ $announcement->pinned ? 'border-brand-gold/60 shadow-brand-gold/5 ring-1 ring-brand-gold/30' : 'border-gray-100' }}">
                    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                        
                        <!-- Content -->
                        <div class="space-y-2 flex-1">
                            <div class="flex flex-wrap items-center gap-2">
                                @if ($announcement->pinned)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-extrabold bg-brand-gold/20 text-brand-gold-dark border border-brand-gold/30">
                                        <span>📌</span> Pinned to Top
                                    </span>
                                @endif

                                <span class="text-xs text-gray-400">
                                    {{ $announcement->created_at->format('d M Y • h:i A') }}
                                </span>

                                @if ($announcement->coach)
                                    <span class="text-xs text-emerald-800 font-semibold bg-emerald-50 px-2 py-0.5 rounded-md">
                                        By {{ $announcement->coach->name }}
                                    </span>
                                @endif
                            </div>

                            <h3 class="font-extrabold text-base text-gray-900">
                                {{ $announcement->title }}
                            </h3>

                            <p class="text-xs text-gray-600 leading-relaxed max-w-4xl">
                                {{ $announcement->body }}
                            </p>

                            @if ($announcement->action_label)
                                <div class="pt-2 flex items-center gap-2 text-xs">
                                    <span class="text-gray-400 font-medium">Smart In-App Route:</span>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-gray-100 text-gray-800 font-bold border border-gray-200">
                                        <svg class="w-3.5 h-3.5 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                        </svg>
                                        {{ $announcement->action_label }}
                                    </span>
                                    @if ($announcement->action_url)
                                        <span class="text-gray-400 truncate max-w-xs font-mono text-[11px]">({{ $announcement->action_url }})</span>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <!-- Actions Toolbar -->
                        <div class="flex items-center gap-2 pt-2 md:pt-0 border-t md:border-t-0 border-gray-100 shrink-0">
                            <!-- Toggle Pin -->
                            <form method="POST" action="{{ route('coach.announcements.pin', $announcement) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="px-3 py-1.5 rounded-lg text-xs font-bold transition-colors flex items-center gap-1.5 {{ $announcement->pinned ? 'bg-gray-100 text-gray-700 hover:bg-gray-200' : 'bg-brand-gold/15 text-brand-gold-dark hover:bg-brand-gold/25' }}">
                                    <span>{{ $announcement->pinned ? 'Unpin' : '📌 Pin to Top' }}</span>
                                </button>
                            </form>

                            <!-- Delete -->
                            <form method="POST" action="{{ route('coach.announcements.destroy', $announcement) }}" onsubmit="return confirm('Are you sure you want to delete this announcement?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-gray-400 hover:text-red-600 rounded-lg hover:bg-red-50 transition-colors" title="Delete Announcement">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            @empty
                <div class="p-12 text-center bg-white rounded-2xl border border-dashed border-gray-200">
                    <div class="w-12 h-12 rounded-full bg-brand-green/10 text-brand-green flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                        </svg>
                    </div>
                    <h4 class="text-sm font-bold text-gray-700">No Announcements Created Yet</h4>
                    <p class="text-xs text-gray-400 max-w-sm mx-auto mt-1">Broadcast important reminders, savings sprint goals, or weekly advice directly to all mobile app members.</p>
                </div>
            @endforelse
        </div>

        <!-- CREATE MODAL -->
        <div x-show="showCreateModal" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-black/60" @click="showCreateModal = false"></div>

                <div class="inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl border border-gray-100 relative z-10">
                    <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                        <h3 class="text-base font-extrabold text-gray-900">Broadcast New Announcement</h3>
                        <button @click="showCreateModal = false" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('coach.announcements.store') }}" class="space-y-4 pt-4">
                        @csrf

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Announcement Title *</label>
                            <input type="text" name="title" required placeholder="e.g. 🚀 Q4 Savings Sprint is Live!"
                                   class="w-full text-xs border border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-brand-green focus:border-brand-green">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Message Body *</label>
                            <textarea name="body" rows="4" required placeholder="Write your coaching broadcast message for the community..."
                                      class="w-full text-xs border border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-brand-green focus:border-brand-green"></textarea>
                        </div>

                        <div class="flex items-center gap-2 pt-1">
                            <input type="checkbox" id="pinned" name="pinned" value="1"
                                   class="w-4 h-4 rounded text-brand-green focus:ring-brand-green border-gray-300">
                            <label for="pinned" class="text-xs font-bold text-gray-700 select-none">
                                Pin this announcement to the top of the community feed
                            </label>
                        </div>

                        <div class="pt-2 border-t border-gray-100 space-y-3">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Smart In-App Action Target (Optional)</label>
                                <select name="action_label" class="w-full text-xs border border-gray-200 rounded-xl p-3 bg-white focus:ring-2 focus:ring-brand-green focus:border-brand-green">
                                    <option value="">-- No Action Button (Read-only) --</option>
                                    <option value="Explore Live Sessions">Explore Live Sessions (Opens Live Coaching Tab)</option>
                                    <option value="Go to Challenges">Go to Challenges (Opens Savings Goals)</option>
                                    <option value="Open in Library">Open in Library (Opens Resource Library)</option>
                                    <option value="Complete Monthly Reflection">Complete Monthly Reflection</option>
                                    <option value="View Challenge Details">View Challenge Details</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">External Action URL (Optional)</label>
                                <input type="url" name="action_url" placeholder="https://..."
                                       class="w-full text-xs border border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-brand-green focus:border-brand-green">
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-2 pt-4 border-t border-gray-100">
                            <button type="button" @click="showCreateModal = false"
                                    class="px-4 py-2 text-xs font-bold text-gray-600 hover:text-gray-900 rounded-xl hover:bg-gray-100 transition-colors">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="px-5 py-2.5 bg-brand-green text-white text-xs font-extrabold rounded-xl hover:bg-brand-green-light transition-colors shadow-md flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                                <span>Publish Broadcast</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>


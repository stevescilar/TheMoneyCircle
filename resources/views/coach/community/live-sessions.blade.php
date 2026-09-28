<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <h2 class="font-extrabold text-2xl text-brand-green leading-tight">
                    Live Group Coaching
                </h2>
                <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full bg-brand-green/10 text-brand-green">
                    Webinars & Call Manager
                </span>
            </div>
            <div>
                <button type="button"
                        onclick="window.dispatchEvent(new CustomEvent('open-schedule-session'))"
                        @click="window.dispatchEvent(new CustomEvent('open-schedule-session'))" 
                        class="px-4 py-2 bg-brand-green text-white text-xs font-bold rounded-xl hover:bg-brand-green-light transition-all shadow-md flex items-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Schedule Session</span>
                </button>
            </div>
        </div>
    </x-slot>

    <div x-data="{ showScheduleModal: false }" @open-schedule-session.window="showScheduleModal = true" class="space-y-6">

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
            <!-- Stat 1: Upcoming Calls -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-700">Upcoming Live Sessions</span>
                    <div class="text-2xl font-extrabold text-gray-900 mt-1">{{ $stats['upcoming_count'] }}</div>
                    <p class="text-xs text-gray-400 mt-0.5">Visible to members in app</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>

            <!-- Stat 2: Next Call Countdown -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-brand-gold-dark">Next Scheduled Call</span>
                    <div class="text-base font-extrabold text-gray-900 mt-1 truncate max-w-[200px]">
                        {{ $stats['next_session'] ? $stats['next_session']->session_time->format('D, d M @ h:i A') : 'None scheduled' }}
                    </div>
                    <p class="text-xs text-gray-400 mt-0.5">
                        {{ $stats['next_session'] ? $stats['next_session']->session_time->diffForHumans() : 'Schedule one below' }}
                    </p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-brand-gold/20 text-brand-gold-dark flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>

            <!-- Stat 3: Completed Archive -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-500">Completed Sessions</span>
                    <div class="text-2xl font-extrabold text-gray-900 mt-1">{{ $stats['past_count'] }}</div>
                    <p class="text-xs text-gray-400 mt-0.5">Historical coaching calls</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-gray-100 text-gray-600 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- UPCOMING SESSIONS LIST -->
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="font-extrabold text-lg text-gray-900 flex items-center gap-2">
                    <span>Upcoming Live Masterclasses & Circles</span>
                    <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-brand-green/10 text-brand-green">
                        {{ $upcomingSessions->count() }} Active
                    </span>
                </h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse ($upcomingSessions as $session)
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-emerald-100/80 hover:border-emerald-300 transition-all flex flex-col justify-between space-y-4">
                        <div class="space-y-3">
                            <div class="flex items-start justify-between gap-3">
                                <span class="px-2.5 py-1 rounded-full text-xs font-extrabold bg-brand-gold/15 text-brand-gold-dark border border-brand-gold/30 flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-brand-gold animate-ping"></span>
                                    <span>{{ $session->session_time->diffForHumans() }}</span>
                                </span>

                                <span class="text-xs text-gray-500 font-semibold flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $session->duration_minutes }} Mins
                                </span>
                            </div>

                            <div>
                                <h4 class="font-black text-base text-gray-900 leading-snug">
                                    {{ $session->title }}
                                </h4>
                                @if ($session->description)
                                    <p class="text-xs text-gray-600 mt-1.5 leading-relaxed line-clamp-2">
                                        {{ $session->description }}
                                    </p>
                                @endif
                            </div>

                            <div class="pt-2 border-t border-gray-100 flex flex-wrap items-center justify-between text-xs text-gray-500 gap-2">
                                <div class="flex items-center gap-1.5">
                                    <div class="w-6 h-6 rounded-full bg-brand-green text-white flex items-center justify-center text-[10px] font-bold">
                                        {{ strtoupper(substr($session->speaker_name, 0, 1)) }}
                                    </div>
                                    <span class="font-bold text-gray-700">{{ $session->speaker_name }}</span>
                                </div>

                                <div class="font-bold text-emerald-900 bg-emerald-50 px-2.5 py-1 rounded-lg">
                                    📅 {{ $session->session_time->format('l, j M Y • h:i A') }}
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer Action Controls -->
                        <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                            @if ($session->meeting_url)
                                <a href="{{ $session->meeting_url }}" target="_blank"
                                   class="px-3 py-1.5 rounded-lg text-xs font-extrabold bg-brand-green text-white hover:bg-brand-green-light transition-colors shadow-xs flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                    <span>Test Meeting Link</span>
                                </a>
                            @else
                                <span class="text-xs text-gray-400 italic">No link specified</span>
                            @endif

                            <form method="POST" action="{{ route('coach.live-sessions.destroy', $session) }}" onsubmit="return confirm('Cancel and delete this live session?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-gray-400 hover:text-red-600 rounded-lg hover:bg-red-50 transition-colors" title="Cancel Session">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full p-12 text-center bg-white rounded-2xl border border-dashed border-gray-200">
                        <div class="w-12 h-12 rounded-full bg-brand-green/10 text-brand-green flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h4 class="text-sm font-bold text-gray-700">No Upcoming Sessions Scheduled</h4>
                        <p class="text-xs text-gray-400 max-w-sm mx-auto mt-1">Schedule group webinars, weekly office hours, or special financial guest speakers.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- PAST SESSIONS ARCHIVE -->
        @if ($pastSessions->isNotEmpty())
            <div class="pt-6 border-t border-gray-200/80 space-y-4">
                <h3 class="font-extrabold text-base text-gray-600">Past Coaching Calls Archive</h3>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 divide-y divide-gray-100 overflow-hidden">
                    @foreach ($pastSessions as $session)
                        <div class="p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-xs">
                            <div class="space-y-1">
                                <div class="font-extrabold text-sm text-gray-900">{{ $session->title }}</div>
                                <div class="text-gray-400">
                                    Speaker: <strong class="text-gray-600">{{ $session->speaker_name }}</strong> &bull; Duration: {{ $session->duration_minutes }} Mins
                                </div>
                            </div>
                            <div class="flex items-center gap-3 text-gray-500 font-semibold">
                                <span>{{ $session->session_time->format('d M Y • h:i A') }}</span>
                                <span class="px-2 py-0.5 rounded bg-gray-100 text-gray-600 font-bold">Completed</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- SCHEDULE MODAL -->
        <div x-show="showScheduleModal" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-black/60" @click="showScheduleModal = false"></div>

                <div class="inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl border border-gray-100 relative z-10">
                    <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                        <h3 class="text-base font-extrabold text-gray-900">Schedule Live Coaching Call</h3>
                        <button @click="showScheduleModal = false" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('coach.live-sessions.store') }}" class="space-y-4 pt-4">
                        @csrf

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Session Topic / Title *</label>
                            <input type="text" name="title" required placeholder="e.g. Mastering High-Yield MMFs & Cash Buffers"
                                   class="w-full text-xs border border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-brand-green focus:border-brand-green">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Description & Key Takeaways</label>
                            <textarea name="description" rows="3" placeholder="Explain what members will learn during this group coaching call..."
                                      class="w-full text-xs border border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-brand-green focus:border-brand-green"></textarea>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Speaker Name *</label>
                                <input type="text" name="speaker_name" required value="{{ Auth::user()->name ?? 'Coach' }}"
                                       class="w-full text-xs border border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-brand-green focus:border-brand-green">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Duration (Minutes) *</label>
                                <input type="number" name="duration_minutes" required value="60" min="15" max="300" step="15"
                                       class="w-full text-xs border border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-brand-green focus:border-brand-green">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Session Date & Time *</label>
                            <input type="datetime-local" name="session_time" required
                                   min="{{ now()->format('Y-m-d\TH:i') }}"
                                   value="{{ now()->addDays(2)->setTime(19, 0)->format('Y-m-d\TH:i') }}"
                                   class="w-full text-xs border border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-brand-green focus:border-brand-green">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Google Meet / Zoom Meeting URL</label>
                            <input type="url" name="meeting_url" placeholder="https://meet.google.com/abc-defg-hij"
                                   class="w-full text-xs border border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-brand-green focus:border-brand-green">
                        </div>

                        <div class="flex items-center justify-end gap-2 pt-4 border-t border-gray-100">
                            <button type="button" @click="showScheduleModal = false"
                                    class="px-4 py-2 text-xs font-bold text-gray-600 hover:text-gray-900 rounded-xl hover:bg-gray-100 transition-colors">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="px-5 py-2.5 bg-brand-green text-white text-xs font-extrabold rounded-xl hover:bg-brand-green-light transition-colors shadow-md flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span>Publish to Calendar</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>


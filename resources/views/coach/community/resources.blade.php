<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <h2 class="font-extrabold text-2xl text-brand-green leading-tight">
                    Resource Library
                </h2>
                <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full bg-brand-green/10 text-brand-green">
                    Curated Tools & Guides
                </span>
            </div>
            <div>
                <button type="button"
                        onclick="window.dispatchEvent(new CustomEvent('open-add-resource'))"
                        @click="window.dispatchEvent(new CustomEvent('open-add-resource'))" 
                        class="px-4 py-2 bg-brand-green text-white text-xs font-bold rounded-xl hover:bg-brand-green-light transition-all shadow-md flex items-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Add New Resource</span>
                </button>
            </div>
        </div>
    </x-slot>

    <div x-data="{ showAddModal: false }" @open-add-resource.window="showAddModal = true" class="space-y-6">

        <!-- Status Toast -->
        @if (session('status'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-sm font-semibold flex items-center gap-2 shadow-xs">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <!-- Category Filter Tabs -->
        <div class="flex items-center gap-2 overflow-x-auto pb-1 text-xs">
            <a href="{{ route('coach.resources.index') }}"
               class="px-4 py-2 rounded-xl font-bold transition-all shrink-0 {{ empty($selectedCategory) ? 'bg-brand-green text-white shadow-sm' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                All Resources ({{ $counts['all'] }})
            </a>
            <a href="{{ route('coach.resources.index', ['category' => 'books']) }}"
               class="px-4 py-2 rounded-xl font-bold transition-all shrink-0 {{ $selectedCategory === 'books' ? 'bg-brand-green text-white shadow-sm' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                📖 Books & Summaries ({{ $counts['books'] }})
            </a>
            <a href="{{ route('coach.resources.index', ['category' => 'templates']) }}"
               class="px-4 py-2 rounded-xl font-bold transition-all shrink-0 {{ $selectedCategory === 'templates' ? 'bg-brand-green text-white shadow-sm' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                📄 Budgeting Templates ({{ $counts['templates'] }})
            </a>
            <a href="{{ route('coach.resources.index', ['category' => 'guides']) }}"
               class="px-4 py-2 rounded-xl font-bold transition-all shrink-0 {{ $selectedCategory === 'guides' ? 'bg-brand-green text-white shadow-sm' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                💡 Financial Guides ({{ $counts['guides'] }})
            </a>
        </div>

        <!-- Resources Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse ($resources as $resource)
                @php
                    $isBook = $resource->category === 'books';
                    $isTemplate = $resource->category === 'templates';
                    $catColor = $isBook ? 'bg-purple-100 text-purple-800 border-purple-200' : ($isTemplate ? 'bg-blue-100 text-blue-800 border-blue-200' : 'bg-amber-100 text-amber-800 border-amber-200');
                    $catIcon = $isBook ? '📖 Books' : ($isTemplate ? '📄 Template' : '💡 Guide');
                @endphp

                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-all flex flex-col justify-between space-y-4">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-extrabold border {{ $catColor }}">
                                {{ $catIcon }}
                            </span>
                            <span class="text-[11px] text-gray-400">
                                {{ $resource->created_at ? $resource->created_at->format('d M Y') : 'Active' }}
                            </span>
                        </div>

                        <div>
                            <h4 class="font-black text-sm text-gray-900 leading-snug">
                                {{ $resource->title }}
                            </h4>
                            @if ($resource->description)
                                <p class="text-xs text-gray-600 mt-1.5 leading-relaxed line-clamp-3">
                                    {{ $resource->description }}
                                </p>
                            @endif
                        </div>

                        @if ($resource->author_or_source)
                            <div class="pt-2 border-t border-gray-100 text-[11px] text-gray-500">
                                Source: <strong class="text-gray-700">{{ $resource->author_or_source }}</strong>
                            </div>
                        @endif
                    </div>

                    <!-- Footer -->
                    <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                        <a href="{{ $resource->file_url }}" target="_blank"
                           class="px-3 py-1.5 rounded-lg text-xs font-bold bg-brand-green/10 text-brand-green hover:bg-brand-green hover:text-white transition-colors flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            <span>Download / View</span>
                        </a>

                        <form method="POST" action="{{ route('coach.resources.destroy', $resource) }}" onsubmit="return confirm('Remove this resource from library?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-gray-400 hover:text-red-600 rounded-lg hover:bg-red-50 transition-colors" title="Delete Resource">
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <h4 class="text-sm font-bold text-gray-700">No Resources Found</h4>
                    <p class="text-xs text-gray-400 max-w-sm mx-auto mt-1">Upload budgeting spreadsheets, financial calculators, or e-book guides for the community.</p>
                </div>
            @endforelse
        </div>

        <!-- ADD RESOURCE MODAL -->
        <div x-show="showAddModal" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-black/60" @click="showAddModal = false"></div>

                <div class="inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl border border-gray-100 relative z-10">
                    <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                        <h3 class="text-base font-extrabold text-gray-900">Add Community Resource</h3>
                        <button @click="showAddModal = false" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('coach.resources.store') }}" class="space-y-4 pt-4">
                        @csrf

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Resource Title *</label>
                            <input type="text" name="title" required placeholder="e.g. Zero-Based Monthly Budget Planner"
                                   class="w-full text-xs border border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-brand-green focus:border-brand-green">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Category *</label>
                                <select name="category" required class="w-full text-xs border border-gray-200 rounded-xl p-3 bg-white focus:ring-2 focus:ring-brand-green focus:border-brand-green">
                                    <option value="templates">📄 Budgeting Template</option>
                                    <option value="guides">💡 Financial Guide</option>
                                    <option value="books">📖 Book / Summary</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Author / Source</label>
                                <input type="text" name="author_or_source" placeholder="e.g. The Money Circle Team"
                                       class="w-full text-xs border border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-brand-green focus:border-brand-green">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Description</label>
                            <textarea name="description" rows="3" placeholder="Explain what this template or guide helps members achieve..."
                                      class="w-full text-xs border border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-brand-green focus:border-brand-green"></textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">File or Download URL *</label>
                            <input type="url" name="file_url" required placeholder="https://microsilsystem.co.ke/resources/my-guide.pdf"
                                   class="w-full text-xs border border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-brand-green focus:border-brand-green">
                            <span class="text-[10px] text-gray-400 mt-1 block">Direct link to PDF, XLSX spreadsheet, Google Sheets, or document</span>
                        </div>

                        <div class="flex items-center justify-end gap-2 pt-4 border-t border-gray-100">
                            <button type="button" @click="showAddModal = false"
                                    class="px-4 py-2 text-xs font-bold text-gray-600 hover:text-gray-900 rounded-xl hover:bg-gray-100 transition-colors">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="px-5 py-2.5 bg-brand-green text-white text-xs font-extrabold rounded-xl hover:bg-brand-green-light transition-colors shadow-md flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                <span>Add to Library</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>


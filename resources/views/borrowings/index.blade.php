<x-app-layout>
    @section('header', 'Borrowing Records')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- 1. NOTIFICATIONS --}}
        <div class="fixed top-20 sm:top-24 right-4 sm:right-5 z-[1100] flex flex-col gap-3 w-[calc(100%-2rem)] sm:w-full max-w-sm pointer-events-none">
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
                     class="pointer-events-auto bg-green-500 text-white px-4 sm:px-6 py-3 sm:py-4 rounded-xl shadow-2xl flex items-center gap-3 sm:gap-4 transition-all transform duration-500">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-xs sm:text-sm font-bold">{{ session('success') }}</p>
                    <button @click="show = false" class="ml-auto text-white/80 hover:text-white">&times;</button>
                </div>
            @endif
            @if(session('error'))
                <div x-data="{ show: true }" x-show="show" 
                     class="pointer-events-auto bg-red-500 text-white px-4 sm:px-6 py-3 sm:py-4 rounded-xl shadow-2xl flex items-center gap-3 sm:gap-4">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-xs sm:text-sm font-bold">{{ session('error') }}</p>
                    <button @click="show = false" class="ml-auto text-white/80 hover:text-white">&times;</button>
                </div>
            @endif
        </div>

        {{-- 2. PAGE HEADER --}}
        <div class="mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2 font-serif">Returns & Borrows</h1>
            <p class="text-sm text-white">Track equipment history and manage returns.</p>
        </div>

        {{-- 3. FILTERS (Admin Only) --}}
        @if(Auth::user()->role === 'admin')
            <div class="mb-6 bg-white p-4 rounded-2xl border border-gray-200 shadow-sm">
                <form action="{{ route('records.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-grow relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search ID, Borrower, Equipment..." 
                            class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm">
                    </div>

                    <div class="w-full md:w-48">
                        <select name="status" onchange="this.form.submit()" class="w-full py-2.5 px-4 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition bg-white text-sm">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>In Use</option>
                            <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Returned</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-xl font-bold hover:bg-blue-700 transition shadow-md text-sm w-full md:w-auto">
                            Filter
                        </button>
                        @if(request()->has('search') || request()->has('status'))
                            <a href="{{ route('records.index') }}" class="bg-gray-100 text-gray-700 px-5 py-2.5 rounded-xl font-bold hover:bg-gray-200 transition text-center text-sm flex items-center justify-center w-full md:w-auto">
                                Clear
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        @endif

        {{-- 4. DESKTOP TABLE --}}
        <div class="hidden md:block bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-xs uppercase tracking-wider text-gray-500 font-bold">
                            <th class="px-6 py-4">Trans ID</th>
                            @if(Auth::user()->role === 'admin')
                                <th class="px-6 py-4">Borrower</th>
                            @endif
                            <th class="px-6 py-4">Equipment</th>
                            <th class="px-6 py-4 text-center">Qty</th>
                            <th class="px-6 py-4">Timeline</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($borrowings as $record)
                        <tr class="hover:bg-gray-50 transition-colors">
                            {{-- ID --}}
                            <td class="px-6 py-4 font-mono font-bold text-gray-500">#{{ $record->transaction_id }}</td>

                            {{-- Borrower --}}
                            @if(Auth::user()->role === 'admin')
                                <td class="px-6 py-4">
                                    @if($record->user)
                                        <div class="font-bold text-gray-900">{{ $record->user->name }}</div>
                                        <div class="text-[10px] text-blue-600 font-bold uppercase">{{ $record->user->role }}</div>
                                    @elseif($record->attendance)
                                        <div class="font-bold text-gray-900">{{ $record->attendance->name }}</div>
                                        <div class="text-[10px] text-gray-500 font-bold uppercase">Walk-in</div>
                                    @else
                                        <span class="text-gray-400 italic">Unknown</span>
                                    @endif
                                </td>
                            @endif

                            {{-- Equipment --}}
                            <td class="px-6 py-4 font-bold text-gray-800">{{ $record->equipment->name ?? 'N/A' }}</td>

                            {{-- Qty --}}
                            <td class="px-6 py-4 text-center">
                                <span class="bg-gray-100 text-gray-700 font-bold py-1 px-3 rounded-lg">{{ $record->quantity }}</span>
                            </td>

                            {{-- TIMELINE (UPDATED LOGIC) --}}
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1">
                                    {{-- ONLY SHOW TIME IF NOT PENDING --}}
                                    @if($record->status === 'pending')
                                        <div class="flex items-center gap-2 text-xs text-yellow-600 font-medium italic">
                                            <span class="w-1.5 h-1.5 rounded-full bg-yellow-400 animate-pulse"></span>
                                            <span>Waiting for approval...</span>
                                        </div>
                                    @else
                                        <div class="flex items-center gap-2 text-xs text-gray-500">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span>
                                            <span>Out: {{ $record->borrowed_at ? date('M d, h:i A', strtotime($record->borrowed_at)) : '-' }}</span>
                                        </div>
                                        @if($record->returned_at)
                                            <div class="flex items-center gap-2 text-xs text-green-700 font-bold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                                <span>In: &nbsp;&nbsp;{{ date('M d, h:i A', strtotime($record->returned_at)) }}</span>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-4">
                                @if($record->status === 'active')
                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-bold">In Use</span>
                                @elseif($record->status === 'pending')
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs font-bold animate-pulse">Pending</span>
                                @else
                                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-bold">Returned</span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4 text-center">
                                @include('borrowings.partials.actions', ['record' => $record])
                            </td>
                        </tr>
                        @empty
                            <tr><td colspan="7" class="px-6 py-12 text-center text-gray-400">No records found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- 5. MOBILE CARDS (Visible only on Mobile) --}}
        <div class="md:hidden space-y-4">
            @forelse($borrowings as $record)
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-200">
                    {{-- Header: ID & Status --}}
                    <div class="flex justify-between items-start mb-3">
                        <span class="font-mono text-xs font-bold text-gray-400">#{{ $record->transaction_id }}</span>
                        @if($record->status === 'active')
                            <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-[10px] font-bold">In Use</span>
                        @elseif($record->status === 'pending')
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-[10px] font-bold">Pending</span>
                        @else
                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-[10px] font-bold">Returned</span>
                        @endif
                    </div>

                    {{-- Main Info --}}
                    <div class="mb-4">
                        <h3 class="text-lg font-bold text-gray-900">{{ $record->equipment->name ?? 'N/A' }}</h3>
                        <div class="text-sm text-gray-500 flex items-center gap-2 mt-1">
                            <span class="bg-gray-100 px-2 py-0.5 rounded text-xs font-bold">Qty: {{ $record->quantity }}</span>
                            @if(Auth::user()->role === 'admin')
                                <span>&bull;</span>
                                <span class="font-medium text-blue-600">
                                    {{ $record->user->name ?? ($record->attendance->name ?? 'Unknown') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Timeline Section (UPDATED LOGIC) --}}
                    <div class="bg-gray-50 rounded-xl p-3 mb-4 space-y-2">
                        
                        @if($record->status === 'pending')
                            <div class="flex items-center gap-2 text-xs text-yellow-600 font-medium italic justify-center">
                                <span class="w-1.5 h-1.5 rounded-full bg-yellow-400 animate-pulse"></span>
                                <span>Waiting for approval...</span>
                            </div>
                        @else
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-gray-500 font-medium">Borrowed</span>
                                <span class="text-gray-900 font-bold">{{ $record->borrowed_at ? date('M d, h:i a', strtotime($record->borrowed_at)) : '-' }}</span>
                            </div>
                            @if($record->returned_at)
                                <div class="w-full h-px bg-gray-200"></div>
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-green-600 font-medium">Returned</span>
                                    <span class="text-green-700 font-bold">{{ date('M d, h:i a', strtotime($record->returned_at)) }}</span>
                                </div>
                            @endif
                        @endif

                    </div>

                    {{-- Actions --}}
                    <div class="flex justify-end pt-2 border-t border-gray-100">
                        @include('borrowings.partials.actions', ['record' => $record])
                    </div>
                </div>
            @empty
                <div class="text-center py-10 text-gray-400">No records found.</div>
            @endforelse
        </div>

        {{-- 6. PAGINATION --}}
        <div class="mt-8">
            {{ $borrowings->links('vendor.pagination.scilab') }}
        </div>

    </div>
</x-app-layout>
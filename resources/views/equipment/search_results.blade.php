<x-app-layout>
    @section('header', 'Search Results')

    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 py-6">
        
        <div class="mb-6">
            <h2 class="text-lg sm:text-xl text-white font-semibold">
                Showing results for: <span class="text-gray-300 font-bold">"{{ $query }}"</span>
            </h2>
            <p class="text-xs sm:text-sm text-white mt-1">Found {{ $equipment->count() }} items</p>
        </div>

        @if($equipment->isEmpty())
            <div class="flex flex-col items-center justify-center py-20 text-center">
                <svg class="w-12 h-12 sm:w-16 sm:h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <h3 class="text-base sm:text-lg font-medium text-gray-500">No items match your search.</h3>
                <a href="{{ route('dashboard') }}" class="mt-4 text-sm sm:text-base text-blue-600 hover:underline">Go back to Dashboard</a>
            </div>
        @else
            {{-- CHANGED: grid-cols-2 for mobile, reduced gap to gap-3 --}}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6">
                @foreach($equipment as $item)
                    <a href="{{ route('equipment.show', $item->id) }}" class="group block bg-white rounded-xl shadow-sm hover:shadow-xl transition border border-gray-100 overflow-hidden relative">
                        
                        {{-- Lab Badge (Scaled down for mobile) --}}
                        <div class="absolute top-2 left-2 z-10 max-w-[65%]">
                            <span class="bg-gray-800 text-white text-[9px] sm:text-[10px] font-bold px-1.5 py-0.5 sm:px-2 sm:py-1 rounded-full uppercase tracking-wider opacity-70 truncate block">
                                {{ $item->laboratory->name }}
                            </span>
                        </div>

                        {{-- Status Badge --}}
                        <div class="absolute top-2 right-2 z-10">
                            @if($item->available > 0)
                                <span class="bg-green-100 text-green-700 text-[9px] sm:text-xs font-bold px-1.5 py-0.5 sm:px-2 sm:py-1 rounded-full shadow-sm">
                                    AVAILABLE
                                </span>
                            @else
                                <span class="bg-red-100 text-red-700 text-[9px] sm:text-xs font-bold px-1.5 py-0.5 sm:px-2 sm:py-1 rounded-full shadow-sm">
                                    OUT OF STOCK
                                </span>
                            @endif
                        </div>

                        {{-- Image (Reduced height for mobile) --}}
                        <div class="h-32 sm:h-48 bg-gray-50 flex items-center justify-center p-3 sm:p-4 relative overflow-hidden">
                            @if($item->image_path)
                                <img src="{{ asset('storage/' . $item->image_path) }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-110">
                            @else
                                <svg class="w-8 h-8 sm:w-12 sm:h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                            @endif
                        </div>

                        {{-- Details (Tighter padding/text) --}}
                        <div class="p-3 sm:p-4">
                            <h4 class="text-sm sm:text-lg font-bold text-gray-800 group-hover:text-blue-600 truncate leading-tight">
                                {{ $item->name }}
                            </h4>
                            
                            <div class="flex justify-between items-center mt-2 border-t border-gray-100 pt-2">
                                <span class="text-[10px] sm:text-xs text-gray-500 truncate max-w-[50%]">
                                    {{ $item->size ?? 'Standard' }}
                                </span>
                                <span class="text-xs sm:text-sm font-bold {{ $item->available > 0 ? 'text-blue-600' : 'text-red-500' }}">
                                    {{ $item->available }} Left
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
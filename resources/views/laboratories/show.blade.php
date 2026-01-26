<x-app-layout>
    @section('header', $lab->name)

    <style>
        nav[role="navigation"] .relative.inline-flex.items-center {
            background-color: white !important;
            color: #374151 !important;
            border-color: #e5e7eb !important;
        }
        nav[role="navigation"] .relative.inline-flex.items-center:hover {
            background-color: #f3f4f6 !important;
        }
        nav[role="navigation"] span[aria-current="page"] > span {
            background-color: #2563eb !important;
            color: white !important;
            border-color: #2563eb !important;
        }
    </style>

    {{-- NOTIFICATIONS --}}
    <div class="fixed top-20 sm:top-24 right-3 sm:right-5 z-[1100] flex flex-col gap-2 sm:gap-3 w-[calc(100%-1.5rem)] sm:w-full max-w-sm pointer-events-none">
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
                 class="pointer-events-auto bg-gradient-to-r from-green-500 to-green-600 text-white px-4 sm:px-6 py-3 sm:py-4 rounded-xl sm:rounded-2xl shadow-2xl flex items-center gap-3 sm:gap-4 border border-green-400">
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-white/20 rounded-lg sm:rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="font-bold text-xs sm:text-sm uppercase">Success</h4>
                    <p class="text-xs sm:text-sm truncate">{{ session('success') }}</p>
                </div>
                <button @click="show = false" class="text-white/80 hover:text-white text-xl sm:text-2xl shrink-0">&times;</button>
            </div>
        @endif
        @if($errors->any())
            <div x-data="{ show: true }" x-show="show" 
                 class="pointer-events-auto bg-gradient-to-r from-red-500 to-red-600 text-white px-4 sm:px-6 py-3 sm:py-4 rounded-xl sm:rounded-2xl shadow-2xl flex items-start gap-3 sm:gap-4 border border-red-400">
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-white/20 rounded-lg sm:rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="font-bold text-xs sm:text-sm uppercase">Error</h4>
                    <p class="text-xs sm:text-sm">Check the form for errors</p>
                </div>
                <button @click="show = false" class="text-white/80 hover:text-white text-xl sm:text-2xl shrink-0">&times;</button>
            </div>
        @endif
    </div>

    <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8 py-6 sm:py-8 lg:py-12">
        
        {{-- HEADER --}}
        <div class="mb-6 sm:mb-8 lg:mb-10">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 sm:gap-6">
                <div class="w-full sm:w-auto">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-5 mb-2 sm:mb-3">
                        <div class="flex-1">
                            <h1 class="text-2xl sm:text-3xl font-bold text-white">{{ $lab->name }}</h1>
                            <p class="text-xs sm:text-sm text-white">Equipment Inventory</p>
                        </div>
                        <div class="inline-flex items-center gap-2 px-3 sm:px-4 py-1.5 sm:py-2 bg-blue-50 rounded-lg sm:rounded-xl border border-blue-200 w-fit">
                            <span class="text-xs sm:text-sm font-bold text-blue-700">{{ $lab->equipment->count() }} Items</span>
                        </div>
                    </div>
                </div>
                
                @if(Auth::user()->role == 'admin')
                    <button onclick="toggleModal('addModal', true)" 
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-3 sm:py-3.5 px-5 sm:px-6 rounded-xl shadow-lg hover:shadow-xl transition-all transform text-sm sm:text-base">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add Equipment
                    </button>
                @endif
            </div>
        </div>

        {{-- GRID --}}
        <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-4 lg:gap-5 xl:gap-6"
            x-data="{ show: false} "
            x-init="setTimeout(() => show = true, 50)"
            x-show="show"
            x-cloak
            x-transition:enter="transition ease-out duration-900"
            x-transition:enter-start="opacity-0 translate-y-5"
            x-transition:enter-end="opacity-100 translate-y-0"
        >
            @forelse($equipment as $item)
                <a href="{{ route('equipment.show', $item->id) }}" 
                   class="group block bg-white rounded-xl sm:rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border-2 border-gray-100 overflow-hidden">

                    <div class="relative h-48 sm:h-56 lg:h-64 w-full bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center overflow-hidden">
                        @if($item->image_path)
                            <div class="absolute inset-0 bg-white"></div>
                            <img src="{{ asset('storage/' . $item->image_path) }}" 
                                 alt="{{ $item->name }}"
                                 loading="lazy"
                                 class="relative h-full w-full object-contain transform scale-150 transition-transform duration-700">
                        @else
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl sm:rounded-2xl bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center mb-2 sm:mb-3">
                                    <svg class="w-8 h-8 sm:w-10 sm:h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <span class="text-xs text-gray-400">No Image</span>
                            </div>
                        @endif
                                            
                        <div class="absolute top-3 sm:top-4 right-3 sm:right-4 z-20">
                            @if($item->available > 5)
                                <span class="flex items-center gap-1 sm:gap-1.5 px-2 sm:px-2.5 py-0.5 sm:py-1 bg-green-500 rounded-full shadow-lg text-[9px] sm:text-[10px] font-bold text-white">
                                    <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 bg-white rounded-full"></span>IN STOCK
                                </span>
                            @elseif($item->available > 0)
                                <span class="flex items-center gap-1 sm:gap-1.5 px-2 sm:px-2.5 py-0.5 sm:py-1 bg-amber-500 rounded-full shadow-lg text-[9px] sm:text-[10px] font-bold text-white animate-pulse">
                                    <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 bg-white rounded-full"></span>LOW
                                </span>
                            @else
                                <span class="flex items-center gap-1 sm:gap-1.5 px-2 sm:px-2.5 py-0.5 sm:py-1 bg-gray-400 rounded-full shadow-lg text-[9px] sm:text-[10px] font-bold text-white">
                                    <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 bg-white rounded-full"></span>OUT
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="p-4 sm:p-5 lg:p-6 bg-white border-t-2 border-gray-100">
                        <h4 class="text-base sm:text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-colors mb-1 sm:mb-2 line-clamp-1">
                            {{ $item->name }}
                        </h4>
                        <p class="text-xs sm:text-sm text-gray-600 mb-3 sm:mb-4 line-clamp-2 min-h-[2rem] sm:min-h-[2.5rem]">
                            {{ $item->description ?: 'No description available' }}
                        </p>
                        
                        <div class="flex items-center justify-between pt-3 sm:pt-4 border-t border-gray-100">
                            <div class="flex items-center gap-1.5 sm:gap-2">
                                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-gray-100 flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[9px] sm:text-[10px] text-gray-500 font-semibold">TOTAL</p>
                                    <p class="text-xs sm:text-sm font-bold text-gray-900">{{ $item->quantity }}</p>
                                </div>
                            </div>
                            
                            <div class="h-7 sm:h-8 w-px bg-gray-200"></div>
                            
                            <div class="flex items-center gap-1.5 sm:gap-2">
                                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg {{ $item->available > 0 ? 'bg-green-100' : 'bg-gray-100' }} flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 {{ $item->available > 0 ? 'text-green-600' : 'text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[9px] sm:text-[10px] text-gray-500 font-semibold">AVAILABLE</p>
                                    <p class="text-xs sm:text-sm font-bold {{ $item->available > 0 ? 'text-green-600' : 'text-gray-600' }}">{{ $item->available }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full flex flex-col items-center justify-center py-16 sm:py-20 lg:py-24">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl sm:rounded-3xl bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center mb-4 sm:mb-6">
                        <svg class="w-10 h-10 sm:w-12 sm:h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                    </div>
                    <p class="text-xl sm:text-2xl text-gray-900 font-bold mb-1 sm:mb-2">No Equipment Found</p>
                    <p class="text-sm sm:text-base text-gray-500 mb-4 sm:mb-6 text-center px-4">This laboratory doesn't have any equipment yet</p>
                </div>
            @endforelse
        </div>
        
        <div class="mt-8 sm:mt-10 lg:mt-12">
            {{ $equipment->links('vendor.pagination.scilab') }}
        </div>
    </div>

    {{-- MODAL --}}
    <div id="addModal" 
         class="fixed inset-0 bg-black/60 backdrop-blur-sm {{ $errors->any() ? 'flex' : 'hidden' }} items-center justify-center z-50 p-3 sm:p-4"
         onclick="if(event.target === this) toggleModal('addModal', false)">
        
        <div class="bg-white rounded-2xl sm:rounded-3xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-5 sm:px-6 lg:px-8 py-4 sm:py-5 lg:py-6 flex items-center justify-between">
                <div class="flex items-center gap-2 sm:gap-3">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-white/20 rounded-lg sm:rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <h2 class="text-lg sm:text-xl lg:text-2xl font-bold text-white">Add New Equipment</h2>
                </div>
                <button type="button" onclick="toggleModal('addModal', false)" 
                        class="text-white/80 hover:text-white text-2xl sm:text-3xl">&times;</button>
            </div>

            <form method="POST" action="{{ route('equipment.store') }}" enctype="multipart/form-data" 
                  class="p-5 sm:p-6 lg:p-8 overflow-y-auto max-h-[calc(90vh-80px)] sm:max-h-[calc(90vh-88px)] space-y-4 sm:space-y-5 lg:space-y-6">
                @csrf
                <input type="hidden" name="laboratory_id" value="{{ $lab->id }}">

                <div>
                    <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">Equipment Name *</label>
                    <input type="text" name="name" placeholder="e.g. Bunsen Burner" value="{{ old('name') }}"
                        class="w-full px-3 sm:px-4 py-2.5 sm:py-3 text-sm sm:text-base rounded-lg sm:rounded-xl border-2 @error('name') border-red-500 @else border-gray-200 @enderror focus:border-blue-500 focus:ring-4 focus:ring-blue-50 outline-none">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">Description</label>
                    <textarea name="description" rows="3" placeholder="Details..."
                        class="w-full px-3 sm:px-4 py-2.5 sm:py-3 text-sm sm:text-base rounded-lg sm:rounded-xl border-2 @error('description') border-red-500 @else border-gray-200 @enderror focus:border-blue-500 focus:ring-4 focus:ring-blue-50 outline-none resize-none">{{ old('description') }}</textarea>
                    @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">Size / Spec</label>
                    <input type="text" name="size" placeholder="e.g. 500ml" value="{{ old('size') }}"
                        class="w-full px-3 sm:px-4 py-2.5 sm:py-3 text-sm sm:text-base rounded-lg sm:rounded-xl border-2 @error('size') border-red-500 @else border-gray-200 @enderror focus:border-blue-500 focus:ring-4 focus:ring-blue-50 outline-none">
                    @error('size') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-5">
                    <div>
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">Total Qty *</label>
                        <input type="number" name="quantity" min="0" placeholder="0" value="{{ old('quantity') }}"
                            class="w-full px-3 sm:px-4 py-2.5 sm:py-3 text-sm sm:text-base rounded-lg sm:rounded-xl border-2 @error('quantity') border-red-500 @else border-gray-200 @enderror focus:border-green-500 focus:ring-4 focus:ring-green-50 outline-none">
                        @error('quantity') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">Available *</label>
                        <input type="number" name="available" min="0" placeholder="0" value="{{ old('available') }}"
                            class="w-full px-3 sm:px-4 py-2.5 sm:py-3 text-sm sm:text-base rounded-lg sm:rounded-xl border-2 @error('available') border-red-500 @else border-gray-200 @enderror focus:border-green-500 focus:ring-4 focus:ring-green-50 outline-none">
                        @error('available') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">Hazard</label>
                        <input type="text" name="hazard_code" placeholder="H302" value="{{ old('hazard_code') }}"
                            class="w-full px-3 sm:px-4 py-2.5 sm:py-3 text-sm sm:text-base rounded-lg sm:rounded-xl border-2 @error('hazard_code') border-red-500 @else border-gray-200 @enderror focus:border-green-500 focus:ring-4 focus:ring-green-50 outline-none">
                        @error('hazard_code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                    <!-- third change -->
                    <!-- add status (input:text) and location -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">Status *</label>
                        <input type="text" name="status" placeholder="e.g. usable, under_maintenance" value="{{ old('status') }}"
                            class="w-full px-3 sm:px-4 py-2.5 sm:py-3 text-sm sm:text-base rounded-lg sm:rounded-xl border-2 @error('status') border-red-500 @else border-gray-200 @enderror focus:border-green-500 focus:ring-4 focus:ring-green-50 outline-none">
                        @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">Location</label>
                        <input type="text" name="location" placeholder="e.g. Cabinet A" value="{{ old('location') }}"
                            class="w-full px-3 sm:px-4 py-2.5 sm:py-3 text-sm sm:text-base rounded-lg sm:rounded-xl border-2 @error('location') border-red-500 @else border-gray-200 @enderror focus:border-green-500 focus:ring-4 focus:ring-green-50 outline-none">
                        @error('location') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">Image</label>
                    <label class="flex flex-col items-center justify-center w-full h-32 sm:h-40 border-2 @error('image_path') border-red-500 @else border-gray-300 @enderror border-dashed rounded-xl sm:rounded-2xl cursor-pointer bg-gray-50 hover:bg-purple-50 transition">
                        <svg class="w-7 h-7 sm:w-8 sm:h-8 mb-1.5 sm:mb-2 text-gray-500" fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                        </svg>
                        <p class="text-xs sm:text-sm text-gray-500"><span class="font-semibold">Click to upload</span></p>
                        <span class="text-xs text-blue-500 font-bold filename-display"></span>
                        <input type="file" name="image_path" class="hidden" />
                    </label>
                    @error('image_path') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-scilab-blue to-scilab-dark-blue hover:from-scilab-dark-blue hover:to-scilab-blue text-white font-bold py-3 sm:py-3.5 text-sm sm:text-base rounded-xl shadow-lg hover:shadow-xl transition-all">
                    Add Equipment
                </button>
            </form>
        </div>
    </div>

    <script>
        function toggleModal(modalId, show) {
            const modal = document.getElementById(modalId);
            if (modal) {
                if(show) {
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                    document.body.style.overflow = 'hidden';
                } else {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    document.body.style.overflow = '';
                }
            }
        }

        document.querySelector('input[name="image_path"]').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            if (fileName) {
                const label = e.target.closest('label');
                const display = label.querySelector('.filename-display');
                if(display) display.textContent = fileName;
                label.classList.add('bg-blue-50', 'border-blue-500');
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') toggleModal('addModal', false);
        });
    </script>
    @if($errors->any())
        <script>document.body.style.overflow = 'hidden';</script>
    @endif
</x-app-layout>
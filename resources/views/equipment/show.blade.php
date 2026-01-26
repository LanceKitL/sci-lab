<x-app-layout>
    @section('header', $equipment->name)

    {{-- 1. TOAST NOTIFICATIONS (Top Right) --}}
    <div class="fixed top-24 right-5 z-[1100] flex flex-col gap-3 w-full max-w-sm pointer-events-none px-4 sm:px-0">
        
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
                 class="pointer-events-auto bg-green-500 text-white px-4 sm:px-6 py-3 sm:py-4 rounded-xl shadow-2xl flex items-center gap-3 sm:gap-4 transition-all transform duration-500">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div class="flex-1 min-w-0">
                    <h4 class="font-bold text-xs sm:text-sm uppercase tracking-wider">Success</h4>
                    <p class="text-xs sm:text-sm">{{ session('success') }}</p>
                </div>
                <button @click="show = false" class="ml-auto text-white/80 hover:text-white text-xl">&times;</button>
            </div>
        @endif

        @if($errors->any())
            <div x-data="{ show: true }" x-show="show" 
                 class="pointer-events-auto bg-red-500 text-white px-4 sm:px-6 py-3 sm:py-4 rounded-xl shadow-2xl flex items-start gap-3 sm:gap-4 transition-all transform duration-500">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <div class="flex-1 min-w-0">
                    <h4 class="font-bold text-xs sm:text-sm uppercase tracking-wider">Error</h4>
                    <ul class="list-disc list-inside text-xs sm:text-sm mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button @click="show = false" class="ml-auto text-white/80 hover:text-white text-xl leading-none">&times;</button>
            </div>
        @endif
    </div>

    {{-- 2. MAIN CONTENT --}}
    <div class="max-w-6xl mx-auto py-4 sm:py-8 px-4"
        x-data="{ show: false} "
        x-init="setTimeout(() => show = true, 50)"
        x-show="show"
        x-cloak
        x-transition:enter="transition ease-out duration-900"
        x-transition:enter-start="opacity-0 translate-y-5"
        x-transition:enter-end="opacity-100 translate-y-0"
    >
        
        {{-- Back Button --}}
        <div class="mb-4 sm:mb-6">
            <a href="{{ route('laboratories.show', $equipment->laboratory->slug) }}" class="inline-flex items-center gap-2 text-white">
                <div class="p-2 rounded-full hover:bg-gray-100 transition">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </div>
                <span class="text-xs sm:text-sm font-medium">Back to {{ $equipment->laboratory->name }}</span>
            </a>
        </div>

        {{-- Main Card --}}
        <div class="flex flex-col md:flex-row gap-6 sm:gap-12 items-start mb-8 sm:mb-16 bg-white p-4 sm:p-8 rounded-2xl shadow-sm border border-gray-100">
            
            {{-- IMAGE COLUMN --}}
            <div class="w-full md:w-1/3 flex justify-center items-center bg-gray-50 rounded-xl p-4 sm:p-8 h-64 sm:h-96 relative overflow-hidden">
                 {{-- Status Badge (Over Image) --}}
                 <div class="absolute bottom-3 left-3 sm:bottom-4 sm:left-4 z-50">
                    @if($equipment->available > 0)
                        <span class="bg-white/90 backdrop-blur text-green-700 px-2 sm:px-3 py-1 rounded-full font-bold text-xs shadow-sm flex items-center gap-1 sm:gap-2">
                            <span class="w-2 h-2 bg-green-500 rounded-full"></span> Available
                        </span>
                    @else
                        <span class="bg-white/90 backdrop-blur text-red-700 px-2 sm:px-3 py-1 rounded-full font-bold text-xs shadow-sm flex items-center gap-1 sm:gap-2">
                            <span class="w-2 h-2 bg-red-500 rounded-full"></span> Out of Stock
                        </span>
                    @endif
                </div>

                @if($equipment->image_path)
                    <div>
                        <img src="{{ asset('storage/' . $equipment->image_path) }}" 
                         alt="{{ $equipment->name }}" 
                         class="max-h-full max-w-full object-cover  drop-shadow-md scale-110  sm:scale-150 transition duration-500">
                    </div>
                @else
                     <div class="flex flex-col items-center gap-2 opacity-50">
                        <svg class="w-12 h-12 sm:w-16 sm:h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="text-gray-400 italic font-serif text-sm">No Image</span>
                     </div>
                @endif
            </div>

            {{-- DETAILS COLUMN --}}
            <div class="w-full md:w-2/3 pt-0 sm:pt-2">
                
                {{-- Headings --}}
                <div class="mb-4 sm:mb-6">
                    <h1 class="text-3xl sm:text-5xl font-bold text-black mb-2 leading-tight" >
                        {{ $equipment->name }}
                    </h1>
                    <h2 class="text-xs sm:text-sm text-gray-400 uppercase tracking-widest font-bold opacity-70">
                        {{ $equipment->laboratory->name }}
                    </h2>
                </div>

                {{-- Description --}}
                <p class="text-base sm:text-xl text-black leading-relaxed mb-6 sm:mb-8" >
                    {{ $equipment->description ?? 'No detailed description provided for this item.' }}
                </p>

                {{-- Small Specs Grid --}}
                <div class="grid grid-cols-2 gap-3 sm:gap-4 mb-6 sm:mb-8">
                    <div class="bg-blue-50 p-3 sm:p-4 rounded-xl border border-blue-100">
                        <span class="block text-xs font-bold text-black uppercase mb-1">Size / Spec</span>
                        <span class="text-base sm:text-lg font-bold text-gray-600">{{ $equipment->size ?? 'Standard' }}</span>
                    </div>
                    <div class="bg-blue-50 p-3 sm:p-4 rounded-xl border border-blue-100">
                        <span class="block text-xs font-bold text-black uppercase mb-1">Hazard Code</span>
                        <span class="text-base sm:text-lg font-bold {{ $equipment->hazard_code == 'Safe' ? 'text-green-600' : 'text-amber-600' }}">
                            {{ $equipment->hazard_code ?? 'None' }}
                        </span>
                    </div>
                </div>

                {{-- ACTION BUTTONS SECTION --}}
                <div class="flex flex-col gap-3" x-data="{ showBorrowModal: false, showDeleteModal: false }">
    
                    {{-- 1. Borrow Button --}}
                    @if($equipment->available > 0)
                        <button @click="showBorrowModal = true" class="w-full bg-scilab-blue text-white text-base sm:text-lg py-3 sm:py-4 px-4 sm:px-6 rounded-full hover:opacity-90 transition shadow-lg flex items-center justify-center gap-2 group font-sans transform hover:-translate-y-0.5">
                            <span>Borrow Item</span>
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </button>
                    @else
                        <button disabled class="w-full bg-gray-200 text-gray-400 text-base sm:text-lg py-3 sm:py-4 px-4 sm:px-6 rounded-full cursor-not-allowed font-serif italic">
                            Out of Stock
                        </button>
                    @endif

                    {{-- 2. Admin Actions (Edit/Delete) --}}
                    @if(Auth::user()->role === 'admin')
                        <div class="grid grid-cols-2 gap-3 mt-2">
                            <a href="{{ route('equipment.edit', $equipment->id) }}" 
                               class="flex items-center justify-center gap-1 sm:gap-2 py-2.5 sm:py-3 bg-gray-50 border border-gray-200 text-gray-600 font-bold rounded-full hover:bg-gray-100 transition text-sm sm:text-base">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                <span class="hidden xs:inline">Edit Item</span>
                                <span class="xs:hidden">Edit</span>
                            </a>

                            <button @click="showDeleteModal = true" 
                                    class="flex items-center justify-center gap-1 sm:gap-2 py-2.5 sm:py-3 bg-white border border-red-100 text-red-500 font-bold rounded-full hover:bg-red-50 transition text-sm sm:text-base">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Delete
                            </button>
                        </div>
                    @endif

                    {{-- MODALS --}}

                    {{-- Borrow Modal --}}
                    <div x-show="showBorrowModal" style="display: none;" 
                         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm px-4"
                         x-transition.opacity>
                        
                        <div class="bg-white rounded-2xl shadow-2xl p-6 sm:p-8 w-full max-w-sm text-center" @click.away="showBorrowModal = false">
                            <h3 class="text-xl sm:text-2xl font-bold text-gray-800 font-serif mb-2">Borrow {{ $equipment->name }}</h3>
                            <p class="text-gray-500 text-sm mb-6">How many units do you need?</p>

                            <form action="{{ route('borrow.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="equipment_id" value="{{ $equipment->id }}">
                                
                                <div class="flex items-center justify-center gap-3 sm:gap-4 mb-6 sm:mb-8">
                                    <button type="button" @click="$refs.qty.stepDown()" class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-gray-100 hover:bg-gray-200 font-bold text-xl text-gray-600 transition">-</button>
                                    
                                    <input x-ref="qty" type="number" name="quantity" value="1" min="1" max="{{ $equipment->available }}" 
                                           class="w-14 sm:w-16 text-center text-xl sm:text-2xl font-bold border-none focus:ring-0 p-0 text-scilab-blue outline-none">
                                    
                                    <button type="button" @click="$refs.qty.stepUp()" class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-gray-100 hover:bg-gray-200 font-bold text-xl text-gray-600 transition">+</button>
                                </div>

                                <div class="flex gap-3">
                                    <button type="button" @click="showBorrowModal = false" class="flex-1 py-2.5 sm:py-3 rounded-xl border border-gray-300 text-gray-600 hover:bg-gray-50 font-bold transition text-sm sm:text-base">Cancel</button>
                                    <button type="submit" class="flex-1 py-2.5 sm:py-3 rounded-xl bg-scilab-blue text-white hover:opacity-90 font-bold transition shadow-md text-sm sm:text-base">Confirm</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Delete Modal --}}
                    <div x-show="showDeleteModal" style="display: none;" 
                         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm px-4"
                         x-transition.opacity>
                   
                        <div class="bg-white rounded-2xl shadow-2xl p-6 sm:p-8 w-full max-w-sm text-center" @click.away="showDeleteModal = false">
                            <div class="w-14 h-14 sm:w-16 sm:h-16 bg-red-100 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4 animate-pulse">
                                <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                           
                            <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-2 font-serif">Delete Item?</h3>
                            <p class="text-gray-500 text-sm mb-6">Are you sure you want to delete <strong>{{ $equipment->name }}</strong>? This cannot be undone.</p>

                            <form action="{{ route('equipment.destroy', $equipment->id) }}" method="POST" class="flex gap-3">
                                @csrf
                                @method('DELETE')
                               
                                <button type="button" @click="showDeleteModal = false" class="flex-1 py-2.5 sm:py-3 rounded-xl border border-gray-300 text-gray-600 hover:bg-gray-50 font-bold transition text-sm sm:text-base">
                                    Cancel
                                </button>
                                <button type="submit" class="flex-1 py-2.5 sm:py-3 rounded-xl bg-red-600 text-white hover:bg-red-700 font-bold transition shadow-md text-sm sm:text-base">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Stock Status Table --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gray-50 px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-100">
                <h3 class="font-bold text-gray-700 text-sm sm:text-base">Stock Status</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-center">
                    <thead>
                        <tr class="text-gray-500 uppercase tracking-wider text-xs font-bold bg-white border-b">
                            <th class="py-3 sm:py-4 px-2">Total Quantity</th>
                            <th class="py-3 sm:py-4 px-2">Available Now</th>
                            <!--  -->
                            <th class="py-3 sm:py-4 px-2">{{$equipment->laboratory->name}}</th>
                            <th class="py-3 sm:py-4 px-2">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-base sm:text-lg text-blue-900" >
                        <tr>
                            <td class="py-3 sm:py-4 px-2 font-bold">{{ $equipment->quantity }}</td>
                            <td class="py-3 sm:py-4 px-2 font-bold text-green-600">{{ $equipment->available }}</td>
                            <!-- first change here -->
                            <td class="py-3 sm:py-4 px-2 text-gray-500 text-xs sm:text-base">{{ $equipment->location }}</td>
                            <td class="py-3 sm:py-4 px-2">
                                <span class="inline-block px-2 sm:px-3 py-1 rounded-full text-xs font-sans font-bold">
                                    {{ $equipment->status }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
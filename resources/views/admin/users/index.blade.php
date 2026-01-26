<x-app-layout>
    @section('header', 'Pending Approvals')

    {{-- 
        ALPINE STATE MANAGEMENT:
        - showModal: Controls if the popup is visible.
        - activeImage: Stores the URL of the clicked image.
    --}}


    <div x-data="{ showModal: false, activeImage: '' }" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Tabs --}}
        <div class="flex gap-4 mb-6">
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 border-b-2 border-scilab-blue text-white font-bold">Pending Requests</a>
            <a href="{{ route('admin.users.history') }}" class="px-4 py-2 text-white font-bold transition">Approval History</a>
        </div>

        @if($pendingUsers->isEmpty())
            <div class="bg-white rounded-2xl p-12 text-center border border-dashed border-gray-300">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <h3 class="text-lg font-bold text-gray-500">All caught up!</h3>
                <p class="text-gray-400">No pending account requests.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($pendingUsers as $user)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden flex flex-col">
                    
                    {{-- ID Image Preview (Click to Open Modal) --}}
                    <div class="h-48 bg-gray-100 relative group overflow-hidden cursor-pointer" 
                         @click="activeImage = '{{ asset('storage/'.$user->id_image_path) }}'; showModal = true">
                        
                        <img src="{{ asset('storage/'.$user->id_image_path) }}" 
                             loading="lazy"
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                             alt="ID Card">
                        
                        {{-- Overlay Icon --}}
                        <div class="absolute inset-0 bg-black/30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <div class="bg-white/20 backdrop-blur-md border border-white/50 rounded-full p-2">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 flex-1">
                        <div class="flex items-center justify-between mb-2">
                            <span class="px-2 py-1 bg-blue-100 text-blue-700 text-[10px] font-bold uppercase rounded">{{ $user->role }}</span>
                            <span class="text-xs text-gray-400">{{ $user->created_at->diffForHumans() }}</span>
                        </div>
                        
                        <h3 class="font-bold text-gray-900 text-lg">{{ $user->name }}</h3>
                        <p class="text-sm text-gray-500 mb-4">{{ $user->email }}</p>

                        <div class="bg-gray-50 rounded-lg p-3 text-xs text-gray-600 mb-4">
                            @if($user->role === 'student')
                                <strong>Section:</strong> {{ $user->section }}
                            @else
                                <strong>Dept:</strong> {{ $user->department }}
                            @endif
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="p-4 border-t border-gray-100 flex gap-3 bg-gray-50">
                        <form action="{{ route('admin.users.approve', $user->id) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg text-sm font-bold shadow-md transition-all transform hover:-translate-y-0.5">
                                Approve
                            </button>
                        </form>

                        <form action="{{ route('admin.users.reject', $user->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Are you sure you want to reject this user?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full py-2 bg-white border border-red-200 text-red-500 hover:bg-red-50 rounded-lg text-sm font-bold transition-all hover:shadow-sm">
                                Reject
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        @endif

        {{-- 
            FULL SCREEN IMAGE MODAL 
            - Fixed position covering the whole screen
            - Black background with opacity
            - Esc key closes it
        --}}
        <div x-show="showModal" 
             style="display: none;"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[999] flex items-center justify-center bg-black/95 backdrop-blur-sm p-4"
             @keydown.escape.window="showModal = false">
            
            {{-- Close Button --}}
            <button @click="showModal = false" class="absolute top-4 right-4 text-white/70 hover:text-white z-50 p-2 transition-colors">
                <svg class="w-10 h-10 drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            {{-- The Active Image --}}
            <div class="relative w-full h-full flex items-center justify-center" @click.self="showModal = false">
                <img :src="activeImage" 
                     class="max-w-full max-h-full object-contain rounded-lg shadow-2xl border border-white/10"
                     alt="Full Size ID">
            </div>
            
            {{-- Hint Text --}}
            <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 text-white/50 text-sm pointer-events-none">
                Press ESC to close
            </div>
        </div>

    </div>
</x-app-layout>
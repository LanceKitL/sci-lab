<footer class="bg-white border-t border-gray-200 mt-auto z-10 relative">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        
        {{-- Flex Container: Stacks on mobile, Row on Desktop --}}
        <div class="flex flex-col md:flex-row justify-between items-center gap-6 md:gap-0">
            
            {{-- Left: Brand & Info --}}
            <div class="flex flex-col items-center md:items-start text-center md:text-left">
                <div class="flex items-center gap-2 mb-1">
                    {{-- Small Logo --}}
                    <div class="w-6 h-6 bg-scilab-blue rounded-md flex items-center justify-center text-white text-xs font-bold">
                        S
                    </div>
                    <span class="font-bold text-lg text-gray-800 tracking-tight">Sci-Lab</span>
                </div>
                <p class="text-xs text-gray-500 font-medium">
                   Inventory Management System
                </p>
                <p class="text-[10px] text-gray-400 mt-1">
                    Made with &hearts; by kit
                </p>
            </div>

            {{-- Center: Navigation Links --}}
            <div class="flex flex-wrap justify-center gap-4 sm:gap-8 text-sm font-semibold text-gray-500">
                <a href="{{ route('dashboard') }}" class="hover:text-scilab-blue transition-colors duration-200">Dashboard</a>
                
                @if(Auth::check() && Auth::user()->role === 'admin')
                    <a href="{{ route('attendance.index') }}" class="hover:text-scilab-blue transition-colors duration-200">Attendance</a>
                @endif

                <a href="{{ route('records.index') }}" class="hover:text-scilab-blue transition-colors duration-200">Records</a>
            </div>

            {{-- Right: Copyright --}}
            <div class="text-center md:text-right">
                <p class="text-xs text-gray-400">
                    &copy; {{ date('Y') }} Sci-Lab. All Rights Reserved.
                </p>
                <p class="text-[10px] text-gray-300 mt-1 uppercase tracking-wider">
                    Secure & Efficient
                </p>
            </div>

        </div>
    </div>
</footer>
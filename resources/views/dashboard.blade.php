<x-app-layout>
    <style>
        .test{
            background: url('{{ asset("images/home_page.jpeg") }}');
            background-size: cover;
            background-position: center;    
        }

    </style>

    @section('header', 'Dashboard')

    {{-- 
        WRAPPER: 
        1. x-data initializes the 'loaded' state to false.
        2. x-init waits 100ms then sets 'loaded' to true, triggering the animations.
    --}}
    <div x-data="{ loaded: false }" 
         x-init="setTimeout(() => loaded = true, 100)"
         class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10 space-y-8 sm:space-y-12">
        
        {{-- 1. HERO SECTION (Animates First) --}}
        <div x-show="loaded"
             x-transition:enter="transition transform ease-out duration-700"
             x-transition:enter-start="opacity-0 translate-y-10 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             class="relative bg-white rounded-2xl sm:rounded-3xl p-6 sm:p-8 md:p-16 shadow-xl shadow-scilab-blue/10 border border-gray-100 overflow-hidden test">
            
            {{-- Overlay --}}
            <div class="absolute inset-0 bg-gradient-to-br from-white/95 via-white/40 to-white/90 z-[1]"></div>
            
            {{-- Decorative Blobs --}}
            <div class="absolute top-0 right-0 -mr-12 sm:-mr-24 -mt-12 sm:-mt-24 w-40 sm:w-80 h-40 sm:h-80 bg-scilab-active-bg rounded-full blur-3xl opacity-50 pointer-events-none animate-pulse"></div>
            <div class="absolute bottom-0 left-0 -ml-12 sm:-ml-24 -mb-12 sm:-mb-24 w-32 sm:w-64 h-32 sm:h-64 bg-scilab-hover-bg rounded-full blur-3xl opacity-50 pointer-events-none animate-pulse" style="animation-delay: 1s;"></div>

            {{-- Content Container --}}
            <div class="relative z-10 flex flex-col md:flex-row items-center gap-8 sm:gap-12">
                
                {{-- Text Content --}}
                <div class="w-full md:w-3/5 space-y-4 sm:space-y-6 text-center md:text-left">
                    <span class="inline-block py-1.5 px-4 rounded-full bg-scilab-blue text-white text-[10px] sm:text-xs font-bold tracking-widest uppercase mb-2 shadow-md">
                        Welcome, {{ Auth::user()->name }}
                    </span>
                    
                    <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 font-serif leading-tight drop-shadow-sm">
                        WHAT IS THIS <span class="text-scilab-blue">ABOUT?</span>
                    </h1>
                    
                    <p class="text-sm sm:text-lg md:text-xl text-gray-800 leading-relaxed max-w-2xl mx-auto md:mx-0 font-medium bg-white/60 p-4 rounded-xl backdrop-blur-sm border border-white/50">
                        <span class="font-bold text-gray-900">SCI-LAB</span> is a web-based system designed to help manage and monitor science laboratory inventories at <span class="font-bold text-scilab-dark-blue">Padre Garcia Integrated National High School</span>.
                    </p>

                    <div class="pt-2 sm:pt-4 flex justify-center md:justify-start">
                        <a href="{{ route('about') }}" class="inline-flex items-center gap-2 px-6 sm:px-8 py-3 sm:py-4 text-sm sm:text-base font-bold text-white transition-all duration-200 bg-scilab-blue border border-transparent rounded-xl hover:bg-scilab-dark-blue hover:shadow-lg hover:shadow-scilab-blue/30 transform hover:-translate-y-1 active:scale-95">
                            <span>Learn More</span>
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                    <img src="{{ asset('images/researchers/Angangan.jpeg') }}" alt="">
                </div>


                {{-- Illustration Area --}}
                <div class="w-full md:w-2/5 flex justify-center mt-4 md:mt-0">
                    <div class="relative w-48 h-48 sm:w-64 sm:h-64 md:w-80 md:h-80 flex items-center justify-center ">
                         <img src="{{ asset('images/school_logo.png') }}" alt="school_logo" class="object-fit-cover"/>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. QUICK ACCESS SECTION (Animates Second with Delay) --}}
        <div x-show="loaded"
             x-transition:enter="transition transform ease-out duration-700 delay-300"
             x-transition:enter-start="opacity-0 translate-y-10"
             x-transition:enter-end="opacity-100 translate-y-0">
             
            <div class="flex items-center gap-3 sm:gap-4 mb-4 sm:mb-8">
                <div class="h-8 w-1 bg-scilab-blue rounded-full"></div>
                <h3 class="text-lg sm:text-2xl font-bold text-gray-800 font-serif whitespace-nowrap">Quick Access</h3>
                <div class="h-px flex-grow bg-gray-200"></div>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-4 lg:gap-6">
                
                {{-- User Profile Card --}}
                <a href="{{ route('profile.edit') }}" class="group bg-white p-4 sm:p-6 rounded-2xl shadow-sm hover:shadow-lg border border-gray-100 transition-all duration-300 hover:-translate-y-1 flex flex-col items-center text-center">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-scilab-active-bg text-scilab-blue rounded-2xl flex items-center justify-center mb-3 sm:mb-4 group-hover:bg-scilab-blue group-hover:text-white transition-all duration-300 shadow-sm">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <h4 class="font-bold text-gray-800 mb-1 text-sm sm:text-base">User Profile</h4>
                    <p class="text-[10px] sm:text-xs text-gray-400">Account settings</p>
                </a>

                {{-- Records Card --}}
                <a href="{{ route('records.index') }}" class="group bg-white p-4 sm:p-6 rounded-2xl shadow-sm hover:shadow-lg border border-gray-100 transition-all duration-300 hover:-translate-y-1 flex flex-col items-center text-center">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-red-50 text-red-600 rounded-2xl flex items-center justify-center mb-3 sm:mb-4 group-hover:bg-red-600 group-hover:text-white transition-all duration-300 shadow-sm">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h4 class="font-bold text-gray-800 mb-1 text-sm sm:text-base">Records</h4>
                    <p class="text-[10px] sm:text-xs text-gray-400">View History</p>
                </a>

                {{-- Attendance Card (Admin Only) --}}
                @if(Auth::user()->role === 'admin')
                <a href="{{ route('attendance.index') }}" class="group bg-white p-4 sm:p-6 rounded-2xl shadow-sm hover:shadow-lg border border-gray-100 transition-all duration-300 hover:-translate-y-1 flex flex-col items-center text-center sm:col-span-1 col-span-2">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center mb-3 sm:mb-4 group-hover:bg-green-600 group-hover:text-white transition-all duration-300 shadow-sm">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h4 class="font-bold text-gray-800 mb-1 text-sm sm:text-base">Attendance</h4>
                    <p class="text-[10px] sm:text-xs text-gray-400">Log Visits</p>
                </a>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
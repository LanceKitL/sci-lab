<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sci-Lab - @yield('header')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
   
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            min-height: 100vh;
            background-color: #f8fafc;
            background-image: linear-gradient(rgba(238, 238, 238, 0.7) .1em, transparent .1em), linear-gradient(90deg, rgba(238, 238, 238, 0.7) .1em, transparent .1rem);
            background-size: 3em 3em;
        }

        .effect{
            position: fixed;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at center, #0049c7cb, #3e85ff6b, #c2c2c200);
            z-index: -1;
        }

        [x-cloak] { display: none !important; }
        .sidebar-transition { transition: transform 0.3s ease-in-out; }
    </style>
</head>
<body class="m-0 font-sans antialiased overflow-x-hidden" 
x-data="{ show: false }">
    <div class="effect"></div>
    @php
        $sidebarLabs = \App\Models\Laboratory::all();
    @endphp

    <div class="min-h-screen flex flex-col" x-data="{ sidebarOpen: false }">
        
        <nav x-cloak 
             class="fixed left-0 top-0 h-full w-[280px] bg-gradient-to-br from-scilab-blue to-scilab-dark-blue text-white flex flex-col shadow-2xl border-r border-white/10 z-[1000] sidebar-transition"
             :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
            
            <div class="p-6 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="text-xl font-bold tracking-wide">Sci-Lab</span>
                </div>
                <button @click="sidebarOpen = false" class="lg:hidden text-white/70 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="flex-1 overflow-y-auto px-4 py-4 flex flex-col gap-1">
                <p class="px-4 text-xs font-bold text-white/50 uppercase tracking-wider mb-2 mt-2">Menu</p>
                
                <a href="/dashboard" 
                   class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 font-medium text-sm {{ request()->routeIs('dashboard') ? 'bg-scilab-active-bg text-scilab-active-text font-bold shadow-md' : 'text-white/80 hover:bg-scilab-hover-bg hover:text-scilab-hover-text' }}">
                    <svg class="w-5 h-5 mr-3 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Home
                </a>

                
                @if(Auth::user()->role === 'admin' || Auth::user()->role === 'teacher')
                    <a href="{{ route('attendance.index') }}" 
                       class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 font-medium text-sm {{ request()->routeIs('attendance.*') ? 'bg-scilab-active-bg text-scilab-active-text font-bold shadow-md' : 'text-white/80 hover:bg-scilab-hover-bg hover:text-scilab-hover-text' }}">
                        <svg class="w-5 h-5 mr-3 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Lab Logs
                    </a>
                @endif

                <p class="px-4 text-xs font-bold text-white/50 uppercase tracking-wider mb-2 mt-6">Laboratories</p>

                @foreach($sidebarLabs as $lab)
                <a href="{{ route('laboratories.show', $lab->slug) }}" 
                   class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 font-medium text-sm {{ request()->is('labs/'.$lab->slug) ? 'bg-scilab-active-bg text-scilab-active-text font-bold shadow-md' : 'text-white/80 hover:bg-scilab-hover-bg hover:text-scilab-hover-text' }}">
                   <span class="w-2 h-2 rounded-full mr-3 {{ request()->is('labs/'.$lab->slug) ? 'bg-scilab-active-text' : 'bg-white/40' }}"></span>
                    {{ $lab->name }}
                </a>
                @endforeach

                <p class="px-4 text-xs font-bold text-white/50 uppercase tracking-wider mb-2 mt-6">Management</p>

                <a href="{{ route('records.index') }}" 
                   class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 font-medium text-sm {{ request()->routeIs('records.index') ? 'bg-scilab-active-bg text-scilab-active-text font-bold shadow-md' : 'text-white/80 hover:bg-scilab-hover-bg hover:text-scilab-hover-text' }}">
                    <svg class="w-5 h-5 mr-3 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Records
                </a>
                
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 font-medium text-sm {{ request()->routeIs('admin.users.index') ||  request()->routeIs('admin.users.history') ? 'bg-scilab-active-bg text-scilab-active-text font-bold shadow-md' : 'text-white/80 hover:bg-scilab-hover-bg hover:text-scilab-hover-text' }}">
                        <svg class="w-5 h-5 mr-3 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Account Approvals
                    </a>
                @endif
            </div>

            <div class="p-4 border-t border-white/10 bg-black/10">
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center gap-3 w-full p-2 rounded-lg hover:bg-white/10 transition-colors">
                        <div class="w-10 h-10 rounded-full bg-scilab-active-bg flex items-center justify-center text-scilab-active-text font-bold shadow-sm">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="text-left flex-1 min-w-0">
                            <p class="text-sm font-bold text-white truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-white/70 truncate">{{ ucfirst(Auth::user()->role) }}</p>
                        </div>
                        <svg class="w-5 h-5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div x-show="open" 
                         @click.away="open = false"
                         x-transition.origin.bottom
                         class="absolute bottom-full left-0 mb-2 w-full bg-white rounded-xl shadow-xl border border-gray-200 overflow-hidden py-1 z-[2000]" 
                         style="display: none;">
                        
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-scilab-hover-bg hover:text-scilab-hover-text transition-colors">
                            Edit Profile
                        </a>
                        
                        <form method="POST" action="{{ route('logout') }}" class="m-0 border-t border-gray-100">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <div x-show="sidebarOpen" 
             @click="sidebarOpen = false"
             x-transition.opacity
             class="fixed inset-0 bg-black/60 z-[999] lg:hidden backdrop-blur-sm"
             style="display: none;">
        </div>

        <div class="flex-1 flex flex-col h-full w-full lg:pl-[280px] transition-all duration-300">
            
            <header class="bg-white/80 backdrop-blur-md border-b border-gray-200 sticky top-0 z-[50]">
                <div class="px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
                    
                    <div class="flex items-center gap-4">
                        <button @click="sidebarOpen = true" class="lg:hidden p-2 -ml-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </button>

                        <h2 class="text-xl sm:text-2xl font-bold text-scilab-blue">
                            @yield('header')
                        </h2>
                    </div>

                    <form action="{{ route('equipment.search') }}" method="GET" class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 group-focus-within:text-scilab-hover-text transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" 
                               name="query" 
                               value="{{ request('query') }}" 
                               placeholder="Search equipment..." 
                               class="pl-10 pr-4 py-2.5 bg-gray-100 border-transparent text-gray-900 text-sm rounded-full focus:ring-2 focus:ring-scilab-hover-text focus:bg-white focus:border-transparent w-[160px] sm:w-[250px] transition-all duration-300 focus:w-[200px] sm:focus:w-[300px]">
                    </form>
                </div>
            </header>

            <main class="flex-grow p-4 sm:p-6 lg:p-8">
                {{ $slot }}
            </main>
        </div>

    </div>

    @include('layouts.footer')
</body>
</html>
<x-app-layout>
    @section('header', 'Daily Attendance Log')

    {{-- 1. TOAST NOTIFICATIONS --}}
    <div class="fixed top-20 sm:top-24 right-4 sm:right-5 z-[1100] flex flex-col gap-3 w-[calc(100%-2rem)] sm:w-full max-w-sm pointer-events-none">
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
                 class="pointer-events-auto bg-green-500 text-white px-4 sm:px-6 py-3 sm:py-4 rounded-xl shadow-2xl flex items-center gap-3 sm:gap-4 transition-all transform duration-500">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div class="min-w-0">
                    <h4 class="font-bold text-xs sm:text-sm uppercase tracking-wider">Success</h4>
                    <p class="text-xs sm:text-sm truncate">{{ session('success') }}</p>
                </div>
                <button @click="show = false" class="ml-auto text-white/80 hover:text-white">&times;</button>
            </div>
        @endif

        @if($errors->any())
            <div x-data="{ show: true }" x-show="show" 
                 class="pointer-events-auto bg-red-500 text-white px-4 sm:px-6 py-3 sm:py-4 rounded-xl shadow-2xl flex items-start gap-3 sm:gap-4 transition-all transform duration-500">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <div class="min-w-0">
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

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8 items-start">
            
            {{-- LEFT COLUMN: ENTRY FORM --}}
            <div class="lg:col-span-1 order-2 lg:order-1">
                <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-gray-100 lg:sticky lg:top-24">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 font-serif">Attendance Entry</h3>
                    </div>
                    
                    <form action="{{ route('attendance.store') }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label class="block text-xs sm:text-sm font-bold text-gray-700 mb-1.5">Full Name</label>
                            <input type="text" name="name" placeholder="e.g. Juan Dela Cruz" required
                                   class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition">
                        </div>

                        <div>
                            <label class="block text-xs sm:text-sm font-bold text-gray-700 mb-1.5">Section / Department</label>
                            <input type="text" name="section" placeholder="e.g. 10-Newton or Faculty" required
                                   class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition">
                        </div>

                        <div>
                            <label class="block text-xs sm:text-sm font-bold text-gray-700 mb-1.5">Laboratory</label>
                            <div class="relative">
                                <select name="laboratory" required
                                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm appearance-none bg-white transition">
                                    @foreach($laboratories as $lab)
                                        <option value="{{ $lab->name }}">{{ $lab->name }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3 sm:gap-4">
                            <div>
                                <label class="block text-xs sm:text-sm font-bold text-gray-700 mb-1.5">Date</label>
                                <input type="date" name="visit_date" value="{{ date('Y-m-d') }}" required
                                       class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition text-gray-600">
                            </div>
                            <div>
                                <label class="block text-xs sm:text-sm font-bold text-gray-700 mb-1.5">Time</label>
                                <input type="time" name="visit_time" value="{{ date('H:i') }}" required
                                       class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition text-gray-600">
                            </div>
                        </div>

                        <button type="submit" class="w-full py-4 rounded-xl shadow-lg bg-scilab-blue text-white font-bold text-lg hover:opacity-90 hover:shadow-xl transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                            Add to Logbook
                        </button>
                    </form>
                </div>
            </div>

            {{-- RIGHT COLUMN: THE LIST --}}
            <div class="lg:col-span-2 order-1 lg:order-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-5 sm:p-6 border-b border-gray-100 flex flex-wrap justify-between items-center gap-3">
                        <h3 class="text-lg font-bold text-gray-800">Recent Logs</h3>
                        <span class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full font-bold border border-blue-200">
                            Total: {{ $attendances->count() }}
                        </span>
                    </div>
                    
                    {{-- DESKTOP TABLE (Hidden on Mobile) --}}
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-bold tracking-wider">
                                <tr>
                                    <th class="px-6 py-4">Name</th>
                                    <th class="px-6 py-4">Section</th>
                                    <th class="px-6 py-4">Date & Time</th>
                                    <th class="px-6 py-4">Laboratory</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($attendances as $log)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 font-bold text-gray-900">{{ $log->name }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs font-bold uppercase">{{ $log->section }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            <div class="font-medium text-gray-900">{{ $log->visit_time->format('M d, Y') }}</div>
                                            <div class="text-xs">{{ $log->visit_time->format('h:i A') }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-blue-600">
                                            {{ $log->laboratory }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center text-gray-400 italic">
                                            <div class="flex flex-col items-center">
                                                <svg class="w-12 h-12 mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                No attendance records found today.
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- MOBILE CARDS (Visible only on Mobile) --}}
                    <div class="md:hidden divide-y divide-gray-100">
                        @forelse($attendances as $log)
                            <div class="p-4 hover:bg-gray-50 transition">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h4 class="font-bold text-gray-900 text-base">{{ $log->name }}</h4>
                                        <span class="inline-block mt-1 px-2 py-0.5 bg-gray-100 text-gray-600 rounded text-[10px] font-bold uppercase tracking-wide">
                                            {{ $log->section }}
                                        </span>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-xs font-bold text-gray-900">{{ $log->visit_time->format('M d') }}</div>
                                        <div class="text-xs text-gray-500">{{ $log->visit_time->format('h:i A') }}</div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 mt-3 pt-2 border-t border-gray-50">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                    <span class="text-xs font-bold text-blue-600">{{ $log->laboratory }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center text-gray-400 italic">
                                No records found today.
                            </div>
                        @endforelse
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
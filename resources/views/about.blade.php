<x-app-layout>
    @section('header', 'About Us')

    <div class=" rounded-lg  text-white min-h-screen font-sans">
    <!-- Hero Section -->
    <div class="relative overflow-hidden">

        <!-- Hero Content -->
        <div class="relative z-10 container mx-auto px-6 pt-20">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-6xl md:text-7xl font-bold font-serif mb-6 leading-tight">
                    <span class="bg-gradient-to-r from-scilab-active-bg via-white to-scilab-active-bg bg-clip-text text-transparent animate-gradient">
                        Smart Inventory
                    </span>
                    <br>
                    <span class="text-white">Management System</span>
                </h2>
                <p class="text-xl text-gray-200 mb-12 max-w-2xl mx-auto leading-relaxed">
                    A web-based laboratory inventory management system designed for Padre Garcia Integrated National High School, enabling real-time tracking and efficient resource management.
                </p>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="relative z-10 container mx-auto px-6 py-20">
        <div class="text-center mb-16">
            <h3 class="text-4xl font-bold mb-4">Key Features</h3>
            <p class="text-white">Streamlining laboratory operations through modern technology</p>
        </div>
        <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <div class="glass p-8 rounded-2xl hover:bg-scilab-active-bg/20 transition-all transform hover:-translate-y-2">
                <div class="w-14 h-14 bg-gradient-to-br from-scilab-blue to-scilab-active-text rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <h4 class="text-xl font-bold mb-3">Real-Time Tracking</h4>
                <p class="text-white">Monitor laboratory equipment and materials with live inventory updates and availability status.</p>
            </div>
            <div class="glass p-8 rounded-2xl hover:bg-scilab-active-bg/20 transition-all transform hover:-translate-y-2">
                <div class="w-14 h-14 bg-gradient-to-br from-scilab-active-text to-scilab-hover-text rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                    </svg>
                </div>
                <h4 class="text-xl font-bold mb-3">Easy Transactions</h4>
                <p class="text-white">Streamlined borrowing and returning processes with automated record keeping and notifications.</p>
            </div>
            <div class="glass p-8 rounded-2xl hover:bg-scilab-active-bg/20 transition-all transform hover:-translate-y-2">
                <div class="w-14 h-14 bg-gradient-to-br from-scilab-light-blue to-scilab-blue rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h4 class="text-xl font-bold mb-3">Accurate Records</h4>
                <p class="text-white">Generate detailed reports and maintain comprehensive logs for accountability and analysis.</p>
            </div>
        </div>
    </div>

    <!-- Researchers Section -->
  <div class="relative z-10 container mx-auto px-6 py-10">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h3 class="text-4xl font-bold mb-4">About the Researchers</h3>
                <p class="text-white text-lg">Student-researchers from Padre Garcia Integrated National High School</p>
                <p class="text-white mt-2">STEM Program • Einstein S.Y. 2025-2026</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                
                <div class="glass p-8 rounded-2xl hover:bg-scilab-active-bg/20 transition-all transform hover:-translate-y-2 text-center">
                    <div class="w-32 h-32 mx-auto mb-6 rounded-full flex items-center justify-center">
                        <img src="/images/researchers/Angangan.png" class="h-28 w-28 rounded-full object-cover border-2 border-white/20 shadow-xl" alt="Mc Daiven Angangan">
                    </div>
                    <h5 class="font-bold text-xl mb-2">Mc Daiven C. Angangan</h5>
                    <p class="text-sm text-white">Senior High School – STEM</p>
                    <p class="text-xs text-white/70 mt-1">Einstein S.Y. 2025-2026</p>
                </div>

                <div class="glass p-8 rounded-2xl hover:bg-scilab-active-bg/20 transition-all transform hover:-translate-y-2 text-center">
                    <div class="w-32 h-32 mx-auto mb-6 rounded-full flex items-center justify-center">
                        <img src="/images/researchers/Masilang.png" class="h-28 w-28 rounded-full object-cover border-2 border-white/20 shadow-xl" alt="Brent Masilang">
                    </div>
                    <h5 class="font-bold text-xl mb-2">Brent Richard R. Masilang</h5>
                    <p class="text-sm text-white">Senior High School – STEM</p>
                    <p class="text-xs text-white/70 mt-1">Einstein S.Y. 2025-2026</p>
                </div>

                <div class="glass p-8 rounded-2xl hover:bg-scilab-active-bg/20 transition-all transform hover:-translate-y-2 text-center">
                    <div class="w-32 h-32 mx-auto mb-6 rounded-full flex items-center justify-center">
                        <img src="/images/researchers/Ramos.png" class="h-28 w-28 rounded-full object-cover border-2 border-white/20 shadow-xl" alt="Era Ramos">
                    </div>
                    <h5 class="font-bold text-xl mb-2">Era Athriszah R. Ramos</h5>
                    <p class="text-sm text-white">Senior High School – STEM</p>
                    <p class="text-xs text-white/70 mt-1">Einstein S.Y. 2025-2026</p>
                </div>

                <div class="glass p-8 rounded-2xl hover:bg-scilab-active-bg/20 transition-all transform hover:-translate-y-2 text-center">
                    <div class="w-32 h-32 mx-auto mb-6 rounded-full flex items-center justify-center">
                        <img src="/images/researchers/Vergara.png" class="h-28 w-28 rounded-full object-cover shadow-xl border-2 border-white/20" alt="Ninna Vergara">
                    </div>
                    <h5 class="font-bold text-xl mb-2">Ninna Loraine B. Vergara</h5>
                    <p class="text-sm text-white">Senior High School – STEM</p>
                    <p class="text-xs text-white/70 mt-1">Einstein S.Y. 2025-2026</p>
                </div>

            </div>

            <div class="glass p-10 rounded-2xl text-center">
                <p class="text-gray-200 text-lg leading-relaxed max-w-4xl mx-auto">
                    This system was designed and developed as part of a research study focused on improving science laboratory management through the use of information technology. The researchers aim to contribute a practical and sustainable solution that supports science teachers and students in the effective utilization of laboratory resources.
                </p>
            </div>
        </div>
    </div>

</div>


</x-app-layout>
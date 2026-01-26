<x-guest-layout>
    <div class="p-6 sm:p-10 flex flex-col items-center text-center space-y-6">
        
        {{-- Animated Icon --}}
        <div class="relative w-24 h-24 bg-yellow-50 rounded-full flex items-center justify-center mb-2">
            <svg class="w-12 h-12 text-yellow-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div class="absolute inset-0 border-4 border-yellow-100 rounded-full animate-ping opacity-20"></div>
        </div>

        <h2 class="text-2xl font-bold text-gray-900 font-serif">
            Registration Successful!
        </h2>

        <div class="space-y-2 text-gray-600">
            <p>Thank you for signing up, <span class="font-bold text-gray-800">{{ session('name') }}</span>.</p>
            <p class="text-sm">
                Your account is currently <span class="font-bold text-yellow-600 bg-yellow-100 px-2 py-0.5 rounded">Pending Approval</span>.
            </p>
            <p class="text-sm">
                For security reasons, an administrator must verify your ID before you can access the laboratory system.
            </p>
        </div>

        <div class="w-full bg-gray-50 rounded-lg p-4 border border-gray-100 text-xs text-left text-gray-500">
            <strong>What happens next?</strong>
            <ul class="list-disc ml-4 mt-2 space-y-1">
                <li>The admin will review your uploaded ID.</li>
                <li>Once approved, you will be able to log in with your email and password.</li>
                <li>If rejected, you may need to register again with valid details.</li>
            </ul>
        </div>

        <a href="{{ route('login') }}" class="w-full py-3 bg-white border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-all shadow-sm">
            Return to Login
        </a>
    </div>
</x-guest-layout>
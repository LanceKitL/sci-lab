<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sci-Lab</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            /* Main Background Gradient */
            background: linear-gradient(135deg, #E6EDF5 0%, #C8D7E6 100%);
            min-height: 100vh;
            
            /* Grid Pattern Overlay */
            background-image: linear-gradient(rgba(238, 238, 238, 0.7) .1em, transparent .1em), linear-gradient(90deg, rgba(238, 238, 238, 0.7) .1em, transparent .1rem);
            background-size: 3em 3em;
            position: relative;
        }

        /* Custom Input Icon Positioning */
        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #3562AD; /* scilab-blue */
            opacity: 0.6;
            pointer-events: none;
        }

        /* creates a big blue and purple gradient shadow effect across the screen */
        .effect{
            position: fixed;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at center, #0049c7cb, #3e85ff6b, #c2c2c200);
            z-index: -1;
        }

        /* glass effect */
        #glass{
            backdrop-filter: saturate(180%) blur(20px);
            -webkit-backdrop-filter: saturate(180%) blur(20px);
            background-color: rgba(255, 255, 255, 0.85);
        }

        /* Smooth Transitions */
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-0 md:p-4">

    <div class="effect"></div>

    <div class="w-full max-w-6xl bg-white rounded-none md:rounded-3xl shadow-2xl overflow-hidden flex flex-col md:flex-row min-h-screen md:min-h-[700px]">
        
        <!-- Mobile Header with Gradient -->
        <div class="md:hidden bg-gradient-to-br from-scilab-blue to-scilab-dark-blue text-white relative p-8 pb-12">
            <div class="flex justify-center mb-6">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-28 brightness-0 invert opacity-90">
            </div>
            <div class="text-center relative z-10">
                <h1 class="text-3xl font-bold mb-2">Welcome Back!</h1>
                <p class="text-blue-100 text-sm opacity-90">Log in to access your laboratory dashboard.</p>
            </div>
            
            <!-- Decorative circles for mobile -->
            <div class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 rounded-full bg-white opacity-5"></div>
            <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-32 h-32 rounded-full bg-scilab-active-bg opacity-10"></div>
        </div>

        <!-- Desktop Sidebar with Gradient -->
        <div class="hidden md:flex md:w-5/12 bg-gradient-to-br from-scilab-blue to-scilab-dark-blue text-white relative flex-col justify-between p-12">
            <div>
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-32 brightness-0 invert opacity-90">
            </div>
            <div class="relative z-10">
                <h1 class="text-5xl font-bold mb-4 leading-tight">Welcome <br>Back!</h1>
                <p class="text-blue-100 text-lg opacity-90">Log in to access your laboratory records and inventory management dashboard.</p>
            </div>
            
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 rounded-full bg-white opacity-5"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-60 h-60 rounded-full bg-scilab-active-bg opacity-10"></div>
            
            <div class="text-sm text-blue-200">
                &copy; 2026 Sci-Lab System
            </div>
        </div>

        <!-- Form Section with Glass Effect -->
        <div id="glass" class="w-full md:w-7/12 p-6 sm:p-8 md:p-12 lg:p-16 relative flex flex-col justify-center">

            <div class="max-w-md mx-auto w-full">

                <div class="mb-10 text-center md:text-left">
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-scilab-blue tracking-tight">Log In</h2>
                    <p class="text-gray-500 mt-2 text-sm sm:text-base">Please enter your credentials to continue.</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-700 mb-1">Email Address</label>
                        <div class="relative">
                            <svg class="w-5 h-5 input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <input id="email" type="email" name="email" required autofocus placeholder="name@school.edu"
                                class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-scilab-blue focus:border-transparent outline-none transition-all font-medium text-gray-800">
                        </div>
                    </div>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    
                    <div>
                        <label for="password" class="block text-sm font-bold text-gray-700 mb-1">Password</label>
                        <div class="relative">
                            <svg class="w-5 h-5 input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            <input id="password" type="password" name="password" required placeholder="••••••••"
                                class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-scilab-blue focus:border-transparent outline-none transition-all font-medium text-gray-800">
                        </div>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <div>
                        <button type="submit" 
                            class="w-full py-4 rounded-xl shadow-lg bg-scilab-blue text-white font-bold text-lg hover:opacity-90 hover:shadow-xl transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                            Log In
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                        </button>
                    </div>

                    <!-- forgot password link -->
                    <p class="text-center text-sm text-gray-500">
                        <a href="{{ route('password.request') }}" class="text-scilab-active-text font-bold hover:underline transition">Forgot your password?</a>
                    </p>

                    <p class="text-center mt-8 text-sm text-gray-500">
                        Don't have an account? 
                        <a href="{{ route('register') }}" class="text-scilab-active-text font-bold hover:underline transition">Register here</a>
                    </p>

                </form>
            </div>
        </div>
    </div>

</body>
</html>
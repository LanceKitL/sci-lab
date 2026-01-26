<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Sci-Lab</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
        
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            margin: 0;
            padding: 0;

            width: 100%;
            height: 100dvh;
            
            background: #ffffff;
            background-image: linear-gradient(rgba(238, 238, 238, 0.7) .1em, transparent .1em), linear-gradient(90deg, rgba(238, 238, 238, 0.7) .1em, transparent .1rem);
            background-size: 3em 3em;
        }

        
        /* Custom Input Icon Positioning */
        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #253d46; /* scilab-blue */
            pointer-events: none;
        }

        /* create a big blue and purple gradient shadow effect across the screen */
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

    <div  class="w-full max-w-6xl bg-white rounded-none md:rounded-3xl shadow-2xl overflow-hidden flex flex-col md:flex-row min-h-screen md:min-h-[800px] relative z-10">
        
        <!-- Mobile Header with Gradient -->
        <div class="md:hidden bg-gradient-to-br from-scilab-blue to-scilab-dark-blue text-white relative p-8 pb-12">
            <div class="flex justify-center mb-6">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-28 brightness-0 invert opacity-90">
            </div>
            <div class="text-center relative z-10">
                <h1 class="text-3xl font-bold mb-2">Welcome to Sci-Lab</h1>
                <p class="text-blue-100 text-sm opacity-90">Manage your laboratory inventory and attendance with ease.</p>
            </div>
            
            <!-- Decorative circles for mobile -->
            <div class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 rounded-full bg-white opacity-5"></div>
            <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-32 h-32 rounded-full bg-white opacity-10"></div>
        </div>

        <!-- Desktop Sidebar with Gradient -->
        <div class="hidden md:flex md:w-5/12 bg-gradient-to-br from-scilab-blue to-scilab-dark-blue text-white relative flex-col justify-between p-12 z-20">
            <div>
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-32 brightness-0 invert opacity-90">
            </div>
            <div class="relative z-10">
                <h1 class="text-5xl font-bold mb-4 leading-tight">Welcome to <br>Sci-Lab</h1>
                <p class="text-blue-100 text-lg opacity-90">Manage your laboratory inventory and attendance with precision and ease.</p>
            </div>
            
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 rounded-full bg-white opacity-5"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-60 h-60 rounded-full bg-white opacity-10"></div>
            
            <div class="text-sm text-blue-200">
                &copy; {{ date('Y') }} Sci-Lab System
            </div>
        </div>

        <!-- Form Section with Glass Effect -->
        <div id="glass" class="w-full md:w-7/12 p-6 sm:p-8 md:p-12 lg:p-16 relative flex flex-col justify-center z-20">

            <div x-data="{ 
                step: {{ $errors->has('email') || $errors->has('password') ? 2 : 1 }}, 
                role: '{{ old('role', 'student') }}',
                
                validateStep1() {
                    // 1. Validate Name
                    const name = document.getElementById('name');
                    if (!name.checkValidity()) { 
                        name.reportValidity(); 
                        return; 
                    }
                    
                    // 2. Validate Section (Only if Student)
                    if (this.role === 'student') {
                        const section = document.getElementById('section');
                        // Check if exists and is valid
                        if (section && !section.checkValidity()) { 
                            section.reportValidity(); 
                            return; 
                        }
                    }

                    // 3. Validate Dept (Only if Teacher)
                    if (this.role === 'teacher') {
                        const dept = document.getElementById('department');
                        // Check if exists and is valid
                        if (dept && !dept.checkValidity()) { 
                            dept.reportValidity(); 
                            return; 
                        }
                    }

                    // If all pass, move to step 2
                    this.step = 2;
                }
             }" class="max-w-md mx-auto w-full">

                <div class="mb-10 text-center md:text-left">
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-scilab-blue tracking-tight">Create Account</h2>
                    <p class="text-gray-600 mt-2 text-sm sm:text-base font-medium">Step <span x-text="step"></span> of 2 &bull; <span x-text="step === 1 ? 'Personal Details' : 'Account Security'"></span></p>
                    
                    <div class="w-full bg-white/50 rounded-full h-2 mt-6 overflow-hidden border border-white/60">
                        <div class="h-full bg-gradient-to-r from-scilab-blue to-scilab-dark-blue transition-all duration-500 ease-out" 
                             :style="'width: ' + (step === 1 ? '50%' : '100%')"></div>
                    </div>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5" enctype="multipart/form-data">
                    @csrf

                    <div x-show="step === 1" 
                         x-transition:enter="transition ease-out duration-300" 
                         x-transition:enter-start="opacity-0 -translate-x-10" 
                         x-transition:enter-end="opacity-100 translate-x-0">
                        
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Full Name</label>
                            <div class="relative">
                                <svg class="w-5 h-5 input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="e.g. Juan Dela Cruz"
                                    class="w-full pl-11 pr-4 py-3.5 bg-white/60 border border-white/50 rounded-xl  focus:ring-2 focus:ring-scilab-blue focus:border-transparent outline-none transition-all font-medium text-gray-800 placeholder-gray-500 shadow-md">
                            </div>
                            @error('name') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div class="mt-5">
                            <label class="block text-sm font-bold text-gray-700 mb-1">I am a...</label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="cursor-pointer">
                                    <input type="radio" name="role" value="student" x-model="role" class="peer sr-only">
                                    <div class="flex flex-col items-center justify-center p-4 border-2 border-white/50 bg-white/40 rounded-xl peer-checked:border-scilab-blue peer-checked:bg-white/80 transition-all hover:bg-white/60 shadow-md">
                                        <svg class="w-6 h-6 mb-1 text-gray-500 peer-checked:text-scilab-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                                        <span class="text-sm font-bold text-gray-600 peer-checked:text-scilab-blue">Student</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="role" value="teacher" x-model="role" class="peer sr-only">
                                    <div class="flex flex-col items-center justify-center p-4 border-2 border-white/50 bg-white/40 rounded-xl peer-checked:border-scilab-blue peer-checked:bg-white/80 transition-all hover:bg-white/60 shadow-md">
                                        <svg class="w-6 h-6 mb-1 text-gray-500 peer-checked:text-scilab-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                                        <span class="text-sm font-bold text-gray-600 peer-checked:text-scilab-blue">Teacher</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="mt-5">
                            <div x-show="role === 'student'">
                                <label class="block text-sm font-bold text-gray-700 mb-1">Grade & Section</label>
                                <div class="relative">
                                    <svg class="w-5 h-5 input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    <input id="section" type="text" name="section" value="{{ old('section') }}" :required="role === 'student'" placeholder="e.g. 10-Newton"
                                        class="w-full pl-11 pr-4 py-3.5 bg-white/60 border border-white/50 rounded-xl  focus:ring-2 focus:ring-scilab-blue focus:border-transparent outline-none transition-all font-medium text-gray-800 placeholder-gray-500 shadow-md">
                                </div>
                                @error('section') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <div x-show="role === 'teacher'" style="display: none;">
                                <label class="block text-sm font-bold text-gray-700 mb-1">Department</label>
                                <div class="relative">
                                    <svg class="w-5 h-5 input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    <input id="department" type="text" name="department" value="{{ old('department') }}" :required="role === 'teacher'" placeholder="e.g. Science Dept."
                                        class="w-full pl-11 pr-4 py-3.5 bg-white/60 border border-white/50 rounded-xl  focus:ring-2 focus:ring-scilab-blue focus:border-transparent outline-none transition-all font-medium text-gray-800 placeholder-gray-500 shadow-md">
                                </div>
                                @error('department') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="mt-8">
                            <button type="button" @click="validateStep1()"
                                class="w-full py-4 rounded-xl shadow-lg bg-scilab-blue text-white font-bold text-lg hover:bg-scilab-dark-blue hover:shadow-xl transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                Next Step 
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </div>
                    </div>

                    <div x-show="step === 2" x-cloak 
                         x-transition:enter="transition ease-out duration-300" 
                         x-transition:enter-start="opacity-0 translate-x-10" 
                         x-transition:enter-end="opacity-100 translate-x-0">
                        
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Email Address</label>
                            <div class="relative">
                                <svg class="w-5 h-5 input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="name@school.edu"
                                    class="w-full pl-11 pr-4 py-3.5 bg-white/60 border border-white/50 rounded-xl  focus:ring-2 focus:ring-scilab-blue focus:border-transparent outline-none transition-all font-medium text-gray-800 placeholder-gray-500 shadow-md">
                            </div>
                            @error('email') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div class="mt-5">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Upload School ID</label>
                            <div class="relative border-2 border-dashed border-gray-300 rounded-xl p-6 flex flex-col items-center justify-center bg-gray-50 hover:bg-gray-100 transition-colors cursor-pointer group">

                                <input type="file" name="id_image" id="id_image" accept="image/*" required 
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                    onchange="document.getElementById('preview-text').innerText = this.files[0].name;">

                                <svg class="w-8 h-8 text-gray-400 group-hover:text-scilab-blue mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>

                                <p id="preview-text" class="text-xs text-gray-500 font-medium text-center">
                                    Click to upload image (JPG/PNG)
                                </p>
                            </div>
                            @error('id_image') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div class="mt-5">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Password</label>
                            <div class="relative">
                                <svg class="w-5 h-5 input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                <input id="password" type="password" name="password" required placeholder="••••••••"
                                    class="w-full pl-11 pr-4 py-3.5 bg-white/60 border border-white/50 rounded-xl  focus:ring-2 focus:ring-scilab-blue focus:border-transparent outline-none transition-all font-medium text-gray-800 placeholder-gray-500 shadow-md">
                            </div>
                            @error('password') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div class="mt-5">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Confirm Password</label>
                            <div class="relative">
                                <svg class="w-5 h-5 input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="••••••••"
                                    class="w-full pl-11 pr-4 py-3.5 bg-white/60 border border-white/50 rounded-xl  focus:ring-2 focus:ring-scilab-blue focus:border-transparent outline-none transition-all font-medium text-gray-800 placeholder-gray-500 shadow-md">
                            </div>
                        </div>

                        <div class="flex gap-4 mt-8">
                            <button type="button" @click="step = 1"
                                class="w-1/3 py-4 rounded-xl border-2 border-white/60 text-gray-600 font-bold hover:bg-white/50 transition-all">
                                Back
                            </button>
                            <button type="submit"
                                class="w-2/3 py-4 rounded-xl shadow-lg bg-scilab-blue text-white font-bold text-lg hover:bg-scilab-dark-blue hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                                Register
                            </button>
                        </div>
                    </div>

                    <p class="text-center mt-8 text-sm text-gray-600 font-medium">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="text-scilab-blue font-bold hover:underline transition">Login here</a>
                    </p>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Shreeji Admin | Finance Portal</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS (CDN for immediate rendering) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            DEFAULT: '#0346cbff', // Teal
                            dark: '#0346cbff',
                            light: '#e0fcfd',
                        },
                        dark: {
                            bg: '#0F172A', // Slate 900
                            card: '#1E293B', // Slate 800
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Outfit', sans-serif; }
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="bg-[#050511] text-gray-800 antialiased h-screen flex flex-col items-center justify-center overflow-hidden relative">

    <!-- Ambient Background Lighting (Blue/Teal/Purple) -->
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden pointer-events-none z-0">
        <div class="absolute top-[-20%] left-[-10%] w-[50%] h-[50%] bg-[#0346cbff] rounded-full blur-[180px] opacity-20"></div>
        <div class="absolute bottom-[-20%] right-[-10%] w-[50%] h-[50%] bg-blue-700 rounded-full blur-[180px] opacity-20"></div>
    </div>

    <!-- Login Container -->
    <div class="w-full max-w-md z-10 px-6">
        
        <!-- Header / Logo Area -->
        <div class="text-center mb-8">
             <div class="w-20 h-20 bg-gradient-to-tr from-[#0346cbff] to-blue-500 rounded-3xl mx-auto flex items-center justify-center shadow-2xl shadow-cyan-500/20 mb-6 transform rotate-3 hover:rotate-0 transition-transform duration-500">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <h1 class="text-4xl font-bold text-white mb-2 tracking-tight">Shreeji Finance</h1>
            <p class="text-gray-400">Secure access to the Admin Finance Portal</p>
        </div>

        <!-- Card -->
        <div class="glass-effect rounded-[2.5rem] shadow-2xl p-8 sm:p-10 relative overflow-hidden">
            <!-- Decorative top banner inside card -->
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-[#0346cbff] to-blue-600"></div>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2 ml-1">Email Address</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 group-focus-within:text-[#0346cbff] transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                        </span>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                            class="w-full pl-12 pr-4 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#0346cbff]/50 focus:border-[#00BDD6] transition-all font-medium text-gray-800 placeholder-gray-400"
                            placeholder="admin@shreejifinance.com">
                    </div>
                </div>

                <!-- Password Input -->
                <div>
                    <div class="flex justify-between items-center mb-2 ml-1">
                        <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                    </div>
                    <div class="relative group">
                         <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 group-focus-within:text-[#0346cbff] transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </span>
                        <input id="password" type="password" name="password" required 
                            class="w-full pl-12 pr-4 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#0346cbff]/50 focus:border-[#0346cbff] transition-all font-medium text-gray-800 placeholder-gray-400"
                            placeholder="••••••••••••">
                    </div>
                    
                </div>

                <!-- Remember Me -->
                <div class="flex items-center ml-1">
                    <input id="remember_me" type="checkbox" class="w-4 h-4 rounded border-gray-300 text-[#0346cbff] focus:ring-[#0346cbff]" name="remember">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-600">Keep me logged in</label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-4 px-6 bg-[#0346cbff] hover:bg-[#0346cbff] text-white font-bold rounded-2xl shadow-lg shadow-cyan-500/30 transform transition hover:-translate-y-0.5 active:translate-y-0 focus:outline-none focus:ring-4 focus:ring-[#0346cbff]/30 text-lg tracking-wide">
                    Sign In
                </button>
            </form>
        </div>

        <div class="text-center mt-8 text-white/40 text-sm">
            &copy; {{ date('Y') }} Shreeji Finance. All rights reserved.
        </div>
    </div>
</body>
</html>

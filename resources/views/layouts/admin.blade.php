<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Shreeja Admin') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Figtree', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            DEFAULT: '#0F172A', // Teal
                            dark: '#0F172A',
                            light: '#e0fcfd',
                        }
                    }
                }
            }
        }
    </script>
    <!-- jQuery & DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.tailwindcss.css">
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.tailwindcss.js"></script>
    
    <!-- DataTables Buttons -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.1/css/buttons.tailwindcss.css">
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.tailwindcss.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.print.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        .dt-buttons { 
            margin-bottom: 1rem;
            display: flex;
            gap: 8px;
        }
        button.dt-button, .dt-button { 
            background-color: #0346cbff !important;
            color: white !important;
            border-radius: 14px !important;
            padding: 10px 20px !important;
            border: none !important;
            font-weight: 800 !important;
            font-size: 11px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 4px 6px -1px rgba(3, 70, 203, 0.1), 0 2px 4px -1px rgba(3, 70, 203, 0.06) !important;
        }
        button.dt-button:hover, .dt-button:hover {
            background-color: #0F172A !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 10px 15px -3px rgba(3, 70, 203, 0.2) !important;
        }
        div.dt-container .dt-paging .dt-paging-button {
            border-radius: 12px !important;
            border: none !important;
            padding: 8px 16px !important;
            font-weight: bold !important;
        }
        div.dt-container .dt-paging .dt-paging-button.current {
            background: #0346cbff !important;
            color: white !important;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100" 
      x-data="{ showToast: false, toastMessage: '', toastType: 'success' }"
      x-init="
        @if (session('success'))
            toastMessage = '{{ session('success') }}';
            toastType = 'success';
            showToast = true;
            setTimeout(() => showToast = false, 5000);
        @endif
        @if (session('error'))
            toastMessage = '{{ session('error') }}';
            toastType = 'error';
            showToast = true;
            setTimeout(() => showToast = false, 5000);
        @endif
      ">
    
    <!-- Alpine.js Toast Notification -->
    <template x-if="showToast">
        <div class="fixed top-6 right-6 z-[100] animate-in slide-in-from-right duration-500">
            <div :class="toastType === 'success' ? 'bg-[#0346cbff]' : 'bg-rose-500'" class="px-8 py-4 rounded-[2rem] shadow-2xl flex items-center text-white backdrop-blur-xl border border-white/20">
                <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center mr-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest opacity-70">Notification</p>
                    <p class="font-bold text-sm" x-text="toastMessage"></p>
                </div>
                <button @click="showToast = false" class="ml-6 opacity-50 hover:opacity-100 transition-opacity">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>
    </template>
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-[#0F172A] text-white flex-shrink-0 hidden md:flex flex-col transition-all duration-300 shadow-xl z-20">
            <div class="p-4 flex items-center justify-center h-16 border-b border-gray-700">
                <h1 class="text-2xl font-bold tracking-wider">SHREEJA</h1>
            </div>
            <nav class="flex-1 overflow-y-auto py-4">
                <ul class="space-y-1 px-2">
                    <li>
                        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-[#0346cbff] transition-colors {{ request()->routeIs('dashboard') ? 'bg-[#0346cbff]' : 'text-gray-300 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.employees.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-[#0346cbff] transition-colors {{ request()->routeIs('admin.employees.*') ? 'bg-[#0346cbff]' : 'text-gray-300 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            Employee Management
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.leads.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-[#0346cbff] transition-colors {{ request()->routeIs('admin.leads.index') ? 'bg-[#0346cbff]' : 'text-gray-300 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Lead Management
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.leads.disbursements') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-[#0346cbff] transition-colors {{ request()->routeIs('admin.leads.disbursements') ? 'bg-[#0346cbff]' : 'text-gray-300 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            Disbursed Loans
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.partners.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-[#0346cbff] transition-colors {{ request()->routeIs('admin.partners.*') ? 'bg-[#0346cbff]' : 'text-gray-300 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Partner Management
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.inquiries.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-[#0346cbff] transition-colors {{ request()->routeIs('admin.inquiries.*') ? 'bg-[#0346cbff]' : 'text-gray-300 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Queries / Inquiries
                        </a>
                    </li>
                    <!-- Add more mocked links based on reference image -->
                    <li>
                        <a href="{{ route('admin.customers.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-[#0346cbff] transition-colors {{ request()->routeIs('admin.customers.*') ? 'bg-[#0346cbff]' : 'text-gray-300 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V24a1 1 0 01-1 1H5a1 1 0 01-1-1v-5z"></path></svg>
                            Customer Management
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.wallet.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-[#0346cbff] transition-colors {{ request()->routeIs('admin.wallet.*') ? 'bg-[#0346cbff]' : 'text-gray-300 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Wallet & Payouts
                        </a>
                    </li>
                    
                    <li class="mt-auto">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center w-full px-4 py-3 rounded-lg hover:bg-[#0346cbff] transition-colors text-left text-gray-300 hover:text-white">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden relative">
            <!-- Top Header -->
            <header class="bg-white shadow-md z-10 flex-shrink-0">
                <div class="flex items-center justify-between h-16 px-6">
                    <!-- Mobile Menu Button -->
                    <button class="md:hidden p-2 rounded-md hover:bg-gray-100 focus:outline-none">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>

                    <!-- Search -->
                    <div class="relative hidden md:block w-96">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input type="text" class="w-full pl-10 pr-4 py-2 bg-gray-50 border-none rounded-full shadow-inner focus:outline-none focus:ring-2 focus:ring-[#0346cbff] transition-all" placeholder="Search...">
                    </div>

                    <!-- Right Side Actions -->
                    <div class="flex items-center space-x-4">
                        <!-- Message Signal Hub -->
                        <a href="{{ route('admin.messages.index') }}" class="relative w-11 h-11 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:text-[#0346cbff] hover:bg-blue-50 transition-all group overflow-visible">
                            <i class="fa-solid fa-comment-dots text-lg"></i>
                            @php $unreadMsg = \App\Models\Message::whereNull('receiver_id')->where('is_read', false)->count(); @endphp
                            @if($unreadMsg > 0)
                                <div class="absolute -top-1.5 -right-1.5 flex h-5 w-5 items-center justify-center">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-5 w-5 bg-rose-500 text-[9px] text-white font-black items-center justify-center border-2 border-white shadow-sm">{{ $unreadMsg }}</span>
                                </div>
                            @endif
                        </a>

                        <!-- Notification Signal Hub (Dropdown) -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.away="open = false" class="relative w-11 h-11 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:text-[#0346cbff] hover:bg-blue-50 transition-all group overflow-visible">
                                <i class="fa-solid fa-bell text-lg transition-transform group-hover:rotate-12"></i>
                                @php $unreadNotif = \App\Models\Notification::whereNull('user_id')->where('is_read', false)->count(); @endphp
                                @if($unreadNotif > 0)
                                    <div class="absolute -top-1.5 -right-1.5 flex h-5 w-5 items-center justify-center">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#0346cbff] opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-5 w-5 bg-[#0346cbff] text-[9px] text-white font-black items-center justify-center border-2 border-white shadow-sm">{{ $unreadNotif }}</span>
                                    </div>
                                @endif
                            </button>

                            <!-- Mini Dropdown Panel -->
                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95 translate-y-[-10px]"
                                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 scale-95 translate-y-[-10px]"
                                 class="absolute right-0 mt-3 w-80 bg-white rounded-[2rem] shadow-[0_20px_50px_-15px_rgba(0,0,0,0.15)] border border-slate-100 overflow-hidden z-50 py-2"
                                 style="display: none;">
                                
                                <!-- Header -->
                                <div class="px-6 py-4 border-b border-slate-50 flex items-center justify-between">
                                    <h4 class="text-sm font-black text-slate-800 uppercase tracking-wider">Notifications</h4>
                                    <a href="{{ route('admin.notifications.index') }}" class="text-[10px] font-black text-[#0346cbff] hover:underline uppercase tracking-widest">View All</a>
                                </div>

                                <!-- Body -->
                                <div class="max-h-[350px] overflow-y-auto custom-scrollbar">
                                    @php $recentNotifs = \App\Models\Notification::whereNull('user_id')->latest()->take(5)->get(); @endphp
                                    @forelse($recentNotifs as $notif)
                                        <div class="px-6 py-4 hover:bg-slate-50 transition-colors border-b border-slate-50 last:border-0 flex gap-4 items-start cursor-pointer">
                                            <div class="w-10 h-10 rounded-xl bg-slate-50 flex-shrink-0 flex items-center justify-center text-[#0346cbff]">
                                                @switch($notif->type)
                                                    @case('LOAN') <i class="fa-solid fa-file-invoice-dollar text-xs"></i> @break
                                                    @case('PARTNER') <i class="fa-solid fa-handshake text-xs"></i> @break
                                                    @case('USER') <i class="fa-solid fa-user-plus text-xs"></i> @break
                                                    @default <i class="fa-solid fa-bell text-xs"></i>
                                                @endswitch
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-xs font-bold text-slate-800 truncate mb-0.5">{{ $notif->title }}</p>
                                                <p class="text-[10px] text-slate-400 font-medium line-clamp-2 leading-relaxed">{{ $notif->message }}</p>
                                                <p class="text-[8px] text-[#0346cbff] font-black mt-2 uppercase tracking-widest">{{ $notif->created_at->diffForHumans() }}</p>
                                            </div>
                                            @if(!$notif->is_read)
                                                <div class="w-1.5 h-1.5 rounded-full bg-[#0346cbff] mt-2"></div>
                                            @endif
                                        </div>
                                    @empty
                                        <div class="py-12 px-6 text-center opacity-40">
                                            <i class="fa-solid fa-bell-slash text-3xl mb-3"></i>
                                            <p class="text-xs font-bold uppercase tracking-[2px]">No new notifications</p>
                                        </div>
                                    @endforelse
                                </div>

                                <!-- Footer -->
                                <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-50 text-center">
                                    <form action="{{ route('admin.notifications.index') }}" method="GET">
                                        <button class="text-[10px] font-black text-slate-500 hover:text-[#0346cbff] transition-colors uppercase tracking-[2px] flex items-center justify-center w-full gap-2">
                                            <i class="fa-solid fa-check-double text-[8px]"></i>
                                            Mark all as read
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 cursor-pointer group">
                             <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-[#0346cbff] to-cyan-400 p-0.5 shadow-md overflow-hidden">
                                @if(Auth::user()->avatar_url)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar_url) }}" class="w-full h-full rounded-full object-cover">
                                @else
                                    <div class="w-full h-full rounded-full bg-white flex items-center justify-center text-[#0346cbff] font-bold">
                                        {{ Auth::user()->name[0] ?? 'A' }}
                                    </div>
                                @endif
                             </div>
                             <span class="text-sm font-semibold text-gray-700 hidden md:block group-hover:text-[#0346cbff] transition-colors">{{ Auth::user()->name ?? 'Admin' }}</span>
                        </a>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 scroll-smooth">
                @if (isset($header))
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold text-gray-800 tracking-tight">
                            {{ $header }}
                        </h2>
                    </div>
                @endif

                {{ $slot }}
            </main>

        </div>
    </div>
</body>
</html>

<x-admin-layout>
    
 <h1 style="margin-left: 50px !important; margin-top: 20px !important; font-size:30px; font-weight:bold;">Dashboard Overview</h1>
    <div class="py-4 bg-[#F8FAFC]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Welcome Banner -->
            <div class="bg-gradient-to-r from-[#0346cbff] to-blue-700 rounded-[3rem] shadow-[0_20px_50px_-15px_rgba(3,70,203,0.3)] p-10 mb-10 text-white relative overflow-hidden group">
                <div class="relative z-10">
                    @php $unreadCount = \App\Models\Message::whereNull('receiver_id')->where('is_read', false)->count(); @endphp
                    <h3 class="text-3xl sm:text-4xl font-black mb-3 tracking-tight">System Status: Optimal, {{ Auth::user()->name ?? 'Admin' }}</h3>
                    <p class="text-blue-100 text-sm opacity-90 font-medium max-w-2xl leading-relaxed">
                        The secure network is stable. You have <span class="text-yellow-300 font-bold underline decoration-wavy underline-offset-4">{{ $unreadCount }} unread signals</span> waiting for decryption in the communication hub.
                    </p>
                </div>
                <div class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 bg-white/10 rounded-full blur-3xl transition-all duration-700 group-hover:scale-125"></div>
                <div class="absolute inset-0 bg-gradient-to-b from-white/5 to-transparent"></div>
            </div>

            <!-- Stats Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <!-- Total Customers -->
                <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-7 group hover:shadow-xl transition-all duration-500">
                    <div class="flex items-center justify-between mb-5">
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#0346cbff] flex items-center justify-center border border-blue-100 transition-colors group-hover:bg-[#0346cbff] group-hover:text-white">
                            <i class="fa-solid fa-users text-xl"></i>
                        </div>
                        <span class="text-[10px] font-black text-emerald-500 bg-emerald-50 px-3 py-1 rounded-full uppercase tracking-widest">+12%</span>
                    </div>
                    <h3 class="text-3xl font-black text-slate-800 mb-1 tracking-tight">{{ \App\Models\User::count() }}</h3>
                    <p class="text-slate-400 text-[9px] font-black uppercase tracking-[2px]">Total Entities</p>
                </div>

                <!-- Active Loans -->
                <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-7 group hover:shadow-xl transition-all duration-500">
                    <div class="flex items-center justify-between mb-5">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center border border-indigo-100 transition-colors group-hover:bg-indigo-600 group-hover:text-white">
                            <i class="fa-solid fa-file-invoice-dollar text-xl"></i>
                        </div>
                        <span class="text-[10px] font-black text-blue-500 bg-blue-50 px-3 py-1 rounded-full uppercase tracking-widest">Active</span>
                    </div>
                    <h3 class="text-3xl font-black text-slate-800 mb-1 tracking-tight">{{ \App\Models\Loan::count() }}</h3>
                    <p class="text-slate-400 text-[9px] font-black uppercase tracking-[2px]">Loan Payloads</p>
                </div>

                <!-- Unread Messages -->
                <a href="{{ route('admin.messages.index') }}" class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-7 group hover:shadow-xl hover:border-rose-200 transition-all duration-500">
                    <div class="flex items-center justify-between mb-5">
                        <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center border border-rose-100 transition-colors group-hover:bg-rose-500 group-hover:text-white">
                            <i class="fa-solid fa-comment-dots text-xl"></i>
                        </div>
                        @if($unreadCount > 0)
                            <span class="text-[10px] font-black text-white bg-rose-500 px-3 py-1 rounded-full uppercase tracking-widest animate-pulse">{{ $unreadCount }} NEW</span>
                        @endif
                    </div>
                    <h3 class="text-3xl font-black text-slate-800 mb-1 tracking-tight">{{ $unreadCount }}</h3>
                    <p class="text-slate-400 text-[9px] font-black uppercase tracking-[2px]">Pending Signals</p>
                </a>

                <!-- System Inquiries -->
                <a href="{{ route('admin.elite.index') }}" class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-7 group hover:shadow-xl hover:border-amber-200 transition-all duration-500">
                    <div class="flex items-center justify-between mb-5">
                        <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center border border-amber-100 transition-colors group-hover:bg-amber-600 group-hover:text-white">
                            <i class="fa-solid fa-bolt-lightning text-xl"></i>
                        </div>
                        <span class="text-[10px] font-black text-amber-600 bg-amber-50 px-3 py-1 rounded-full uppercase tracking-widest">Elite</span>
                    </div>
                    <h3 class="text-3xl font-black text-slate-800 mb-1 tracking-tight">{{ \App\Models\EliteApplication::count() }}</h3>
                    <p class="text-slate-400 text-[9px] font-black uppercase tracking-[2px]">Elite Nodes</p>
                </a>
            </div>

            <!-- Charts & Content -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                <!-- Chart Area -->
                <div class="bg-[#F1F5F9] rounded-[2.5rem] shadow-sm p-10 border border-white overflow-hidden relative group">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-[#0346cbff]/5 rounded-full blur-3xl -mt-20 -mr-20"></div>
                    <div class="flex items-center justify-between mb-10 relative z-10">
                        <div>
                            <h4 class="text-2xl font-black text-slate-900 tracking-tight flex items-center">
                                <span class="w-8 h-8 rounded-lg bg-[#0346cbff]/10 flex items-center justify-center mr-3 text-[#0346cbff]">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11 4a1 1 0 10-2 0v4a1 1 0 102 0V7zm-3 1a1 1 0 10-2 0v3a1 1 0 102 0V8zM8 9a1 1 0 00-2 0v2a1 1 0 102 0V9z" clip-rule="evenodd"></path></svg>
                                </span>
                                Ride Analytics
                            </h4>
                            <p class="text-sm text-slate-400 mt-2 font-medium">Growth performance over time</p>
                        </div>
                        <select class="px-4 py-2 bg-white border-transparent rounded-xl text-sm font-bold text-slate-600 shadow-sm focus:ring-[#0346cbff] focus:border-[#0346cbff] cursor-pointer">
                            <option>Last 7 Days</option>
                            <option>Last 30 Days</option>
                        </select>
                    </div>
                    <div class="h-80 bg-white/60 backdrop-blur-sm rounded-[2rem] flex flex-col items-center justify-center border-2 border-dashed border-slate-200 group/chart hover:border-[#0346cbff]/40 transition-all duration-500 relative z-10">
                         <div class="p-5 rounded-2xl bg-white shadow-xl text-[#0346cbff] mb-4 group-hover/chart:scale-110 transition-transform duration-500">
                             <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                             </svg>
                         </div>
                         <span class="text-slate-400 font-bold tracking-tight text-lg group-hover/chart:text-[#0346cbff] transition-colors">Visualizing Data...</span>
                    </div>
                </div>

                <!-- Recent Bookings Table -->
                <div class="bg-[#EEF2FF] rounded-[2.5rem] shadow-sm p-10 border border-white overflow-hidden relative group">
                    <div class="absolute bottom-0 left-0 w-64 h-64 bg-indigo-500/5 rounded-full blur-3xl -mb-20 -ml-20"></div>
                    <div class="flex items-center justify-between mb-10 relative z-10">
                         <div>
                            <h4 class="text-2xl font-black text-slate-900 tracking-tight flex items-center">
                                <span class="w-8 h-8 rounded-lg bg-indigo-100 flex items-center justify-center mr-3 text-indigo-600">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path></svg>
                                </span>
                                Recent Activity
                            </h4>
                            <p class="text-sm text-slate-400 mt-2 font-medium">Real-time booking flow</p>
                        </div>
                        <a href="#" class="px-5 py-2.5 bg-white shadow-sm rounded-xl text-xs font-black text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all duration-300">VIEW ALL</a>
                    </div>
                    <div class="overflow-x-auto relative z-10">
                        <table class="w-full text-sm text-left border-separate border-spacing-y-3">
                            <thead>
                                <tr class="text-[10px] text-slate-400 font-black uppercase tracking-widest">
                                    <th class="px-6 py-2">Customer</th>
                                    <th class="px-6 py-2">Route Details</th>
                                    <th class="px-6 py-2 text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(\App\Models\EliteApplication::with('user')->latest()->take(3)->get() as $app)
                                <tr class="bg-white/60 backdrop-blur-sm hover:bg-white transition-all duration-300 rounded-2xl group/row shadow-sm">
                                    <td class="px-6 py-5 rounded-l-2xl">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center text-sm font-black mr-4 shadow-inner uppercase excerpt">
                                                {{ substr($app->user->name ?? 'U', 0, 2) }}
                                            </div>
                                            <div>
                                                <p class="font-black text-slate-900 leading-tight">{{ $app->user->name ?? 'User' }}</p>
                                                <p class="text-[10px] text-slate-400 font-bold uppercase">Elite Protocol Authorized</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 font-bold text-slate-600">
                                        Score: {{ $app->score }} • Int: {{ $app->interest_rate }}%
                                    </td>
                                    <td class="px-6 py-5 rounded-r-2xl text-right">
                                        <span class="bg-amber-100 text-amber-600 text-[10px] font-black px-3 py-1.5 rounded-lg uppercase tracking-wider border border-amber-200/50">Elite Offer</span>
                                    </td>
                                </tr>
                                @endforeach

                                @if(\App\Models\EliteApplication::count() == 0)
                                <tr class="bg-white/60 backdrop-blur-sm hover:bg-white transition-all duration-300 rounded-2xl group/row shadow-sm">
                                    <td class="px-6 py-5 rounded-l-2xl">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-xl bg-blue-100 text-[#0346cbff] flex items-center justify-center text-sm font-black mr-4 shadow-inner">RK</div>
                                            <div>
                                                <p class="font-black text-slate-900 leading-tight">Rahul Kapoor</p>
                                                <p class="text-[10px] text-slate-400 font-bold uppercase">Gold Member</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 font-bold text-slate-600">Mumbai Central - Colaba</td>
                                    <td class="px-6 py-5 rounded-r-2xl text-right">
                                        <span class="bg-emerald-100 text-emerald-600 text-[10px] font-black px-3 py-1.5 rounded-lg uppercase tracking-wider border border-emerald-200/50">Completed</span>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

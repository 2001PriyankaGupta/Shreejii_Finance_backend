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

            <!-- Compact Stats Row (6 Cards) -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-10">
                <!-- Total Customers -->
                <a href="{{ route('admin.customers.index') }}" class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 group hover:shadow-lg hover:border-blue-200 transition-all duration-500">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#0346cbff] flex items-center justify-center border border-blue-100 transition-colors group-hover:bg-[#0346cbff] group-hover:text-white">
                            <i class="fa-solid fa-users text-sm"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-black text-slate-800 mb-1 tracking-tight">{{ \App\Models\User::where('role', 'CUSTOMER')->count() }}</h3>
                    <p class="text-slate-400 text-[8px] font-black uppercase tracking-wider">Customers</p>
                </a>

                <!-- Business Partners -->
                <a href="{{ route('admin.partners.index') }}" class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 group hover:shadow-lg hover:border-emerald-200 transition-all duration-500">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100 transition-colors group-hover:bg-emerald-600 group-hover:text-white">
                            <i class="fa-solid fa-handshake text-sm"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-black text-slate-800 mb-1 tracking-tight">{{ \App\Models\User::where('role', 'PARTNER')->count() }}</h3>
                    <p class="text-slate-400 text-[8px] font-black uppercase tracking-wider">Partners</p>
                </a>

                <!-- Operations Staff -->
                <a href="{{ route('admin.employees.index') }}" class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 group hover:shadow-lg hover:border-purple-200 transition-all duration-500">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center border border-purple-100 transition-colors group-hover:bg-purple-600 group-hover:text-white">
                            <i class="fa-solid fa-user-tie text-sm"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-black text-slate-800 mb-1 tracking-tight">{{ \App\Models\User::where('role', 'EMPLOYEE')->count() }}</h3>
                    <p class="text-slate-400 text-[8px] font-black uppercase tracking-wider">Employee</p>
                </a>

                <!-- Loan Payloads -->
                <a href="{{ route('admin.leads.index') }}" class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 group hover:shadow-lg hover:border-indigo-200 transition-all duration-500">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center border border-indigo-100 transition-colors group-hover:bg-indigo-600 group-hover:text-white">
                            <i class="fa-solid fa-file-invoice-dollar text-sm"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-black text-slate-800 mb-1 tracking-tight">{{ \App\Models\Loan::count() }}</h3>
                    <p class="text-slate-400 text-[8px] font-black uppercase tracking-wider">Loan Payloads</p>
                </a>

                <!-- Unread Messages -->
                <a href="{{ route('admin.messages.index') }}" class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 group hover:shadow-lg hover:border-rose-200 transition-all duration-500">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center border border-rose-100 transition-colors group-hover:bg-rose-500 group-hover:text-white">
                            <i class="fa-solid fa-comment-dots text-sm"></i>
                        </div>
                        @if($unreadCount > 0)
                            <span class="w-2 h-2 rounded-full bg-rose-500 animate-ping"></span>
                        @endif
                    </div>
                    <h3 class="text-xl font-black text-slate-800 mb-1 tracking-tight">{{ $unreadCount }}</h3>
                    <p class="text-slate-400 text-[8px] font-black uppercase tracking-wider">Messages</p>
                </a>

                <!-- Elite Protocol -->
                <a href="{{ route('admin.elite.index') }}" class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 group hover:shadow-lg hover:border-amber-200 transition-all duration-500">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center border border-amber-100 transition-colors group-hover:bg-amber-600 group-hover:text-white">
                            <i class="fa-solid fa-bolt-lightning text-sm"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-black text-slate-800 mb-1 tracking-tight">{{ \App\Models\EliteApplication::count() }}</h3>
                    <p class="text-slate-400 text-[8px] font-black uppercase tracking-wider">Elite</p>
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
                                Application Analytics
                            </h4>
                            <p class="text-sm text-slate-400 mt-2 font-medium">Growth performance over time</p>
                        </div>
                        <select class="px-4 py-2 bg-white border-transparent rounded-xl text-sm font-bold text-slate-600 shadow-sm focus:ring-[#0346cbff] focus:border-[#0346cbff] cursor-pointer">
                            <option>Last 7 Days</option>
                            <option>Last 30 Days</option>
                        </select>
                    </div>
                    <div class="h-80 bg-white/60 backdrop-blur-sm rounded-[2rem] p-6 border-2 border-slate-200 relative z-10 transition-all duration-500">
                        <canvas id="growthChart"></canvas>
                    </div>
                </div>

                <!-- Recent Activity Table -->
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
                            <p class="text-sm text-slate-400 mt-2 font-medium">Real-time application flow</p>
                        </div>
                        <a href="{{ route('admin.leads.index') }}" class="px-5 py-2.5 bg-white shadow-sm rounded-xl text-xs font-black text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all duration-300">VIEW ALL</a>
                    </div>
                    <div class="overflow-x-prevent relative z-10">
                        <div class="space-y-4">
                            @foreach(\App\Models\Loan::with('user')->latest()->take(3)->get() as $loan)
                            <div onclick="window.location='{{ route('admin.leads.show', $loan->id) }}'" class="bg-white/70 backdrop-blur-md p-5 rounded-3xl flex items-center justify-between hover:bg-white hover:scale-[1.02] transition-all duration-300 cursor-pointer shadow-sm group/row border border-transparent hover:border-indigo-100">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-black mr-4 uppercase text-sm">
                                        {{ substr($loan->customer_name ?? $loan->user->name ?? 'U', 0, 2) }}
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-900 leading-tight">{{ $loan->customer_name ?? $loan->user->name ?? 'Customer' }}</p>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wide">{{ $loan->loan_type }} • ₹{{ number_format($loan->loan_amount) }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    @php
                                        $colorClass = match($loan->status) {
                                            'APPROVED' => 'bg-emerald-100 text-emerald-600 border-emerald-200',
                                            'REJECTED' => 'bg-rose-100 text-rose-600 border-rose-200',
                                            'DISBURSED' => 'bg-blue-100 text-blue-600 border-blue-200',
                                            default => 'bg-amber-100 text-amber-600 border-amber-200',
                                        };
                                    @endphp
                                    <span class="px-3 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-wider {{ $colorClass }} border border-opacity-50">
                                        {{ $loan->status }}
                                    </span>
                                </div>
                            </div>
                            @endforeach

                            @if(\App\Models\Loan::count() == 0)
                                <div class="text-center py-10">
                                    <p class="text-slate-400 font-bold">No recent activity detected.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {
            const ctx = document.getElementById('growthChart').getContext('2d');
            
            // Logic to fetch last 7 days labels
            const labels = [];
            for (let i = 6; i >= 0; i--) {
                const date = new Date();
                date.setDate(date.getDate() - i);
                labels.push(date.toLocaleDateString('en-US', { weekday: 'short' }));
            }

            // Preparing Chart Data (Passed from Backend or simulated for smoothness)
            @php
                $loanData = [];
                $leadData = [];
                for($i = 6; $i >= 0; $i--) {
                    $date = now()->subDays($i)->format('Y-m-d');
                    $loanData[] = \App\Models\Loan::whereDate('created_at', $date)->count();
                    $leadData[] = \App\Models\Lead::whereDate('created_at', $date)->count();
                }
            @endphp

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Loans',
                        data: @json($loanData),
                        borderColor: '#0346cb',
                        backgroundColor: 'rgba(3, 70, 203, 0.1)',
                        borderWidth: 4,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#0346cb',
                        pointBorderWidth: 2,
                        pointRadius: 4
                    }, {
                        label: 'Leads',
                        data: @json($leadData),
                        borderColor: '#6366f1',
                        backgroundColor: 'rgba(99, 102, 241, 0.1)',
                        borderWidth: 4,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#6366f1',
                        pointBorderWidth: 2,
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                font: { weight: 'bold', family: 'Outfit' }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { display: false }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        });
    </script>
</x-admin-layout>

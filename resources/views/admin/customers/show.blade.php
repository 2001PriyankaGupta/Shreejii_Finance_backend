<x-admin-layout>
    <div class="py-6 bg-[#E2E8F0] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header with Back Button and Actions -->
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-6">
                <div>
                    <a href="{{ route('admin.customers.index') }}" class="inline-flex items-center px-4 py-2 bg-white text-slate-600 font-bold text-sm rounded-xl transition-all shadow-sm hover:bg-slate-50 border border-slate-200 group mb-4">
                        <svg class="w-4 h-4 mr-1 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back to Customer Desk
                    </a>
                    <h3 class="text-3xl font-black text-slate-900 tracking-tight flex items-center gap-4">
                        Customer Intelligence Node
                    </h3>
                    <p class="text-slate-500 font-medium mt-1 text-sm">Comprehensive profile of entity <span class="text-[#0346cbff] font-bold">{{ $customer->name }}</span></p>
                </div>
            </div>

            <!-- Main Content Area -->
            <div x-data="{ activeTab: 'overview' }" class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-10">
                
                <!-- Customer Profile Header -->
                <div class="p-6 sm:p-8 flex flex-col md:flex-row items-center justify-between gap-6 border-b border-slate-100">
                    <div class="flex flex-col md:flex-row items-center gap-6">
                        <div class="w-20 h-20 rounded-2xl bg-slate-100 text-[#0346cbff] flex items-center justify-center text-3xl font-black shrink-0 border border-slate-200 shadow-sm">
                            {{ strtoupper(substr($customer->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 text-center md:text-left">
                            <h3 class="text-2xl font-black text-slate-900">{{ $customer->name }}</h3>
                            <p class="text-sm font-medium text-slate-500 mb-3">ELITE MEMBER • <span class="uppercase tracking-widest text-[10px] font-black bg-slate-100 px-2 py-0.5 rounded text-slate-600">ID: CST-{{ sprintf('%06d', $customer->id) }}</span></p>
                            <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 text-sm font-medium text-slate-600">
                                <span class="flex items-center"><i class="fa-solid fa-mobile-screen mr-2 text-slate-400"></i> {{ $customer->phone }}</span>
                                <span class="flex items-center"><i class="fa-solid fa-envelope mr-2 text-slate-400"></i> {{ $customer->email }}</span>
                                <span class="flex items-center"><i class="fa-regular fa-calendar-check mr-2 text-slate-400"></i> Joined: {{ $customer->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                         <div class="bg-emerald-500/10 text-emerald-600 px-6 py-2 rounded-xl text-xs font-black uppercase tracking-widest border border-emerald-500/10 whitespace-nowrap">
                             Protocol: Active
                         </div>
                    </div>
                </div>

                <!-- Tabs Navigation -->
                <div class="px-6 sm:px-8 border-b border-slate-200 bg-slate-50/50">
                    <nav class="-mb-px flex space-x-8 overflow-x-auto" aria-label="Tabs">
                        <button @click="activeTab = 'overview'" :class="{'border-[#0346cbff] text-[#0346cbff]': activeTab === 'overview', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': activeTab !== 'overview'}" class="whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition-colors">
                            <i class="fa-solid fa-layer-group mr-2"></i> Overview
                        </button>
                        <button @click="activeTab = 'loans'" :class="{'border-[#0346cbff] text-[#0346cbff]': activeTab === 'loans', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': activeTab !== 'loans'}" class="whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition-colors">
                            <i class="fa-solid fa-file-invoice-dollar mr-2"></i> Loan History ({{ $customer->loans->count() }})
                        </button>
                    </nav>
                </div>

                <!-- Tab Contents -->
                <div class="p-6 sm:p-8 bg-slate-50/30 min-h-[400px]">
                    
                    <!-- Overview Tab -->
                    <div x-show="activeTab === 'overview'" x-transition.opacity.duration.300ms class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Entity Statistics -->
                        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                            <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4 flex items-center">
                                <i class="fa-solid fa-chart-pie mr-2 text-slate-300"></i> Portfolio Insight
                            </h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 text-center">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Loans</p>
                                    <p class="text-2xl font-black text-[#0346cbff]">{{ $customer->loans->count() }}</p>
                                </div>
                                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 text-center">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Leads</p>
                                    <p class="text-2xl font-black text-indigo-600">{{ $customer->leads->count() }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- System Security -->
                        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                             <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4 flex items-center">
                                <i class="fa-solid fa-shield-halved mr-2 text-slate-300"></i> Compliance & Trust
                            </h4>
                            <div class="flex items-start mb-6">
                                <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-500 border border-blue-100 flex items-center justify-center mr-3 shrink-0">
                                    <i class="fa-solid fa-fingerprint"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800">Identity Verified</p>
                                    <p class="text-xs font-medium text-slate-500 mt-1 leading-relaxed">This entity has passed the secondary biometric and KYC protocol validation stages.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Communication Log -->
                        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm md:col-span-2">
                             <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4 flex items-center">
                                <i class="fa-solid fa-address-book mr-2 text-slate-300"></i> System Coordinates
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Primary Phone</p>
                                    <p class="text-sm font-bold text-slate-800">{{ $customer->phone }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Email Endpoint</p>
                                    <p class="text-sm font-bold text-slate-800">{{ $customer->email }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Permanent Location</p>
                                    <p class="text-sm font-bold text-slate-800">{{ $customer->address ?? 'NOT_MAPPED' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Loans Tab -->
                    <div x-show="activeTab === 'loans'" x-transition.opacity.duration.300ms style="display: none;" class="space-y-6">
                        @forelse($customer->loans as $loan)
                            <div x-data="{ open: false }" class="bg-white rounded-[2rem] border border-slate-200 overflow-hidden shadow-sm hover:shadow-xl hover:shadow-blue-50/50 transition-all group">
                                <!-- Top Status Bar (Always Visible) -->
                                <div class="px-8 py-5 bg-slate-50 border-b border-slate-100 flex flex-wrap items-center justify-between gap-6 cursor-pointer" @click="open = !open">
                                    <div class="flex items-center gap-6">
                                         <div class="w-12 h-12 rounded-2xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 group-hover:text-[#0346cbff] transition-all">
                                             <i class="fa-solid fa-chevron-right transition-transform" :class="open ? 'rotate-90 text-[#0346cbff]' : ''"></i>
                                         </div>
                                         <div class="space-y-1">
                                            <div class="flex items-center gap-3">
                                                <span class="text-xs font-black text-slate-900 uppercase tracking-widest">Node ID: #LN-{{ $loan->id }}</span>
                                                <span class="px-3 py-0.5 bg-blue-100 text-[#0346cbff] rounded-md text-[9px] font-black uppercase tracking-widest">{{ $loan->loan_type }}</span>
                                            </div>
                                            <p class="text-xl font-black text-slate-900">₹{{ number_format($loan->loan_amount) }} <span class="text-xs text-slate-400 font-bold ml-1 uppercase">Principal</span></p>
                                         </div>
                                    </div>

                                    <div class="flex items-center gap-8">
                                        <div class="text-right hidden sm:block border-r border-slate-200 pr-8">
                                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Phase Log</p>
                                            <span class="px-4 py-1.5 {{ $loan->status == 'APPROVED' ? 'bg-emerald-500 text-white' : ($loan->status == 'REJECTED' ? 'bg-rose-500 text-white' : 'bg-amber-400 text-white') }} rounded-xl text-[10px] font-black uppercase tracking-widest mt-1 inline-block shadow-sm">
                                                {{ $loan->status }}
                                            </span>
                                        </div>

                                        <!-- Status Control Console -->
                                        <form action="{{ route('admin.loans.updateStatus', $loan->id) }}" method="POST" class="flex items-center gap-3" @click.stop>
                                            @csrf
                                            @method('PATCH')
                                            <div class="flex flex-col">
                                                <label class="text-[8px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-1">Control Console</label>
                                                <select name="status" onchange="this.form.submit()" class="bg-white border-slate-200 text-slate-700 text-[10px] font-black uppercase tracking-widest rounded-xl focus:ring-[#0346cbff] focus:border-[#0346cbff] h-9 px-3 min-w-[140px] shadow-inner">
                                                    <option value="PENDING" {{ $loan->status == 'PENDING' ? 'selected' : '' }}>PENDING</option>
                                                    <option value="APPROVED" {{ $loan->status == 'APPROVED' ? 'selected' : '' }}>APPROVE</option>
                                                    <option value="REJECTED" {{ $loan->status == 'REJECTED' ? 'selected' : '' }}>REJECT</option>
                                                    <option value="DISBURSED" {{ $loan->status == 'DISBURSED' ? 'selected' : '' }}>DISBURSE</option>
                                                </select>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Collapsible Technical Dossier -->
                                <div x-show="open" x-collapse x-cloak>
                                    <div class="p-8 bg-white">
                                        <!-- Core Metrics Grid -->
                                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                                            <div class="p-5 bg-slate-50/50 rounded-3xl border border-slate-100 flex items-center gap-4">
                                                <div class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center text-slate-400"><i class="fa-solid fa-clock"></i></div>
                                                <div>
                                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Tenure</p>
                                                    <p class="text-sm font-black text-slate-900">{{ $loan->tenure }} Years</p>
                                                </div>
                                            </div>
                                            <div class="p-5 bg-slate-50/50 rounded-3xl border border-slate-100 flex items-center gap-4">
                                                <div class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center text-slate-400"><i class="fa-solid fa-briefcase"></i></div>
                                                <div>
                                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Employment</p>
                                                    <p class="text-sm font-black text-slate-900 uppercase truncate max-w-[120px]">{{ $loan->employment_status ?: 'UNKN_NODE' }}</p>
                                                </div>
                                            </div>
                                            <div class="p-5 bg-slate-50/50 rounded-3xl border border-slate-100 flex items-center gap-4">
                                                <div class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center text-slate-400"><i class="fa-solid fa-calendar-day"></i></div>
                                                <div>
                                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Logged On</p>
                                                    <p class="text-sm font-black text-slate-900">{{ $loan->created_at->format('d M / Y') }}</p>
                                                </div>
                                            </div>
                                            <div class="p-5 bg-slate-50/50 rounded-3xl border border-slate-100 flex items-center gap-4">
                                                <div class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center text-slate-400"><i class="fa-solid fa-microchip"></i></div>
                                                <div>
                                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Employer Node</p>
                                                    <p class="text-sm font-black text-[#0346cbff] uppercase truncate max-w-[120px]">{{ $loan->employer_name ?: 'N/A' }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Technical Parameters Matrix -->
                                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 p-8 bg-slate-900 rounded-[2.5rem] mb-8 shadow-2xl shadow-indigo-100 flex items-center">
                                            <div class="md:col-span-1 border-r border-slate-800 pr-6">
                                                <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">Yield Node</p>
                                                <p class="text-xl font-black text-white">₹{{ number_format($loan->monthly_income) }}</p>
                                            </div>
                                            <div class="border-r border-slate-800 pr-6">
                                                 <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">Debt Load</p>
                                                 <p class="text-xl font-black text-white">₹{{ number_format($loan->existing_emis ?? 0) }}</p>
                                            </div>
                                            <div class="border-r border-slate-800 pr-6">
                                                <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">PAN Signature</p>
                                                <p class="text-sm font-black text-indigo-400 uppercase tracking-widest">{{ $loan->pan_number }}</p>
                                            </div>
                                            <div class="border-r border-slate-800 pr-6">
                                                <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">Aadhaar Identifer</p>
                                                <p class="text-sm font-black text-emerald-400">{{ $loan->aadhaar_number }}</p>
                                            </div>
                                            <div>
                                                <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">City Node</p>
                                                <p class="text-sm font-black text-white uppercase">{{ $loan->city ?? $loan->current_city ?? 'GLOBAL' }}</p>
                                            </div>
                                        </div>

                                        <!-- Secure Payload Assets -->
                                        <div class="pt-4">
                                            <h5 class="text-[10px] font-black text-slate-900 uppercase tracking-[4px] mb-6 flex items-center gap-3">
                                                <i class="fa-solid fa-shield-virus text-emerald-500"></i> Secure Payload Vault
                                            </h5>
                                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                                                @php 
                                                    $docs = [
                                                        ['key' => 'pan_image', 'label' => 'PAN CARD', 'icon' => 'fa-id-card', 'color' => 'blue'],
                                                        ['key' => 'aadhaar_front_image', 'label' => 'AADHAAR F', 'icon' => 'fa-passport', 'color' => 'indigo'],
                                                        ['key' => 'aadhaar_back_image', 'label' => 'AADHAAR B', 'icon' => 'fa-address-card', 'color' => 'indigo'],
                                                        ['key' => 'bank_statement', 'label' => 'STATEMENTS', 'icon' => 'fa-building-columns', 'color' => 'emerald'],
                                                    ];
                                                @endphp
                                                @foreach($docs as $doc)
                                                    @if($loan->{$doc['key']})
                                                        <a href="{{ asset('storage/' . $loan->{$doc['key']}) }}" target="_blank" class="p-5 bg-white border border-slate-200 rounded-3xl flex items-center gap-5 hover:border-slate-900 hover:shadow-2xl hover:-translate-y-1 transition-all group/asset">
                                                            <div class="w-14 h-14 rounded-2xl bg-{{ $doc['color'] }}-50 flex items-center justify-center text-{{ $doc['color'] }}-600 group-hover/asset:bg-slate-900 group-hover/asset:text-white transition-all shadow-sm">
                                                                <i class="fa-solid {{ $doc['icon'] }} text-2xl"></i>
                                                            </div>
                                                            <div class="overflow-hidden">
                                                                <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-0.5">{{ $doc['label'] }}</p>
                                                                <p class="text-[10px] font-black text-slate-900 uppercase tracking-tighter">VIEW_PAYLOAD</p>
                                                            </div>
                                                        </a>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="py-32 text-center bg-white rounded-[3rem] border border-slate-200 border-dashed">
                                 <div class="w-24 h-24 rounded-full bg-slate-50 flex items-center justify-center mx-auto mb-8 border border-slate-100 shadow-inner">
                                     <i class="fa-solid fa-ban text-slate-200 text-4xl"></i>
                                 </div>
                                 <p class="text-slate-500 font-black uppercase tracking-[3px] text-sm">Matrix Exception: Empty Node Dataset</p>
                                 <p class="text-slate-400 text-xs font-medium mt-3">No loan records have been linked to this entity ID.</p>
                            </div>
                        @endforelse
                    </div>

                </div>
            </div>
            </div>
        </div>
    </div>
</x-admin-layout>

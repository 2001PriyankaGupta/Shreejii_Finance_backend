<x-admin-layout>
    <div class="py-6 bg-[#E2E8F0] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header with Back Button and Actions -->
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-6">
                <div>
                    <a href="{{ route('admin.partners.index') }}" class="inline-flex items-center px-4 py-2 bg-white text-slate-600 font-bold text-sm rounded-xl transition-all shadow-sm hover:bg-slate-50 border border-slate-200 group mb-4">
                        <svg class="w-4 h-4 mr-1 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back to Verification Desk
                    </a>
                    <h3 class="text-3xl font-black text-slate-900 tracking-tight flex items-center gap-4">
                        Partner Dashboard
                    </h3>
                    <p class="text-slate-500 font-medium mt-1 text-sm">Detailed overview of partner node <span class="text-[#0346cbff] font-bold">{{ $partner->employeeDetail->business_name ?? 'N/A' }}</span></p>
                </div>
            </div>

            <!-- Main Content Area -->
            <div x-data="{ activeTab: 'overview' }" class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-10">
                
                <!-- Partner Profile Header -->
                <div class="p-6 sm:p-8 flex flex-col md:flex-row items-center justify-between gap-6 border-b border-slate-100">
                    <div class="flex flex-col md:flex-row items-center gap-6">
                        <div class="w-20 h-20 rounded-2xl bg-slate-100 text-[#0346cbff] flex items-center justify-center text-3xl font-black shrink-0 border border-slate-200 shadow-sm">
                            {{ strtoupper(substr($partner->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 text-center md:text-left">
                            <h3 class="text-2xl font-black text-slate-900">{{ $partner->name }}</h3>
                            <p class="text-sm font-medium text-slate-500 mb-3">{{ $partner->employeeDetail->business_name ?? 'N/A' }} • <span class="uppercase tracking-widest text-[10px] font-black bg-slate-100 px-2 py-0.5 rounded text-slate-600">ID: PARTNER-{{ sprintf('%06d', $partner->id) }}</span></p>
                            <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 text-sm font-medium text-slate-600">
                                <span class="flex items-center"><i class="fa-solid fa-mobile-screen mr-2 text-slate-400"></i> {{ $partner->phone }}</span>
                                <span class="flex items-center"><i class="fa-regular fa-calendar-check mr-2 text-slate-400"></i> Joined: {{ $partner->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Status Dropdown Action -->
                    <div class="flex items-center gap-4 relative" x-data="{ open: false }">
                        <div class="relative">
                            <button @click="open = !open" class="flex items-center gap-3 px-5 py-2.5 bg-white border border-slate-200 shadow-sm rounded-xl hover:bg-slate-50 transition-colors">
                                <span class="text-xs font-black tracking-widest uppercase text-slate-500">Node Status:</span>
                                @if($partner->status === 'APPROVED')
                                    <span class="px-3 py-1 rounded-md text-xs font-black tracking-widest uppercase bg-emerald-100 text-emerald-700 leading-none">Approved</span>
                                @elseif($partner->status === 'REJECTED')
                                    <span class="px-3 py-1 rounded-md text-xs font-black tracking-widest uppercase bg-rose-100 text-rose-700 leading-none">Rejected</span>
                                @else
                                    <span class="px-3 py-1 rounded-md text-xs font-black tracking-widest uppercase bg-amber-100 text-amber-700 leading-none animate-pulse">Pending</span>
                                @endif
                                <i class="fa-solid fa-chevron-down text-slate-400 text-xs ml-1 transition-transform" :class="{'rotate-180': open}"></i>
                            </button>

                            <div x-show="open" @click.away="open = false" style="display: none;" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl shadow-slate-200/50 border border-slate-100 py-2 z-50">
                                <form action="{{ route('admin.partners.approve', $partner->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm font-bold text-emerald-600 hover:bg-emerald-50 transition-colors flex items-center">
                                        <i class="fa-solid fa-check w-5 text-center mr-2"></i> Approve Node
                                    </button>
                                </form>
                                <form action="{{ route('admin.partners.reject', $partner->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm font-bold text-rose-600 hover:bg-rose-50 transition-colors flex items-center">
                                        <i class="fa-solid fa-xmark w-5 text-center mr-2"></i> Reject Node
                                    </button>
                                </form>
                                <form action="{{ route('admin.partners.pending', $partner->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm font-bold text-amber-600 hover:bg-amber-50 transition-colors flex items-center border-t border-slate-50 mt-1 pt-2">
                                        <i class="fa-solid fa-clock w-5 text-center mr-2"></i> Mark as Pending
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabs Navigation -->
                <div class="px-6 sm:px-8 border-b border-slate-200 bg-slate-50/50">
                    <nav class="-mb-px flex space-x-8 overflow-x-auto" aria-label="Tabs">
                        <button @click="activeTab = 'overview'" :class="{'border-[#0346cbff] text-[#0346cbff]': activeTab === 'overview', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': activeTab !== 'overview'}" class="whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition-colors">
                            <i class="fa-solid fa-layer-group mr-2"></i> Overview
                        </button>
                        <button @click="activeTab = 'banking'" :class="{'border-[#0346cbff] text-[#0346cbff]': activeTab === 'banking', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': activeTab !== 'banking'}" class="whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition-colors">
                            <i class="fa-solid fa-building-columns mr-2"></i> Node Finance
                        </button>
                        <button @click="activeTab = 'documents'" :class="{'border-[#0346cbff] text-[#0346cbff]': activeTab === 'documents', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': activeTab !== 'documents'}" class="whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition-colors">
                            <i class="fa-solid fa-file-shield mr-2"></i> Documents
                        </button>
                    </nav>
                </div>

                <!-- Tab Contents -->
                <div class="p-6 sm:p-8 bg-slate-50/30 min-h-[400px]">
                    
                    <!-- Overview Tab -->
                    <div x-show="activeTab === 'overview'" x-transition.opacity.duration.300ms class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Trust Contacts -->
                        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                            <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4 flex items-center">
                                <i class="fa-solid fa-users mr-2 text-slate-300"></i> Trust Contacts
                            </h4>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl border border-slate-100">
                                    <div>
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Terminal 1</p>
                                        <p class="font-bold text-slate-800">{{ $partner->employeeDetail->reference_1_name ?? 'N/A' }}</p>
                                    </div>
                                    <a href="tel:{{ collect($partner->employeeDetail)->get('reference_1_phone') }}" class="text-slate-600 bg-white border border-slate-200 px-3 py-1.5 rounded-lg text-sm font-bold hover:bg-slate-50 transition-colors shadow-sm">
                                        <i class="fa-solid fa-phone mr-1 text-slate-400"></i> {{ $partner->employeeDetail->reference_1_phone ?? 'N/A' }}
                                    </a>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl border border-slate-100">
                                    <div>
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Terminal 2</p>
                                        <p class="font-bold text-slate-800">{{ $partner->employeeDetail->reference_2_name ?? 'N/A' }}</p>
                                    </div>
                                    <a href="tel:{{ collect($partner->employeeDetail)->get('reference_2_phone') }}" class="text-slate-600 bg-white border border-slate-200 px-3 py-1.5 rounded-lg text-sm font-bold hover:bg-slate-50 transition-colors shadow-sm">
                                        <i class="fa-solid fa-phone mr-1 text-slate-400"></i> {{ $partner->employeeDetail->reference_2_phone ?? 'N/A' }}
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Financial Performance -->
                        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                             <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4 flex items-center">
                                <i class="fa-solid fa-wallet mr-2 text-slate-300"></i> Financial Performance
                            </h4>
                            <div class="p-5 bg-indigo-50 rounded-2xl border border-indigo-100 mb-6">
                                <p class="text-[10px] font-black text-indigo-400 uppercase tracking-widest">Aggregate Commission</p>
                                <p class="text-3xl font-black text-indigo-700">₹{{ number_format(\App\Models\WalletTransaction::where('user_id', $partner->id)->where('type', 'CREDIT')->sum('amount'), 2) }}</p>
                            </div>
                            
                            <h5 class="text-[9px] font-black text-slate-400 uppercase mb-3">Recent Payouts</h5>
                            <div class="space-y-3">
                                @php 
                                    $payouts = \App\Models\WalletTransaction::where('user_id', $partner->id)
                                        ->where('type', 'CREDIT')
                                        ->latest()
                                        ->limit(3)
                                        ->get();
                                @endphp
                                @foreach($payouts as $px)
                                    <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl border border-slate-100">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-white border border-slate-100 flex items-center justify-center text-xs text-emerald-500"><i class="fa-solid fa-plus"></i></div>
                                            <div>
                                                <p class="text-[10px] font-black uppercase text-slate-400">Lead #{{ $px->description }}</p>
                                                <p class="text-[11px] font-bold text-slate-700">{{ $px->created_at->format('d M, Y') }}</p>
                                            </div>
                                        </div>
                                        <p class="text-sm font-black text-indigo-600">₹{{ number_format($px->amount, 0) }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Compliance -->
                        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                             <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4 flex items-center">
                                <i class="fa-solid fa-shield-halved mr-2 text-slate-300"></i> Compliance Status
                            </h4>
                            <div class="flex items-start mb-6">
                                <div class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-500 border border-emerald-100 flex items-center justify-center mr-3 shrink-0">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800">Verified by System</p>
                                    <p class="text-xs font-medium text-slate-500 mt-1 leading-relaxed">Partner nodes are required to undergo routine audits to maintain their active status on the network.</p>
                                </div>
                            </div>
                            <div class="pt-4 border-t border-slate-100 space-y-2">
                                 <button class="w-full text-left text-sm font-bold text-slate-600 hover:text-slate-900 bg-slate-50 hover:bg-slate-100 px-4 py-3 border border-slate-100 rounded-xl transition-colors flex items-center justify-between">
                                     <span><i class="fa-solid fa-file-contract mr-2 text-slate-400"></i> View Node Agreements</span>
                                     <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
                                 </button>
                                 <button class="w-full text-left text-sm font-bold text-slate-600 hover:text-slate-900 bg-slate-50 hover:bg-slate-100 px-4 py-3 border border-slate-100 rounded-xl transition-colors flex items-center justify-between">
                                     <span><i class="fa-solid fa-chart-line mr-2 text-slate-400"></i> Active Audit Logs</span>
                                     <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
                                 </button>
                            </div>
                        </div>
                    </div>

                    <!-- Banking Tab -->
                    <div x-show="activeTab === 'banking'" x-transition.opacity.duration.300ms style="display: none;" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm">
                        <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6 flex items-center">
                            <i class="fa-solid fa-building-columns mr-2 text-slate-300"></i> Settlement Account Information
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                             <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
                                 <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Account Holder</p>
                                 <p class="text-base font-bold text-slate-800">{{ $partner->employeeDetail->account_holder ?? 'N/A' }}</p>
                             </div>
                             <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
                                 <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Primary Bank</p>
                                 <p class="text-base font-bold text-slate-800">{{ $partner->employeeDetail->bank_name ?? 'N/A' }}</p>
                             </div>
                             <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
                                 <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">IFSC CODE</p>
                                 <p class="text-base font-bold text-slate-800 uppercase">{{ $partner->employeeDetail->ifsc_code ?? 'N/A' }}</p>
                             </div>
                             <div class="p-5 bg-slate-50 rounded-xl border border-slate-200 md:col-span-2 lg:col-span-3 flex items-center justify-between">
                                 <div>
                                     <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Account Number</p>
                                     <p class="text-xl font-mono font-black text-slate-800 tracking-widest">{{ $partner->employeeDetail->account_number ?? 'XXXX XXXX XXXX' }}</p>
                                 </div>
                                 <div class="w-10 h-10 bg-white border border-slate-200 rounded-lg text-slate-400 flex items-center justify-center shadow-sm">
                                     <i class="fa-solid fa-lock text-sm"></i>
                                 </div>
                             </div>
                        </div>
                    </div>

                    <!-- Documents Tab -->
                    <div x-show="activeTab === 'documents'" x-transition.opacity.duration.300ms style="display: none;" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm">
                        <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6 flex items-center">
                            <i class="fa-solid fa-file-shield mr-2 text-slate-300"></i> Verified Documents
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @php
                                $documents = [
                                    ['type' => 'PAN Identity', 'field' => 'pan_identity', 'icon' => 'fa-id-card'],
                                    ['type' => 'Aadhaar Front', 'field' => 'aadhaar_front', 'icon' => 'fa-address-card'],
                                    ['type' => 'Aadhaar Back', 'field' => 'aadhaar_back', 'icon' => 'fa-address-card'],
                                    ['type' => 'Live Handshake', 'field' => 'live_handshake', 'icon' => 'fa-handshake'],
                                    ['type' => 'Business Identity', 'field' => 'business_identity', 'icon' => 'fa-building'],
                                    ['type' => 'Banking Proof', 'field' => 'banking_proof', 'icon' => 'fa-money-check'],
                                ];
                                $hasDocs = false;
                            @endphp

                            @foreach($documents as $doc)
                                @if(!empty($partner->employeeDetail->{$doc['field']}))
                                    @php $hasDocs = true; @endphp
                                    <div class="p-3 bg-white border border-slate-200 rounded-xl hover:border-slate-300 hover:shadow-sm transition-all flex items-center justify-between group">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-lg bg-slate-50 border border-slate-100 text-slate-500 flex items-center justify-center mr-3 group-hover:text-[#0346cbff] transition-colors">
                                                <i class="fa-solid {{ $doc['icon'] }}"></i>
                                            </div>
                                            <div>
                                                <p class="font-bold text-slate-800 text-sm">{{ $doc['type'] }}</p>
                                                <p class="text-[9px] font-black text-emerald-500 uppercase tracking-widest mt-0.5"><i class="fa-solid fa-check mr-0.5"></i> Verified</p>
                                            </div>
                                        </div>
                                        <div class="flex space-x-2">
                                            <a href="{{ asset('storage/' . $partner->employeeDetail->{$doc['field']}) }}" target="_blank" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-slate-700 bg-slate-50 border border-slate-200 rounded-lg hover:bg-slate-100 transition-all shadow-sm">
                                                <i class="fa-solid fa-eye text-xs"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                            @if(!$hasDocs)
                                <div class="col-span-full py-10 text-center bg-slate-50 rounded-xl border border-slate-200 border-dashed">
                                    <div class="w-10 h-10 bg-white border border-slate-200 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-400 shadow-sm">
                                        <i class="fa-regular fa-folder-open text-xs"></i>
                                    </div>
                                    <p class="text-slate-500 font-medium text-sm">No verified documents found.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
            </div>
        </div>
    </div>
</x-admin-layout>

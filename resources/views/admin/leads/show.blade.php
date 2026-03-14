<x-admin-layout>


    <div class="space-y-8 max-w-7xl mx-auto p-7">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-black text-gray-700">Lead Payload Detail</h1>
            <!-- BACK BOTTON -->
            <a href="{{ route('admin.leads.index') }}" class="inline-flex items-center text-[10px] font-black uppercase tracking-widest text-[#0346cbff] hover:text-[#0F172A] transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Pipeline
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Lead Info -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Main Identity Card -->
                <div class="bg-white rounded-[2.5rem] shadow-xl overflow-hidden border border-gray-100">
                    <div class="p-6 bg-gradient-to-br from-[#0F172A] to-[#1e293b] text-white">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                            <div class="flex items-center gap-6">
                                <div class="w-20 h-20 rounded-3xl bg-white/10 backdrop-blur-xl border border-white/20 flex items-center justify-center text-3xl font-black">
                                    {{ $lead->customer_name[0] }}
                                </div>
                                <div>
                                    <h1 class="text-3xl font-black uppercase tracking-tight">{{ $lead->customer_name }}</h1>
                                    <div class="flex items-center gap-3 mt-2">
                                        <span class="px-3 py-1 bg-white/10 rounded-lg text-[10px] font-black uppercase tracking-widest">{{ $lead->loan_type }}</span>
                                        <span class="text-white/50 text-[10px] font-black uppercase tracking-widest">ID: #{{ $lead->id }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white/10 backdrop-blur-md px-6 py-3 rounded-2xl border border-white/20">
                                @php
                                    $statusColor = [
                                        'OPEN' => 'text-blue-400',
                                        'PENDING' => 'text-amber-400',
                                        'APPROVED' => 'text-emerald-400',
                                        'REJECTED' => 'text-rose-400',
                                    ][$lead->status] ?? 'text-gray-400';
                                @endphp
                                <p class="text-[10px] font-black uppercase tracking-widest text-white/50 mb-1">Status Protocol</p>
                                <p class="text-xl font-black uppercase {{ $statusColor }}">{{ $lead->status }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-10 grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div>
                            <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-6 border-b border-gray-50 pb-2">Identity Nodes</h3>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest">Mobile Sequence</p>
                                    <p class="text-lg font-bold text-gray-700">{{ $lead->mobile_number }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest">City Node</p>
                                    <p class="text-lg font-bold text-gray-700">{{ $lead->city }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest">PAN Number</p>
                                    <p class="text-lg font-bold text-gray-700">{{ $lead->pan_number ?: 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest">Aadhaar Sequence</p>
                                    <p class="text-lg font-bold text-gray-700">{{ $lead->aadhaar_number ?: 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-6 border-b border-gray-50 pb-2">Financial Nodes</h3>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest">Monthly Yield (Income)</p>
                                    <p class="text-2xl font-black text-[#0346cbff]">₹{{ number_format($lead->monthly_yield, 2) }}</p>
                                </div>
                                @if($lead->disbursed_amount)
                                <div>
                                    <p class="text-[10px] font-black text-emerald-400 uppercase tracking-widest">Disbursed Token Value</p>
                                    <p class="text-2xl font-black text-emerald-600">₹{{ number_format($lead->disbursed_amount, 2) }}</p>
                                    <p class="text-[9px] font-bold text-gray-400 mt-1 uppercase">Tenure: {{ $lead->tenure_months }} Months</p>
                                </div>
                                @endif
                                <div>
                                    <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest">Logged By (Agent)</p>
                                    <p class="text-lg font-bold text-gray-700 flex items-center gap-2">
                                        {{ $lead->user->name ?? 'SYSTEM NODE' }}
                                        <span class="text-[8px] px-2 py-0.5 bg-slate-100 rounded text-slate-400">{{ $lead->user->role ?? '' }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- NEW: Commission Details Section -->
                @if($lead->status == 'APPROVED')
                <div class="bg-indigo-900 rounded-[2.5rem] shadow-xl overflow-hidden border border-indigo-700 p-8 text-white relative">
                     <div class="absolute top-0 right-0 p-8 opacity-10">
                        <i class="fa-solid fa-wallet text-8xl"></i>
                     </div>
                     <h3 class="text-lg font-black uppercase tracking-tight mb-6">Commission Protocol</h3>
                     @php 
                        $tx = \App\Models\WalletTransaction::where('description', $lead->id)->first();
                     @endphp
                     <div class="grid grid-cols-1 md:grid-cols-2 gap-8 relative z-10">
                        <div class="bg-white/5 backdrop-blur-sm p-6 rounded-3xl border border-white/10">
                            <p class="text-[10px] font-black text-indigo-300 uppercase tracking-widest mb-2">Agent Earnings</p>
                            <p class="text-4xl font-black text-indigo-400">₹{{ $tx ? number_format($tx->amount, 2) : '0.00' }}</p>
                            <div class="mt-4 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                <span class="text-[10px] font-black uppercase tracking-widest opacity-60">Status: {{ $tx->status ?? 'NOT_GENERATED' }}</span>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <p class="text-[10px] font-black text-indigo-300 uppercase tracking-widest">Settlement Log</p>
                                <p class="text-sm font-bold text-white/80 mt-1">
                                    Commission credited to wallet on {{ $tx ? $tx->created_at->format('d M, Y H:i') : 'N/A' }}.
                                    This amount is available for agent withdrawal request.
                                </p>
                            </div>
                            <div class="flex gap-4">
                                <div class="px-4 py-2 bg-indigo-800/50 rounded-xl border border-indigo-700">
                                    <p class="text-[8px] font-black text-indigo-300 uppercase mb-0.5">Type</p>
                                    <p class="text-[10px] font-black uppercase">Direct Payout</p>
                                </div>
                                <div class="px-4 py-2 bg-indigo-800/50 rounded-xl border border-indigo-700">
                                    <p class="text-[8px] font-black text-indigo-300 uppercase mb-0.5">Reference</p>
                                    <p class="text-[10px] font-black uppercase">TXN-{{ $tx->id ?? 'XXXX' }}</p>
                                </div>
                            </div>
                        </div>
                     </div>
                </div>
                @endif

                <!-- Asset Metadata -->
                @if($lead->vehicle_make)
                <div class="bg-white rounded-[2.5rem] shadow-xl overflow-hidden border border-gray-100">
                    <div class="p-8 border-b border-gray-50 flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                            <i class="fa-solid fa-car text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-gray-800 uppercase tracking-tight">Asset Metadata</h3>
                            <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">Property Token Details</p>
                        </div>
                    </div>
                    <div class="p-10 grid grid-cols-2 lg:grid-cols-4 gap-8">
                        <div>
                            <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest">Make / Brand</p>
                            <p class="text-sm font-black text-gray-700 uppercase">{{ $lead->vehicle_make }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest">Model Node</p>
                            <p class="text-sm font-black text-gray-700 uppercase">{{ $lead->vehicle_model }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest">MFG Year</p>
                            <p class="text-sm font-black text-gray-700 capitalize">{{ $lead->mfg_year }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest">Fuel Protocol</p>
                            <p class="text-sm font-black text-gray-700 capitalize">{{ $lead->fuel_type }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest">Asset Value</p>
                            <p class="text-lg font-black text-emerald-600">₹{{ number_format($lead->asset_value, 2) }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Document Vault -->
                <div class="bg-white rounded-[2.5rem] shadow-xl overflow-hidden border border-gray-100 p-8">
                     <h3 class="text-lg font-black text-gray-800 uppercase tracking-tight mb-8">Document Vault</h3>
                     <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                        @if($lead->documents)
                            @foreach($lead->documents as $key => $doc)
                                <div class="group relative aspect-video bg-gray-50 rounded-2xl overflow-hidden border border-gray-100 hover:shadow-lg transition-all">
                                    <img src="{{ asset($doc['uri'] ?? $doc) }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
                                        <a href="{{ asset($doc['uri'] ?? $doc) }}" target="_blank" class="bg-white text-black text-[10px] font-black px-4 py-2 rounded-lg uppercase tracking-widest">View Full Node</a>
                                    </div>
                                    <div class="absolute bottom-3 left-3 px-2 py-1 bg-white/90 backdrop-blur rounded-md text-[8px] font-black uppercase tracking-widest text-gray-600">
                                        {{ str_replace('_', ' ', $key) }}
                                    </div>
                                </div>
                            @endforeach
                        @endif
                     </div>
                </div>
            </div>

            <!-- Right Column: Status Portal -->
            <div class="space-y-8">
                <div class="bg-white rounded-[2.5rem] shadow-xl overflow-hidden border border-gray-100 p-8 sticky top-8">
                    <h3 class="text-lg font-black text-gray-800 uppercase tracking-tight mb-2">Decision Portal</h3>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-8">Override Session Status</p>

                    <form action="{{ route('admin.leads.updateStatus', $lead) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PATCH')
                        
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-4 ml-2">Protocol Command</label>
                                    <div class="space-y-2">
                                        @foreach(['OPEN', 'PENDING', 'APPROVED', 'REJECTED'] as $status)
                                            <label class="flex items-center p-4 bg-gray-50 rounded-2xl cursor-pointer border border-transparent hover:border-[#0346cbff] transition-all group">
                                                <input type="radio" name="status" value="{{ $status }}" {{ $lead->status == $status ? 'checked' : '' }} class="hidden peer" onchange="toggleDisbursementFields(this.value)">
                                                <div class="w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center peer-checked:border-[#0346cbff] transition-all">
                                                    <div class="w-2.5 h-2.5 rounded-full bg-[#0346cbff] scale-0 peer-checked:scale-100 transition-transform"></div>
                                                </div>
                                                <span class="ml-4 font-black text-xs uppercase tracking-widest text-gray-500 peer-checked:text-[#0346cbff] transition-colors">{{ $status }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div id="disbursementFields" class="{{ $lead->status == 'APPROVED' ? '' : 'hidden' }} space-y-4 pt-4 border-t border-gray-50 mt-4">
                                    <div>
                                        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-2">Disbursed Amount (₹)</label>
                                        <input type="number" name="disbursed_amount" value="{{ $lead->disbursed_amount }}" placeholder="Enter actual loan amount" class="w-full bg-gray-50 border-gray-200 rounded-xl py-3 px-4 font-bold text-gray-700 focus:ring-[#0346cbff] focus:border-[#0346cbff]">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-2">Tenure (Months)</label>
                                        <input type="number" name="tenure_months" value="{{ $lead->tenure_months }}" placeholder="Loan duration" class="w-full bg-gray-50 border-gray-200 rounded-xl py-3 px-4 font-bold text-gray-700 focus:ring-[#0346cbff] focus:border-[#0346cbff]">
                                    </div>
                                    @if($lead->status != 'APPROVED')
                                    <div>
                                        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-2">Commission (₹) - OPTIONAL</label>
                                        <input type="number" name="commission_override" placeholder="Override standard commission" class="w-full bg-indigo-50 border-indigo-100 rounded-xl py-3 px-4 font-bold text-indigo-700 focus:ring-[#0346cbff] focus:border-[#0346cbff]">
                                        <p class="text-[8px] font-bold text-indigo-400 mt-1 ml-2 italic">Standard: {{ match(strtoupper($lead->loan_type)) { 'PERSONAL' => '₹1500', 'HOME' => '₹5000', 'VEHICLE' => '₹2000', 'BUSINESS' => '₹3000', default => '₹1000' } }}</p>
                                    </div>
                                    @endif
                                </div>

                        <button type="submit" class="w-full bg-[#0346cbff] text-white font-black py-5 rounded-2xl hover:bg-[#0F172A] transition-all shadow-xl shadow-blue-200 uppercase tracking-widest text-sm">
                            Execute Command
                        </button>
                    </form>

                    <div class="mt-8 pt-8 border-t border-gray-50 uppercase">
                        <p class="text-[10px] font-black text-gray-300 tracking-widest mb-2">System Audit</p>
                        <p class="text-[10px] font-bold text-gray-400 leading-relaxed">
                            LAST SYNC: {{ $lead->updated_at->format('d M Y H:i:s') }}<br>
                            TERMINAL NODE: PUNE_HUB_01
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function toggleDisbursementFields(status) {
            const fields = document.getElementById('disbursementFields');
            if (status === 'APPROVED') {
                fields.classList.remove('hidden');
            } else {
                fields.classList.add('hidden');
            }
        }
    </script>
</x-admin-layout>

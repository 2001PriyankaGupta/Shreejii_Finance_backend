<x-admin-layout>

    <div class="py-6 bg-[#E2E8F0] min-h-screen" x-data="{ openModal: false, selectedFileName: '' }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header with Back Button and Verification Status -->
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4">
                <div>
                    <h3 class="text-3xl font-black text-slate-800 tracking-tight flex items-center gap-4">
                        Employee Details
                        @if($employee->status === 'APPROVED')
                            <span class="px-4 py-1.5 rounded-xl text-[10px] font-black tracking-widest uppercase bg-emerald-100 text-emerald-600 border border-emerald-200 shadow-sm leading-none">Verified</span>
                        @elseif($employee->status === 'REJECTED')
                            <span class="px-4 py-1.5 rounded-xl text-[10px] font-black tracking-widest uppercase bg-rose-100 text-rose-600 border border-rose-200 shadow-sm leading-none">Rejected</span>
                        @else
                            <span class="px-4 py-1.5 rounded-xl text-[10px] font-black tracking-widest uppercase bg-amber-100 text-amber-600 border border-amber-200 shadow-sm leading-none animate-pulse">Pending Review</span>
                        @endif
                    </h3>
                    <p class="text-slate-500 font-medium mt-1">Detailed overview of employee history and records.</p>
                </div>

                <div class="flex items-center gap-3">
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="inline-flex items-center px-6 py-3 bg-white text-slate-900 font-black rounded-2xl transition-all shadow-sm hover:bg-slate-50 border border-slate-200 group">
                            <i class="fa-solid fa-shield-halved mr-2 text-[#0346cbff]"></i>
                            Verify Identity
                            <i class="fa-solid fa-chevron-down text-[10px] ml-3 transition-transform" :class="{'rotate-180': open}"></i>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" style="display: none;" class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-2xl shadow-slate-200/50 border border-slate-100 p-2 z-50">
                            <form action="{{ route('admin.employees.approve', $employee->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-3 text-xs font-black uppercase tracking-widest text-emerald-600 hover:bg-emerald-50 rounded-xl transition-all flex items-center">
                                    <i class="fa-solid fa-check-double w-6"></i> Approve Identity
                                </button>
                            </form>
                            <form action="{{ route('admin.employees.reject', $employee->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-3 text-xs font-black uppercase tracking-widest text-rose-600 hover:bg-rose-50 rounded-xl transition-all flex items-center">
                                    <i class="fa-solid fa-user-slash w-6"></i> Reject Profile
                                </button>
                            </form>
                            <form action="{{ route('admin.employees.pending', $employee->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-3 text-xs font-black uppercase tracking-widest text-amber-600 hover:bg-amber-50 rounded-xl transition-all flex items-center border-t border-slate-50 mt-1 pt-2">
                                    <i class="fa-solid fa-clock-rotate-left w-6"></i> Set to Pending
                                </button>
                            </form>
                        </div>
                    </div>

                    <a href="{{ route('admin.employees.index') }}" class="inline-flex items-center px-6 py-3 bg-slate-800 text-white font-black rounded-2xl transition-all shadow-lg hover:bg-slate-900 border border-slate-700 group">
                        <svg class="w-5 h-5 mr-2 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Profile Overview -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-[2.5rem] shadow-xl border border-white p-10 text-center relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-[#0346cbff]/5 rounded-full blur-3xl -mt-10 -mr-10"></div>
                        
                        <div class="w-36 h-36 rounded-3xl bg-gradient-to-tr from-[#0346cbff] to-cyan-400 p-1 shadow-2xl mx-auto mb-8 relative group-hover:rotate-3 transition-transform">
                            <div class="w-full h-full rounded-2xl bg-white flex items-center justify-center text-4xl font-black italic text-[#0346cbff]">
                                @if($employee->avatar_url)
                                    <img src="{{ asset('storage/' . $employee->avatar_url) }}" class="w-full h-full object-cover rounded-2xl">
                                @else
                                    {{ strtoupper(substr($employee->name, 0, 1)) }}
                                @endif
                            </div>
                        </div>

                        <h3 class="text-2xl font-black text-slate-900 mb-1 leading-tight">{{ $employee->name }}</h3>
                        <div class="text-[10px] font-black text-[#0346cbff] bg-[#0346cbff]/5 px-3 py-1 rounded-md mb-8 inline-block uppercase tracking-widest italic">
                            {{ $employee->employeeDetail->designation ?? 'UNASSIGNED' }}
                        </div>
                        
                        <div class="space-y-5 text-left pt-8 border-t border-slate-50">
                            <div class="flex items-center group/item">
                                <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center mr-4 text-slate-400 group-hover/item:bg-[#0346cbff]/10 group-hover/item:text-[#0346cbff] transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Employee Node ID</p>
                                    <p class="text-sm font-black text-[#0346cbff] italic">{{ $employee->employee_id ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center group/item">
                                <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center mr-4 text-slate-400 group-hover/item:bg-[#0346cbff]/10 group-hover/item:text-[#0346cbff] transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Email Address</p>
                                    <p class="text-sm font-bold text-slate-700">{{ $employee->email }}</p>
                                </div>
                            </div>
                            <div class="flex items-center group/item">
                                <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center mr-4 text-slate-400 group-hover/item:bg-[#0346cbff]/10 group-hover/item:text-[#0346cbff] transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Phone Contact</p>
                                    <p class="text-sm font-bold text-slate-700">{{ $employee->phone }}</p>
                                </div>
                            </div>
                            <div class="flex items-center group/item">
                                <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center mr-4 text-slate-400 group-hover/item:bg-[#0346cbff]/10 group-hover/item:text-[#0346cbff] transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Joining Date</p>
                                    <p class="text-sm font-bold text-slate-700">{{ $employee->employeeDetail->joining_date ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-10">
                             <a href="{{ route('admin.employees.edit', $employee->id) }}" class="flex items-center justify-center w-full py-4 bg-[#0346cbff] text-white font-black rounded-2xl shadow-[0_15px_30px_-5px_rgba(3,70,203,0.3)] hover:scale-[1.02] active:scale-[0.98] transition-all">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Edit Profile Details
                             </a>
                        </div>
                    </div>
                </div>

                <!-- Detailed Info & Documents -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Bank & Finance -->
                    <div class="bg-white rounded-[2.5rem] shadow-xl border border-white p-10 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/5 rounded-full blur-3xl -mt-10 -mr-10"></div>
                        
                        <h4 class="text-2xl font-black text-slate-900 mb-8 flex items-center">
                            <span class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center mr-4 text-emerald-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </span>
                            Financial Records
                        </h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            <div class="p-6 rounded-3xl bg-slate-50/50 border border-slate-100">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Monthly Salary</p>
                                <p class="text-2xl font-black text-[#0346cbff]">₹ {{ number_format($employee->employeeDetail->salary ?? 0, 0) }}</p>
                            </div>
                            <div class="p-6 rounded-3xl bg-indigo-50 border border-indigo-100 shadow-sm shadow-indigo-100">
                                <p class="text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em] mb-2">Total Commission Earned</p>
                                <p class="text-2xl font-black text-indigo-700">₹ {{ number_format(\App\Models\WalletTransaction::where('user_id', $employee->id)->where('type', 'CREDIT')->sum('amount'), 2) }}</p>
                                <p class="text-[8px] font-bold text-indigo-400 mt-1 uppercase tracking-widest">Lifetime Yield</p>
                            </div>
                            <div class="p-6 rounded-3xl bg-slate-50/50 border border-slate-100">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Primary Bank</p>
                                <p class="text-lg font-black text-slate-800">{{ $employee->employeeDetail->bank_name ?? 'NOT REGISTERED' }}</p>
                            </div>
                            <div class="p-6 rounded-3xl bg-slate-50/50 border border-slate-100">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Account Number</p>
                                <p class="text-lg font-black text-slate-800 tracking-wider">{{ $employee->employeeDetail->account_number ?? 'XXXX XXXX XXXX' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- NEW: Commission History Section -->
                    <div class="bg-indigo-900 rounded-[2.5rem] shadow-xl border border-indigo-700 p-8 text-white">
                        <h4 class="text-xl font-black uppercase tracking-tight mb-6 flex items-center gap-3">
                            <i class="fa-solid fa-wallet text-indigo-400"></i> Financial Yield Log
                        </h4>
                        @php 
                            $commissions = \App\Models\WalletTransaction::where('user_id', $employee->id)
                                ->where('type', 'CREDIT')
                                ->latest()
                                ->limit(5)
                                ->get();
                        @endphp
                        <div class="space-y-4">
                            @forelse($commissions as $tx)
                                <div class="bg-white/5 border border-white/10 rounded-2xl p-4 flex items-center justify-between group hover:bg-white/10 transition-all">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-indigo-500/20 flex items-center justify-center text-indigo-300">
                                            <i class="fa-solid fa-arrow-trend-up"></i>
                                        </div>
                                        <div>
                                            @php 
                                                $lead = \App\Models\Lead::find($tx->description);
                                            @endphp
                                            <p class="text-[10px] font-black uppercase tracking-widest text-indigo-300">Conversion Bonus</p>
                                            <p class="font-bold text-sm">Lead #{{ $tx->description }} - {{ $lead ? $lead->customer_name : 'N/A' }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-lg font-black text-emerald-400">+₹{{ number_format($tx->amount, 2) }}</p>
                                        <p class="text-[8px] font-bold text-white/40 uppercase tracking-widest">{{ $tx->created_at->format('d M, Y') }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="py-10 text-center opacity-30">
                                    <p class="font-black uppercase tracking-[3px] text-xs">No Financial Transmissions Detected</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Documents Section -->
                    <div class="bg-white rounded-[2.5rem] shadow-xl border border-white p-10">
                        <div class="flex justify-between items-center mb-10">
                            <h4 class="text-2xl font-black text-slate-900 flex items-center">
                                <span class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center mr-4 text-indigo-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg>
                                </span>
                                Verification Documents
                            </h4>
                            <button @click="openModal = true" class="px-6 py-2 bg-[#0346cbff]/5 text-[#0346cbff] font-black rounded-xl text-xs hover:bg-[#0346cbff] hover:text-white transition-all uppercase tracking-widest italic">
                                + New Document
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @forelse($employee->employeeDocuments as $doc)
                                <div class="p-5 bg-slate-50 rounded-[1.5rem] border border-transparent hover:border-[#0346cbff]/20 hover:bg-white hover:shadow-lg transition-all flex items-center justify-between group">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 rounded-2xl bg-white shadow-sm text-rose-500 flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <div>
                                            <p class="font-black text-slate-800 text-sm italic">{{ $doc->type }}</p>
                                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-0.5">ID: {{ $doc->document_number ?? 'SECURED' }}</p>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="w-10 h-10 flex items-center justify-center text-[#0346cbff] bg-[#0346cbff]/5 rounded-xl hover:bg-[#0346cbff] hover:text-white transition-all shadow-sm group/view">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        </a>
                                         <form action="{{ route('admin.employees.delete-document', $doc->id) }}" method="POST" onsubmit="return confirm('Erase this record permanently?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-9 h-9 flex items-center justify-center text-rose-500 bg-white rounded-xl shadow-sm hover:bg-rose-500 hover:text-white transition-all">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-2 py-10 text-center">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <p class="text-slate-400 font-black italic">No records digitized yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        <!-- Upload Modal -->
    <div x-show="openModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[100] flex items-center justify-center p-4" 
         style="display: none;">
        
        <div @click.away="openModal = false" 
             class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-md p-10 relative border border-white">
            
            <!-- Close Button -->
            <button type="button" @click="openModal = false" class="absolute top-6 right-6 text-slate-400 hover:text-rose-500 transition-all p-2 bg-slate-50 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <div class="mb-8">
                <h4 class="text-2xl font-black text-slate-900">Upload Document</h4>
                <p class="text-sm text-slate-500 font-medium">Add new identification or joining records.</p>
            </div>

            <form action="{{ route('admin.employees.upload-document', $employee->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Document Type</label>
                        <select name="type" required class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:ring-2 focus:ring-[#0346cbff] transition-all font-bold text-slate-700">
                            <option value="Aadhar Card">Aadhar Card</option>
                            <option value="PAN Card">PAN Card</option>
                            <option value="Joining Letter">Joining Letter</option>
                            <option value="Experience Certificate">Experience Certificate</option>
                            <option value="Driving License">Driving License</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Document Number</label>
                        <input type="text" name="document_number" class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:ring-2 focus:ring-[#0346cbff] transition-all font-bold text-slate-700" placeholder="e.g. 1234-5678-9012">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Select File</label>
                        <div class="relative group/file">
                            <input type="file" name="document" required class="absolute inset-0 opacity-0 cursor-pointer z-10"
                                @change="selectedFileName = $event.target.files[0].name">
                            <div class="px-6 py-5 rounded-2xl bg-slate-50 border-2 border-dashed border-slate-200 group-hover/file:border-[#0346cbff] group-hover/file:bg-blue-50/30 transition-all flex flex-col items-center justify-center space-y-2">
                                <template x-if="!selectedFileName">
                                    <div class="flex items-center space-x-3 text-slate-400 group-hover/file:text-[#0346cbff]">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                        <span class="text-sm font-bold">Choose Document</span>
                                    </div>
                                </template>
                                <template x-if="selectedFileName">
                                    <div class="flex flex-col items-center">
                                        <div class="flex items-center space-x-2 text-[#0346cbff]">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <span class="text-sm font-black italic tracking-tight" x-text="selectedFileName"></span>
                                        </div>
                                        <button type="button" @click.stop="selectedFileName = ''; $el.closest('form').querySelector('input[type=file]').value = ''" class="mt-2 text-[10px] font-black text-rose-500 uppercase tracking-widest hover:underline">Change File</button>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-10 flex flex-col space-y-3">
                    <button type="submit" class="w-full py-5 bg-[#0346cbff] text-white font-black rounded-2xl shadow-[0_15px_30px_-5px_rgba(3,70,203,0.4)] transition-all hover:scale-[1.02]">
                        UPLOAD DOCUMENT
                    </button>
                    <button type="button" @click="openModal = false" class="w-full py-3 bg-slate-50 text-slate-500 font-bold rounded-2xl hover:bg-slate-100 transition-all">
                        CANCEL
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</x-admin-layout>

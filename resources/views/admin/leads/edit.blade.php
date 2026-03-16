<x-admin-layout>
    <div class="px-6 py-8 min-h-screen bg-[#E2E8F0]">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.leads.index') }}" class="w-12 h-12 bg-white text-slate-600 rounded-2xl flex items-center justify-center shadow-sm border border-slate-200 hover:text-[#0346cbff] transition-all">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="text-3xl font-black text-slate-800 tracking-tight">Full Lead Registry Node Control</h1>
                        <p class="text-slate-500 font-bold uppercase text-[10px] tracking-widest mt-1">Master Override Interface: Payload #LL-{{ $lead->id }}</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.leads.update', $lead->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <!-- LEFT COLUMN: Primary & Core Info -->
                    <div class="lg:col-span-2 space-y-8">
                        <div class="bg-white rounded-[2.5rem] shadow-xl border border-white p-10">
                            <h3 class="text-xl font-black text-slate-900 mb-8 border-b border-slate-50 pb-4">CORE IDENTITY & REGION</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Customer Identifier</label>
                                    <input type="text" name="customer_name" value="{{ old('customer_name', $lead->customer_name) }}" required class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:ring-4 focus:ring-[#0346cbff]/10 focus:border-[#0346cbff] transition-all font-bold text-slate-700">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Contact Sequence</label>
                                    <input type="text" name="mobile_number" value="{{ old('mobile_number', $lead->mobile_number) }}" required class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:ring-4 focus:ring-[#0346cbff]/10 focus:border-[#0346cbff] transition-all font-bold text-slate-700">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Operational City</label>
                                    <input type="text" name="city" value="{{ old('city', $lead->city) }}" required class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:ring-4 focus:ring-[#0346cbff]/10 focus:border-[#0346cbff] transition-all font-bold text-slate-700">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Monthly Yield (Earnings)</label>
                                    <input type="number" step="0.01" name="monthly_yield" value="{{ old('monthly_yield', $lead->monthly_yield) }}" class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:ring-4 focus:ring-[#0346cbff]/10 focus:border-[#0346cbff] transition-all font-bold text-slate-700" placeholder="0.00">
                                </div>
                            </div>
                        </div>

                        <!-- VEHICLE / ASSET SPECIFICATIONS -->
                        <div class="bg-white rounded-[2.5rem] shadow-xl border border-white p-10">
                            <h3 class="text-xl font-black text-slate-900 mb-8 border-b border-slate-50 pb-4">ASSET SPECIFICATIONS (FOR VEHICLE/LOAN)</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Make / Brand</label>
                                    <input type="text" name="vehicle_make" value="{{ old('vehicle_make', $lead->vehicle_make) }}" class="w-full px-5 py-4 rounded-xl bg-slate-50 border-transparent focus:bg-white focus:border-[#0346cbff] transition-all font-bold text-slate-700 shadow-sm" placeholder="e.g. Tata, Mahindra">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Model Node</label>
                                    <input type="text" name="vehicle_model" value="{{ old('vehicle_model', $lead->vehicle_model) }}" class="w-full px-5 py-4 rounded-xl bg-slate-50 border-transparent focus:bg-white focus:border-[#0346cbff] transition-all font-bold text-slate-700 shadow-sm" placeholder="e.g. Harrier">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Mfg Year</label>
                                    <input type="number" name="mfg_year" value="{{ old('mfg_year', $lead->mfg_year) }}" class="w-full px-5 py-4 rounded-xl bg-slate-50 border-transparent focus:bg-white focus:border-[#0346cbff] transition-all font-bold text-slate-700 shadow-sm" placeholder="2024">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Fuel Protocol</label>
                                    <select name="fuel_type" class="w-full px-5 py-4 rounded-xl bg-slate-50 border-transparent focus:bg-white focus:border-[#0346cbff] transition-all font-bold text-slate-700 shadow-sm appearance-none">
                                        <option value="">Select Fuel</option>
                                        @foreach(['PETROL', 'DIESEL', 'CNG', 'ELECTRIC', 'HYBRID'] as $fuel)
                                            <option value="{{ $fuel }}" {{ old('fuel_type', $lead->fuel_type) == $fuel ? 'selected' : '' }}>{{ $fuel }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Market Asset Value</label>
                                    <input type="number" step="0.01" name="asset_value" value="{{ old('asset_value', $lead->asset_value) }}" class="w-full px-5 py-4 rounded-xl bg-slate-50 border-transparent focus:bg-white focus:border-[#0346cbff] transition-all font-bold text-slate-700 shadow-sm" placeholder="5,00,000">
                                </div>
                            </div>
                        </div>

                        <!-- LEGAL IDENTIFIERS -->
                        <div class="bg-indigo-900 rounded-[2.5rem] shadow-xl border border-indigo-700 p-10 text-white">
                            <h3 class="text-xl font-black uppercase tracking-tight mb-8 border-b border-indigo-500 pb-4">STATUTORY IDENTIFIERS</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-indigo-300 uppercase tracking-[0.2em] ml-1">PAN Sequence</label>
                                    <input type="text" name="pan_number" value="{{ old('pan_number', $lead->pan_number) }}" class="w-full px-6 py-4 rounded-2xl bg-white/5 border border-white/10 focus:bg-white/10 focus:border-white transition-all font-black text-white italic tracking-[3px]" placeholder="ABCDE1234F" maxlength="10">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-indigo-300 uppercase tracking-[0.2em] ml-1">Aadhaar Link Node</label>
                                    <input type="text" name="aadhaar_number" value="{{ old('aadhaar_number', $lead->aadhaar_number) }}" class="w-full px-6 py-4 rounded-2xl bg-white/5 border border-white/10 focus:bg-white/10 focus:border-white transition-all font-black text-white tracking-[2px]" placeholder="XXXX XXXX XXXX" maxlength="12">
                                </div>
                            </div>
                        </div>

                        <!-- DOCUMENTS VAULT -->
                        <div class="bg-white rounded-[2.5rem] shadow-xl border border-white p-10">
                            <h3 class="text-xl font-black text-slate-900 mb-8 border-b border-slate-50 pb-4">INTEGRATED DOCUMENT VAULT</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- General Docs -->
                                <div class="p-6 bg-slate-50 rounded-3xl border border-slate-100 italic">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                                        <i class="fa-solid fa-folder-open text-[#0346cbff]"></i> Prime Documents
                                    </p>
                                    <div class="space-y-2">
                                        @if($lead->documents && count($lead->documents) > 0)
                                            @foreach($lead->documents as $doc)
                                                <a href="{{ asset('storage/' . $doc) }}" target="_blank" class="flex items-center justify-between p-3 bg-white rounded-xl shadow-sm hover:translate-x-1 transition-all">
                                                    <span class="text-[11px] font-black text-slate-600 truncate mr-2">{{ basename($doc) }}</span>
                                                    <i class="fa-solid fa-arrow-up-right-from-square text-[#0346cbff] text-[10px]"></i>
                                                </a>
                                            @endforeach
                                        @else
                                            <p class="text-[10px] text-slate-400 font-bold">NO UPLOADS DETECTED</p>
                                        @endif
                                    </div>
                                </div>
                                <!-- RC Docs -->
                                <div class="p-6 bg-rose-50 rounded-3xl border border-rose-100 italic">
                                    <p class="text-[10px] font-black text-rose-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                                        <i class="fa-solid fa-car"></i> Registration Nodes (RC)
                                    </p>
                                    <div class="space-y-2">
                                        @if($lead->rc_documents && count($lead->rc_documents) > 0)
                                            @foreach($lead->rc_documents as $doc)
                                                <a href="{{ asset('storage/' . $doc) }}" target="_blank" class="flex items-center justify-between p-3 bg-white rounded-xl shadow-sm hover:translate-x-1 transition-all">
                                                    <span class="text-[11px] font-black text-slate-600 truncate mr-2">{{ basename($doc) }}</span>
                                                    <i class="fa-solid fa-arrow-up-right-from-square text-rose-500 text-[10px]"></i>
                                                </a>
                                            @endforeach
                                        @else
                                            <p class="text-[10px] text-rose-400 font-bold">NO ASSET RECORDS DETECTED</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT COLUMN: Control & Dispatch -->
                    <div class="lg:col-span-1 space-y-8">
                        <!-- STATUS & DISPATCH -->
                        <div class="bg-white rounded-[2.5rem] shadow-xl border border-white p-8">
                            <h3 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em] mb-6">PIPELINE CONTROL</h3>
                            
                            <div class="space-y-6">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Protocol Status</label>
                                    <select name="status" class="w-full px-5 py-4 rounded-xl bg-slate-50 border-transparent focus:bg-white focus:border-[#0346cbff] transition-all font-black text-[#0346cbff] shadow-sm appearance-none cursor-pointer">
                                        @foreach(['OPEN', 'PENDING', 'APPROVED', 'REJECTED'] as $status)
                                            <option value="{{ $status }}" {{ old('status', $lead->status) == $status ? 'selected' : '' }}>PROTOCOL: {{ $status }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Assigned Agent Node</label>
                                    <select name="user_id" class="w-full px-5 py-4 rounded-xl bg-slate-50 border-transparent focus:bg-white focus:border-[#0346cbff] transition-all font-bold text-slate-700 shadow-sm appearance-none cursor-pointer">
                                        <optgroup label="Employees">
                                            @foreach($employees as $emp)
                                                <option value="{{ $emp->id }}" {{ old('user_id', $lead->user_id) == $emp->id ? 'selected' : '' }}>{{ $emp->name }}</option>
                                            @endforeach
                                        </optgroup>
                                        <optgroup label="Partners">
                                            @foreach($partners as $partner)
                                                <option value="{{ $partner->id }}" {{ old('user_id', $lead->user_id) == $partner->id ? 'selected' : '' }}>{{ $partner->name }}</option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                </div>

                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Category Registry</label>
                                    <select name="loan_type" class="w-full px-5 py-4 rounded-xl bg-slate-50 border-transparent focus:bg-white focus:border-[#0346cbff] transition-all font-bold text-slate-700 shadow-sm appearance-none">
                                        @foreach(['PERSONAL', 'HOME', 'VEHICLE', 'BUSINESS', 'LAB', 'GOLD'] as $type)
                                            <option value="{{ $type }}" {{ old('loan_type', $lead->loan_type) == $type ? 'selected' : '' }}>{{ $type }} LOAN</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- FINANCIAL OVERRIDE -->
                        <div class="bg-emerald-900 rounded-[2.5rem] shadow-xl border border-emerald-700 p-8 text-white">
                            <h3 class="text-sm font-black uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                                <i class="fa-solid fa-coins text-emerald-400"></i> Capital Override
                            </h3>
                            <div class="space-y-5">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-emerald-300/60 uppercase tracking-widest">Loan Amount Requested</label>
                                    <input type="number" step="0.01" name="loan_amount" value="{{ old('loan_amount', $lead->loan_amount) }}" class="w-full px-5 py-4 rounded-xl bg-white/5 border border-white/10 focus:bg-white/10 transition-all font-bold text-white shadow-inner" placeholder="0.00">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-emerald-300/60 uppercase tracking-widest">Disbursed Capital</label>
                                    <input type="number" step="0.01" name="disbursed_amount" value="{{ old('disbursed_amount', $lead->disbursed_amount) }}" class="w-full px-5 py-4 rounded-xl bg-white/5 border border-white/10 focus:bg-white/10 transition-all font-bold text-white shadow-inner" placeholder="0.00">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-emerald-300/60 uppercase tracking-widest">Tenure Cycle (Months)</label>
                                    <input type="number" name="tenure_months" value="{{ old('tenure_months', $lead->tenure_months) }}" class="w-full px-5 py-4 rounded-xl bg-white/5 border border-white/10 focus:bg-white/10 transition-all font-bold text-white shadow-inner" placeholder="e.g. 24">
                                </div>
                            </div>
                        </div>

                        <!-- SUBMIT -->
                        <div class="space-y-3">
                            <button type="submit" class="w-full py-6 bg-[#0346cbff] text-white font-black rounded-3xl shadow-[0_20px_40px_-10px_rgba(3,70,203,0.4)] hover:scale-[1.03] active:scale-[0.97] transition-all uppercase tracking-[0.2em] text-xs">
                                Overwrite Node Registry
                            </button>
                            <a href="{{ route('admin.leads.index') }}" class="block w-full py-4 text-center bg-white text-slate-400 font-black rounded-2xl hover:bg-slate-50 transition-all uppercase tracking-widest text-[9px]">
                                Discard Mutations
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>

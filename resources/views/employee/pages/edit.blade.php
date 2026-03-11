<x-admin-layout>
   

    <div class="py-6 bg-[#E2E8F0] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header with Back Button -->
            <div class="flex justify-between items-center mb-10">
                <div>
                    <h3 class="text-3xl font-black text-slate-800 tracking-tight">Edit Employee Profile</h3>
                    <p class="text-slate-500 font-medium mt-1">Update personal and professional details for {{ $employee->name }}.</p>
                </div>
                <a href="{{ route('admin.employees.index') }}" class="inline-flex items-center px-6 py-3 bg-white text-slate-600 font-black rounded-2xl transition-all shadow-sm hover:bg-slate-50 border border-slate-200 group">
                    <svg class="w-5 h-5 mr-2 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to List
                </a>
            </div>

            <form action="{{ route('admin.employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                    <!-- Left: Details -->
                    <div class="lg:col-span-2 space-y-8">
                        <div class="bg-white rounded-[2.5rem] shadow-xl border border-white p-10 relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-[#0346cbff]/5 rounded-full blur-3xl -mt-10 -mr-10"></div>
                            
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-8 mb-10 pb-8 border-b border-slate-50">
                                <h4 class="text-2xl font-black text-slate-900 flex items-center">
                                    <span class="w-10 h-10 rounded-xl bg-[#0346cbff]/10 flex items-center justify-center mr-4 text-[#0346cbff]">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                                    </span>
                                    Basic Information
                                </h4>

                                <!-- Avatar Upload -->
                                <div x-data="{ photoPreview: null }" class="flex flex-col items-center">
                                    <input type="file" name="avatar_url" class="hidden" x-ref="photo"
                                        x-on:change="
                                            const reader = new FileReader();
                                            reader.onload = (e) => {
                                                photoPreview = e.target.result;
                                            };
                                            reader.readAsDataURL($refs.photo.files[0]);
                                        ">

                                    <div class="relative group">
                                        <div class="w-24 h-24 rounded-2xl bg-slate-100 border-2 border-dashed border-slate-300 flex items-center justify-center overflow-hidden transition-all cursor-pointer group-hover:border-[#0346cbff]"
                                             x-on:click="$refs.photo.click()">
                                            <template x-if="photoPreview">
                                                <img :src="photoPreview" class="w-full h-full object-cover">
                                            </template>
                                            <template x-if="!photoPreview">
                                                @if($employee->avatar_url)
                                                    <img src="{{ asset('storage/' . $employee->avatar_url) }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="text-center">
                                                        <svg class="w-6 h-6 mx-auto mb-1 text-slate-400 group-hover:text-[#0346cbff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                                        <p class="text-[8px] font-black text-slate-400 uppercase group-hover:text-[#0346cbff]">Photo</p>
                                                    </div>
                                                @endif
                                            </template>
                                        </div>
                                        <div class="absolute -bottom-2 -right-2 bg-[#0346cbff] text-white p-1.5 rounded-lg shadow-lg" x-on:click="$refs.photo.click()">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-2">
                                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Employee Node ID (Read Only)</label>
                                    <input type="text" value="{{ $employee->employee_id }}" readonly class="w-full px-6 py-4 rounded-2xl bg-blue-50 border-transparent font-black text-[#0346cbff] cursor-not-allowed italic">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Full Name</label>
                                    <input type="text" name="name" value="{{ $employee->name }}" required class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:ring-2 focus:ring-[#0346cbff] transition-all font-bold text-slate-700">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Email Address</label>
                                    <input type="email" name="email" value="{{ $employee->email }}" required class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:ring-2 focus:ring-[#0346cbff] transition-all font-bold text-slate-700">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Phone Number</label>
                                    <input type="text" name="phone" value="{{ $employee->phone }}" required class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:ring-2 focus:ring-[#0346cbff] transition-all font-bold text-slate-700">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Designation</label>
                                    <input type="text" name="designation" value="{{ $employee->employeeDetail->designation ?? '' }}" class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:ring-2 focus:ring-[#0346cbff] transition-all font-bold text-slate-700">
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-[2.5rem] shadow-xl border border-white p-10 relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/5 rounded-full blur-3xl -mt-10 -mr-10"></div>
                            
                            <h4 class="text-2xl font-black text-slate-900 mb-8 flex items-center">
                                <span class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center mr-4 text-emerald-600">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path><path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path></svg>
                                </span>
                                Banking Details
                            </h4>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-2">
                                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Bank Name</label>
                                    <input type="text" name="bank_name" value="{{ $employee->employeeDetail->bank_name ?? '' }}" class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:ring-2 focus:ring-emerald-500 transition-all font-bold text-slate-700">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Account Number</label>
                                    <input type="text" name="account_number" value="{{ $employee->employeeDetail->account_number ?? '' }}" class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:ring-2 focus:ring-emerald-500 transition-all font-bold text-slate-700">
                                </div>
                                <div class="space-y-2 md:col-span-2">
                                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">IFSC Code</label>
                                    <input type="text" name="ifsc_code" value="{{ $employee->employeeDetail->ifsc_code ?? '' }}" class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:ring-2 focus:ring-emerald-500 transition-all font-bold text-slate-700 uppercase">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Quick Stats & Actions -->
                    <div class="space-y-8">
                        <div class="bg-slate-900 rounded-[2.5rem] shadow-2xl p-10 text-white relative overflow-hidden">
                            <h4 class="text-xl font-black mb-8 flex items-center">
                                <span class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center mr-4">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </span>
                                Employment
                            </h4>
                            <div class="space-y-6">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Monthly Salary</label>
                                    <input type="number" name="salary" value="{{ $employee->employeeDetail->salary ?? '' }}" class="w-full px-6 py-4 rounded-2xl bg-white/5 border-white/10 focus:bg-white/10 focus:ring-2 focus:ring-[#0346cbff] transition-all font-bold text-white">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Joining Date</label>
                                    <input type="date" name="joining_date" value="{{ $employee->employeeDetail->joining_date ?? '' }}" class="w-full px-6 py-4 rounded-2xl bg-white/5 border-white/10 focus:bg-white/10 focus:ring-2 focus:ring-[#0346cbff] transition-all font-bold text-white">
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-[2.5rem] shadow-xl p-8 border border-white space-y-4">
                             <button type="submit" class="w-full py-5 bg-[#0346cbff] text-white font-black rounded-2xl shadow-[0_15px_30px_-5px_rgba(3,70,203,0.4)] transition-all hover:scale-[1.02]">
                                UPDATE CHANGES
                             </button>
                             <a href="{{ route('admin.employees.index') }}" class="w-full py-5 bg-slate-50 text-slate-500 font-bold rounded-2xl hover:bg-slate-100 transition-all text-center block leading-[1.25]">
                                DISCARD
                             </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>

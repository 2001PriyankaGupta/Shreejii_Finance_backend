<x-admin-layout>
    

    <div class="py-6 bg-[#E2E8F0] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <h3 class="text-3xl font-black text-slate-800 tracking-tight">Add New Employee</h3>
                <a href="{{ route('admin.employees.index') }}" class="inline-flex items-center px-6 py-3 bg-white text-slate-600 font-black rounded-2xl transition-all shadow-sm hover:bg-slate-50 border border-slate-200 group">
                    <svg class="w-5 h-5 mr-2 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to List
                </a>
            </div>

            <form action="{{ route('admin.employees.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Basic Information -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 mb-8">
                    <h4 class="text-xl font-bold text-gray-800 mb-6">Basic Information</h4>
                    
                    <!-- Avatar Upload -->
                    <div class="mb-10 flex flex-col items-center">
                        <div x-data="{ photoName: null, photoPreview: null }" class="relative">
                            <input type="file" name="avatar_url" class="hidden" x-ref="photo"
                                x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                                ">

                            <div class="w-32 h-32 rounded-3xl bg-slate-100 border-2 border-dashed border-slate-300 flex items-center justify-center overflow-hidden group hover:border-[#0346cbff] transition-all cursor-pointer"
                                 x-on:click="$refs.photo.click()">
                                <template x-if="photoPreview">
                                    <img :src="photoPreview" class="w-full h-full object-cover">
                                </template>
                                <template x-if="!photoPreview">
                                    <div class="text-center group-hover:text-[#0346cbff]">
                                        <svg class="w-8 h-8 mx-auto mb-1 text-slate-400 group-hover:text-[#0346cbff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest group-hover:text-[#0346cbff]">Photo</p>
                                    </div>
                                </template>
                            </div>
                            
                            <!-- Remove Photo -->
                            <template x-if="photoPreview">
                                <button type="button" class="absolute -top-2 -right-2 bg-rose-500 text-white rounded-lg p-1 shadow-lg hover:bg-rose-600 transition-all" @click="photoPreview = null; $refs.photo.value = ''">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </template>
                        </div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-4">Profile Image</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" name="name" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:ring-[#0346cbff] focus:border-[#0346cbff] transition-all" placeholder="John Doe">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <input type="email" name="email" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:ring-[#0346cbff] focus:border-[#0346cbff] transition-all" placeholder="john@example.com">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="text" name="phone" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:ring-[#0346cbff] focus:border-[#0346cbff] transition-all" placeholder="+91 9876543210">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Designation</label>
                            <input type="text" name="designation" class="w-full px-4 py-3 rounded-xl border-gray-200 focus:ring-[#0346cbff] focus:border-[#0346cbff] transition-all" placeholder="Manager / Driver">
                        </div>
                    </div>
                </div>

                <!-- Financial & Employment -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 mb-8">
                    <h4 class="text-xl font-bold text-gray-800 mb-6">Employment & Financial Details</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Monthly Salary (₹)</label>
                            <input type="number" name="salary" class="w-full px-4 py-3 rounded-xl border-gray-200 focus:ring-[#0346cbff] focus:border-[#0346cbff] transition-all" placeholder="25000">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Joining Date</label>
                            <input type="date" name="joining_date" min="{{ date('Y-m-d') }}" class="w-full px-4 py-3 rounded-xl border-gray-200 focus:ring-[#0346cbff] focus:border-[#0346cbff] transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Bank Name</label>
                            <input type="text" name="bank_name" class="w-full px-4 py-3 rounded-xl border-gray-200 focus:ring-[#0346cbff] focus:border-[#0346cbff] transition-all" placeholder="HDFC Bank">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Account Number</label>
                            <input type="text" name="account_number" class="w-full px-4 py-3 rounded-xl border-gray-200 focus:ring-[#0346cbff] focus:border-[#0346cbff] transition-all" placeholder="50100...">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">IFSC Code</label>
                            <input type="text" name="ifsc_code" class="w-full px-4 py-3 rounded-xl border-gray-200 focus:ring-[#0346cbff] focus:border-[#0346cbff] transition-all" placeholder="HDFC0001">
                        </div>
                         <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Emergency Contact</label>
                            <input type="text" name="emergency_contact" class="w-full px-4 py-3 rounded-xl border-gray-200 focus:ring-[#0346cbff] focus:border-[#0346cbff] transition-all" placeholder="Spouse / Parent Phone">
                        </div>
                    </div>
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Current Address</label>
                        <textarea name="address" rows="3" class="w-full px-4 py-3 rounded-xl border-gray-200 focus:ring-[#0346cbff] focus:border-[#0346cbff] transition-all" placeholder="Enter full address..."></textarea>
                    </div>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.employees.index') }}" class="px-8 py-3 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition-all">Cancel</a>
                    <button type="submit" class="px-8 py-3 bg-[#0346cbff] text-white font-bold rounded-xl hover:bg-blue-700 shadow-lg hover:shadow-blue-500/50 transition-all">Save Employee</button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>

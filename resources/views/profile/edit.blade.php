<x-admin-layout>
    <x-slot name="header">
        Profile Settings
    </x-slot>

    <div class="py-4" 
        x-data="{ showToast: false, toastMessage: '', toastType: 'success' }"
        x-init="
            @if (session('status') === 'profile-updated')
                toastMessage = 'Profile information has been updated.';
                showToast = true;
                setTimeout(() => showToast = false, 5000);
            @elseif (session('status') === 'password-updated')
                toastMessage = 'Password has been changed successfully.';
                showToast = true;
                setTimeout(() => showToast = false, 5000);
            @endif
        ">
        <!-- Toast Notification -->
        <template x-if="showToast">
            <div class="fixed top-6 right-6 z-[100] animate-in slide-in-from-right duration-500">
                <div :class="toastType === 'success' ? 'bg-[#0346cbff]' : 'bg-rose-500'" class="px-8 py-4 rounded-[2rem] shadow-2xl flex items-center text-white backdrop-blur-xl border border-white/20">
                    <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center mr-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
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

        <div class="max-w-6xl mx-auto space-y-8">
            
            <!-- Breadcrumb/Header Area -->
            <div class="flex items-center space-x-2 text-sm text-gray-400 mb-2">
                <a href="{{ route('dashboard') }}" class="hover:text-[#0346cbff]">Dashboard</a>
                <span>/</span>
                <span class="text-gray-600 font-medium">Profile Settings</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Sidebar: Profile Card (Dark Version) -->
                <div class="lg:col-span-1">
                    <div class="bg-[#0F172A] rounded-[2.5rem] shadow-2xl p-8 text-center sticky top-6 overflow-hidden relative group">
                        <!-- Decorative Blobs -->
                        <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-blue-600 rounded-full blur-3xl opacity-20 transition-all duration-500 group-hover:scale-150"></div>
                        <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-indigo-600 rounded-full blur-3xl opacity-10"></div>
                        
                        <div class="relative z-10">
                            <!-- Clickable Avatar Area -->
                            <div class="relative group/avatar cursor-pointer mx-auto w-36 h-36 mb-6" onclick="document.getElementById('avatar-input').click()">
                                <div class="w-full h-full rounded-full bg-gradient-to-tr from-[#0346cbff] via-blue-500 to-cyan-400 p-1 shadow-2xl relative overflow-hidden transition-transform active:scale-95">
                                    <div class="w-full h-full rounded-full bg-[#0F172A] flex items-center justify-center text-white text-4xl font-black italic overflow-hidden">
                                        @if(Auth::user()->avatar_url)
                                            <img src="{{ asset('storage/' . Auth::user()->avatar_url) }}" class="w-full h-full object-cover">
                                        @else
                                            {{ Auth::user()->name[0] ?? 'A' }}
                                        @endif
                                    </div>
                                    <!-- Hover Overlay -->
                                    <div class="absolute inset-0 bg-black/60 opacity-0 group-hover/avatar:opacity-100 transition-opacity flex items-center justify-center flex-col scale-110 group-hover/avatar:scale-100 duration-300">
                                        <svg class="w-8 h-8 text-white mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                                        <span class="text-[10px] text-white font-black uppercase">Change Image</span>
                                    </div>
                                </div>
                                <div class="absolute bottom-1 right-1 w-8 h-8 bg-emerald-500 border-4 border-[#0F172A] rounded-full z-20"></div>
                            </div>

                            <!-- Hidden Form for Avatar -->
                            <form id="avatar-form" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="hidden">
                                @csrf
                                @method('PATCH')
                                <input type="file" id="avatar-input" name="avatar_url" onchange="document.getElementById('avatar-form').submit()">
                            </form>

                            <h3 class="text-2xl font-black text-white mb-2 tracking-tight">{{ Auth::user()->name }}</h3>
                            <div class="inline-flex items-center px-4 py-1.5 bg-blue-500/10 border border-blue-500/20 text-blue-400 rounded-full text-xs font-black uppercase tracking-widest mb-8">
                                <svg class="w-3 h-3 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                {{ Auth::user()->role }}
                            </div>
                            
                            <div class="pt-8 border-t border-white/5 space-y-5 text-left">
                                <div class="flex items-center text-gray-400 group/item hover:text-white transition-colors cursor-pointer">
                                    <div class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center mr-4 text-blue-400 group-hover/item:bg-[#0346cbff] group-hover/item:text-white transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <div class="overflow-hidden">
                                        <p class="text-[10px] font-black uppercase tracking-widest opacity-50">Email Address</p>
                                        <p class="text-sm font-bold truncate">{{ Auth::user()->email }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center text-gray-400 group/item hover:text-white transition-colors cursor-pointer">
                                    <div class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center mr-4 text-blue-400 group-hover/item:bg-[#0346cbff] group-hover/item:text-white transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-black uppercase tracking-widest opacity-50">Last Login</p>
                                        <p class="text-sm font-bold">{{ now()->format('d M, Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Settings Forms -->
                <div class="lg:col-span-2 space-y-10">
                    <!-- Profile Information Card -->
                    <div class="bg-white rounded-[2.5rem] shadow-xl overflow-hidden border border-gray-100/50 group hover:border-[#0346cbff]/30 transition-all duration-500">
                        <div class="p-10 border-b border-gray-50 flex items-center justify-between bg-gradient-to-r from-gray-50 to-white">
                            <div>
                                <h4 class="text-2xl font-black text-gray-900 tracking-tight flex items-center">
                                    <span class="w-8 h-8 rounded-lg bg-[#0346cbff]/10 flex items-center justify-center mr-3 text-[#0346cbff]">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                                    </span>
                                    Account Details
                                </h4>
                                <p class="text-sm text-gray-400 mt-2 font-medium">Customize your primary profile information.</p>
                            </div>
                        </div>
                        <div style="padding-right: 20px; padding-left: 20px;  padding-bottom: 20px;">
                            <form method="post" action="{{ route('profile.update') }}" class="space-y-8">
                                @csrf
                                @method('patch')

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div class="space-y-2">
                                        <label class="text-[11px] font-black text-gray-400 uppercase tracking-widest ml-1">Full Name</label>
                                        <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-transparent focus:bg-white focus:border-[#0346cbff] focus:ring-4 focus:ring-[#0346cbff]/5 transition-all outline-none font-bold text-gray-800" placeholder="Enter name">
                                        @error('name') <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[11px] font-black text-gray-400 uppercase tracking-widest ml-1">Email Address</label>
                                        <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-transparent focus:bg-white focus:border-[#0346cbff] focus:ring-4 focus:ring-[#0346cbff]/5 transition-all outline-none font-bold text-gray-800" placeholder="Enter email">
                                        @error('email') <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[11px] font-black text-gray-400 uppercase tracking-widest ml-1">Phone Number</label>
                                        <input type="text" name="phone" value="{{ old('phone', Auth::user()->phone) }}" class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-transparent focus:bg-white focus:border-[#0346cbff] focus:ring-4 focus:ring-[#0346cbff]/5 transition-all outline-none font-bold text-gray-800" placeholder="Enter phone">
                                        @error('phone') <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                                    </div>
                                </div>

                                <div class="flex justify-end pt-4">
                                    <button type="submit" class="group relative px-10 py-4 bg-[#0346cbff] text-white font-black rounded-2xl hover:bg-blue-700 transition-all shadow-[0_10px_30px_-10px_rgba(3,70,203,0.5)] hover:shadow-[0_20px_40px_-10px_rgba(3,70,203,0.6)] active:scale-95">
                                        <span class="relative z-10">Update Details</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Change Password Card -->
                    <div class="bg-white rounded-[2.5rem] shadow-xl overflow-hidden border border-gray-100/50 group hover:border-emerald-500/30 transition-all duration-500">
                         <div style="padding-right: 20px; padding-left: 20px;padding-top: 20px; padding-bottom: 20px;" class=" border-b border-gray-50 flex items-center justify-between bg-gradient-to-r from-gray-50 to-white">
                            <div>
                                <h4 class="text-2xl font-black text-gray-900 tracking-tight flex items-center">
                                    <span class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center mr-3 text-emerald-600">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.9L9.03 9.122a2 2 0 001.938 0L17.834 4.9A2 2 0 0016 4H4a2 2 0 00-1.834.9zM18 6.834V14a2 2 0 01-2 2H4a2 2 0 01-2-2V6.834l6.56 4.038a4 4 0 003.88 0L18 6.834z" clip-rule="evenodd"></path></svg>
                                    </span>
                                    Security Settings
                                </h4>
                                <p class="text-sm text-gray-400 mt-2 font-medium">Keep your admin dashboard secure.</p>
                            </div>
                        </div>
                        <div style="padding-right: 20px; padding-left: 20px;padding-bottom: 20px;">
                            <form method="post" action="{{ route('password.update') }}" class="space-y-8">
                                @csrf
                                @method('put')

                                <div class="space-y-8">
                                    <div class="max-w-md space-y-2">
                                        <label class="text-[11px] font-black text-gray-400 uppercase tracking-widest ml-1">Current Password</label>
                                        <input type="password" name="current_password" class="w-full px-6 py-4 rounded-2xl bg-emerald-50/30 border-transparent focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/5 transition-all outline-none font-bold text-gray-800" placeholder="••••••••">
                                        @error('current_password', 'updatePassword') <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                        <div class="space-y-2">
                                            <label class="text-[11px] font-black text-gray-400 uppercase tracking-widest ml-1">New Password</label>
                                            <input type="password" name="password" class="w-full px-6 py-4 rounded-2xl bg-emerald-50/30 border-transparent focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/5 transition-all outline-none font-bold text-gray-800" placeholder="••••••••">
                                            @error('password', 'updatePassword') <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-[11px] font-black text-gray-400 uppercase tracking-widest ml-1">Confirm New Password</label>
                                            <input type="password" name="password_confirmation" class="w-full px-6 py-4 rounded-2xl bg-emerald-50/30 border-transparent focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/5 transition-all outline-none font-bold text-gray-800" placeholder="••••••••">
                                        </div>
                                    </div>
                                </div>

                                <div class="flex justify-end pt-4">
                                    <button type="submit" class="px-10 py-4 bg-emerald-500 text-white font-black rounded-2xl hover:bg-emerald-600 transition-all shadow-[0_10px_30_rgba(16,185,129,0.5)] hover:shadow-[0_20px_40px_-10px_rgba(16,185,129,0.6)] active:scale-95">
                                        Change Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

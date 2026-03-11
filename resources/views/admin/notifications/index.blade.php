<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-[3rem] border border-slate-200">
                <div class="p-10">
                    <div class="flex items-center justify-between mb-12">
                        <div>
                            <h2 class="text-3xl font-black text-slate-900 tracking-tight flex items-center gap-4">
                                <i class="fa-solid fa-radar text-rose-500"></i> Signal Log (Notifications)
                            </h2>
                            <p class="text-slate-500 font-bold mt-2 uppercase tracking-[4px] text-[10px]">Global event broadcast record</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        @forelse($notifications as $notif)
                            <div class="p-8 bg-slate-50 border border-slate-100 rounded-[2.5rem] flex items-center gap-8 hover:bg-white hover:border-[#0346cbff] transition-all group shadow-sm hover:shadow-xl">
                                <div class="w-16 h-16 rounded-[2rem] bg-white border border-slate-200 flex items-center justify-center text-slate-400 group-hover:bg-[#0346cbff] group-hover:text-white transition-all shadow-inner">
                                    <i class="fa-solid {{ $notif->type == 'LOAN' ? 'fa-file-invoice-dollar' : 'fa-satellite-dish' }} text-2xl"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <span class="px-3 py-1 bg-{{ $notif->type == 'LOAN' ? 'blue' : 'amber' }}-100 text-{{ $notif->type == 'LOAN' ? 'blue' : 'amber' }}-600 rounded-md text-[8px] font-black uppercase tracking-widest">{{ $notif->type }} EVENT</span>
                                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ $notif->created_at->format('d M • H:i') }}</p>
                                    </div>
                                    <h4 class="text-lg font-black text-slate-900 mb-1 group-hover:text-[#0346cbff] transition-colors uppercase tracking-tight">{{ $notif->title }}</h4>
                                    <p class="text-slate-500 text-sm font-medium leading-relaxed">{{ $notif->message }}</p>
                                </div>
                                <div class="text-right">
                                    @if($notif->user_id)
                                        <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Target Node</p>
                                        <span class="px-4 py-1.5 bg-slate-900 text-white rounded-xl text-[9px] font-black shadow-lg">#UID-{{ $notif->user_id }}</span>
                                    @else
                                        <span class="px-4 py-1.5 bg-emerald-500 text-white rounded-xl text-[9px] font-black shadow-lg uppercase tracking-widest">GLOBAL BROADCAST</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="py-32 text-center border-2 border-dashed border-slate-200 rounded-[3rem]">
                                <i class="fa-solid fa-wind text-slate-200 text-5xl mb-6"></i>
                                <p class="text-slate-400 font-black uppercase tracking-widest text-sm">Static silence detected.</p>
                                <p class="text-slate-300 text-xs mt-2">The notification log is currently clear.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

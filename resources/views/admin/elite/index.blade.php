<x-admin-layout>
  

     <h1 style="margin-left: 50px !important; margin-top: 20px !important; font-size:30px; font-weight:bold;">Elite Protocol Dashboard</h1>

    <div class="py-12 bg-[#F8FAFC]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-gradient-to-r from-slate-50 to-white">
                    <div>
                        <h3 class="text-2xl font-black text-slate-800 tracking-tight">Authorized Elite Nodes</h3>
                        <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mt-1">Real-time Credit Shield Applications</p>
                    </div>
                    <div class="px-5 py-2.5 bg-[#0346cbff] text-white rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-blue-200">
                        {{ \App\Models\EliteApplication::count() }} Total Requests
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left border-collapse">
                        <thead>
                            <tr class="text-[10px] text-slate-400 font-black uppercase tracking-[2px] bg-slate-50/50">
                                <th class="px-8 py-5">Customer Node</th>
                                <th class="px-8 py-5">Verified Score</th>
                                <th class="px-8 py-5">Unlocked Yield</th>
                                <th class="px-8 py-5">Sanction Limit</th>
                                <th class="px-8 py-5">Protocol Status</th>
                                <th class="px-8 py-5 text-right">Timestamp</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse(\App\Models\EliteApplication::with('user')->orderBy('created_at', 'desc')->get() as $app)
                                <tr class="hover:bg-slate-50/80 transition-all duration-300">
                                    <td class="px-8 py-6">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#0346cbff] flex items-center justify-center font-black text-xs mr-4 border border-blue-100 uppercase excerpt">
                                                {{ substr($app->user->name ?? '?', 0, 2) }}
                                            </div>
                                            <div>
                                                <p class="font-black text-slate-800 leading-tight">{{ $app->user->name ?? 'External Node' }}</p>
                                                <p class="text-[10px] text-slate-400 font-bold uppercase">{{ $app->user->phone ?? 'Unknown ID' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <span class="px-3 py-1.5 bg-emerald-50 text-emerald-600 rounded-lg text-xs font-black border border-emerald-100">
                                            {{ $app->score ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-6 font-black text-slate-700">
                                        {{ $app->interest_rate ?? 'N/A' }}%
                                        <span class="text-[10px] text-slate-400 font-normal uppercase ml-1">p.a.</span>
                                    </td>
                                    <td class="px-8 py-6">
                                        <span class="text-slate-800 font-black">₹ {{ $app->loan_limit ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-8 py-6">
                                         <div class="flex items-center">
                                             @if($app->status === 'APPROVED')
                                                 <div class="w-2 h-2 rounded-full bg-emerald-500 mr-2"></div>
                                                 <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">Verified Node</span>
                                             @elseif($app->status === 'REJECTED')
                                                 <div class="w-2 h-2 rounded-full bg-rose-500 mr-2"></div>
                                                 <span class="text-[10px] font-black text-rose-600 uppercase tracking-widest">Protocol Denied</span>
                                             @else
                                                 <div class="w-2 h-2 rounded-full bg-amber-400 animate-pulse mr-2"></div>
                                                 <span class="text-[10px] font-black text-amber-600 uppercase tracking-widest">Awaiting Verification</span>
                                             @endif
                                         </div>
                                     </td>
                                     <td class="px-8 py-6 text-right">
                                         <div class="flex justify-end gap-2">
                                             @if($app->status === 'PENDING')
                                                 <form action="{{ route('admin.elite.update-status', $app->id) }}" method="POST">
                                                     @csrf
                                                     <input type="hidden" name="status" value="APPROVED">
                                                     <button type="submit" class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white transition-all flex items-center justify-center shadow-sm">
                                                         <i class="fa-solid fa-check text-xs"></i>
                                                     </button>
                                                 </form>
                                                 <form action="{{ route('admin.elite.update-status', $app->id) }}" method="POST">
                                                     @csrf
                                                     <input type="hidden" name="status" value="REJECTED">
                                                     <button type="submit" class="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white transition-all flex items-center justify-center shadow-sm">
                                                         <i class="fa-solid fa-xmark text-xs"></i>
                                                     </button>
                                                 </form>
                                             @else
                                                 <span class="text-[9px] font-black text-slate-300 uppercase italic">Archived</span>
                                             @endif
                                         </div>
                                     </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-8 py-20 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center mb-4 text-slate-200">
                                                <i class="fa-solid fa-folder-open text-3xl"></i>
                                            </div>
                                            <p class="text-slate-400 font-bold uppercase tracking-widest text-[10px]">No Elite Requests Found</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

<x-admin-layout>
    <div class="py-6 bg-[#E2E8F0] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-[#0346cbff] to-indigo-800 rounded-[2.5rem] p-10 mb-10 shadow-[0_20px_50px_-15px_rgba(3,70,203,0.3)] text-white relative overflow-hidden group">
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <h3 class="text-4xl font-black mb-2 tracking-tight">Withdrawal Hub</h3>
                        <p class="text-blue-100 font-medium opacity-90">Settle payout requests and manage node liquidity accurately.</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.wallet.download-pdf') }}" class="px-6 py-3 bg-white text-[#0346cbff] text-xs font-black rounded-2xl transition-all shadow-lg hover:scale-105 active:scale-95 flex items-center">
                            <i class="fa-solid fa-file-pdf mr-2"></i> Download Full History
                        </a>
                    </div>
                </div>
                <div class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 bg-white/10 rounded-full blur-3xl transition-transform duration-700 group-hover:scale-125"></div>
            </div>

            <!-- Alerts -->
            @if(session('success'))
                <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm font-bold flex items-center shadow-sm">
                    <i class="fa-solid fa-circle-check mr-2"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-100 text-rose-700 text-sm font-bold flex items-center shadow-sm">
                    <i class="fa-solid fa-circle-exclamation mr-2"></i> {{ session('error') }}
                </div>
            @endif

            <!-- Main Table Card -->
            <div class="bg-white rounded-[2.5rem] shadow-xl border border-white p-8 overflow-hidden group hover:border-[#0346cbff]/30 transition-all duration-500">
                <div class="mb-8 flex items-center justify-between">
                    <div>
                        <h4 class="text-2xl font-black text-slate-900 tracking-tight">Payout Registry</h4>
                        <p class="text-slate-400 text-sm font-medium mt-1 uppercase tracking-widest text-[10px]">Processing withdrawal requests from partners & employees</p>
                    </div>
                    <!-- Search could go here if managed via JS, but you asked for normal pagination/search -->
                    <!-- We'll use DataTables for consistent 'compact' design and search -->
                </div>

                <div class="overflow-x-auto">
                    <table id="walletTable" class="w-full text-[13px] text-left border-separate border-spacing-y-2">
                        <thead>
                            <tr class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                <th class="px-5 py-3 whitespace-nowrap">Beneficiary Node</th>
                                <th class="px-5 py-3 whitespace-nowrap">Financial Target (Bank)</th>
                                <th class="px-5 py-3 whitespace-nowrap">Amount</th>
                                <th class="px-5 py-3 whitespace-nowrap">Status</th>
                                <th class="px-5 py-3 whitespace-nowrap">Request Date</th>
                                <th class="px-5 py-3 text-right whitespace-nowrap">Operations</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-transparent">
                            @foreach($transactions as $tx)
                                <tr class="bg-slate-50/50 hover:bg-white hover:shadow-2xl hover:shadow-slate-200/50 transition-all duration-300 rounded-[2rem] group/row">
                                    <td class="px-5 py-3">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-[#0346cbff] text-sm font-black italic shadow-sm">
                                                {{ strtoupper(substr($tx->user->name, 0, 1)) }}
                                            </div>
                                            <div class="ml-4">
                                                <div class="font-black text-slate-900 text-sm leading-tight">{{ $tx->user->name }}</div>
                                                <div class="text-[9px] font-black text-slate-400 mt-0.5 uppercase tracking-widest">{{ $tx->user->phone }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-3">
                                        @if($tx->user->bank_name)
                                            <div class="text-slate-800 font-bold leading-tight">{{ $tx->user->bank_name }}</div>
                                            <div class="text-[10px] text-slate-500 font-medium">A/C: {{ $tx->user->account_number }}</div>
                                        @else
                                            <span class="text-rose-500 text-[10px] font-black uppercase tracking-widest italic">MISSING BANK DATA</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3">
                                        <div class="font-black text-[#0346cbff] text-base">₹{{ number_format($tx->amount, 2) }}</div>
                                    </td>
                                    <td class="px-5 py-3">
                                        @if($tx->status === 'COMPLETED')
                                            <span class="px-3 py-1 bg-emerald-500/10 text-emerald-600 rounded-lg text-[9px] font-black uppercase tracking-widest border border-emerald-500/10">COMPLETED</span>
                                        @elseif($tx->status === 'FAILED')
                                            <span class="px-3 py-1 bg-rose-500/10 text-rose-600 rounded-lg text-[9px] font-black uppercase tracking-widest border border-rose-500/10">FAILED</span>
                                        @else
                                            <span class="px-3 py-1 bg-amber-500/10 text-amber-600 rounded-lg text-[9px] font-black uppercase tracking-widest border border-amber-500/10">PENDING</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3 text-slate-400 font-bold whitespace-nowrap">
                                        {{ $tx->created_at->format('d M, Y') }}<br/>
                                        <span class="text-[10px]">{{ $tx->created_at->format('h:i A') }}</span>
                                    </td>
                                    <td class="px-5 py-3 text-right">
                                        <div class="flex justify-end gap-2 items-center">
                                            @if($tx->status === 'PENDING')
                                                <form action="{{ route('admin.wallet.updateStatus', $tx->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="status" value="COMPLETED">
                                                    <button type="submit" class="px-4 py-1.5 bg-emerald-500 text-white text-[10px] font-black rounded-lg shadow-emerald-200 shadow-lg hover:translate-y-[-2px] transition-all uppercase tracking-widest" onclick="return confirm('Commit settlement for this node?')">SETTLE</button>
                                                </form>
                                                <form action="{{ route('admin.wallet.updateStatus', $tx->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="status" value="FAILED">
                                                    <button type="submit" class="w-8 h-8 flex items-center justify-center bg-rose-50 text-rose-500 rounded-lg hover:bg-rose-500 hover:text-white transition-all shadow-sm" onclick="return confirm('Purge settlement request?')">
                                                        <i class="fa-solid fa-xmark text-xs"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('admin.wallet.download-pdf', ['id' => $tx->id]) }}" class="w-8 h-8 flex items-center justify-center bg-slate-50 text-slate-500 rounded-lg hover:bg-[#0346cbff] hover:text-white transition-all shadow-sm" title="Download Transaction Slip">
                                                <i class="fa-solid fa-download text-xs"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-8 px-4 py-4 bg-slate-50 rounded-[1.5rem] border border-slate-100">
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Datatables for Search functionality while keeping pagination -->
    <script>
        $(document).ready(function() {
            var table = $('#walletTable').DataTable({
                layout: {
                    topStart: 'search',
                    topEnd: null // We have our own download button in header
                },
                paging: false, // Keep Laravel simple pagination
                info: false,
                ordering: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search beneficiaries / amounts...",
                },
                columnDefs: [
                    { orderable: false, targets: 5 }
                ],
                destroy: true
            });

            setTimeout(() => {
                $('.dt-search input').addClass('px-5 py-2.5 bg-white border border-slate-200 rounded-xl shadow-sm text-sm font-medium focus:ring-4 focus:ring-[#0346cbff]/10 focus:border-[#0346cbff] transition-all w-72 outline-none');
            }, 100);
        });
    </script>
</x-admin-layout>

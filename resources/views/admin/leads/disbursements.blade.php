<x-admin-layout>
    <style>
        .gradient-header {
            background: linear-gradient(135deg, #0f172a 0%, #0346cb 100%);
            border-radius: 3rem;
            padding: 3rem 4rem;
            margin-bottom: -4rem; 
            position: relative;
            z-index: 1;
            box-shadow: 0 20px 25px -5px rgba(3, 70, 203, 0.2);
        }
        .content-card {
            background: #ffffff;
            border-radius: 3.5rem;
            padding: 3rem 1.5rem 1.5rem 1.5rem;
            position: relative;
            z-index: 0;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            margin-top: 90px;
        }
        #disbursementsTable thead th {
            background: #f8fafc !important;
            color: #475569 !important;
            font-size: 10px !important;
            font-weight: 900 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.1em !important;
            padding: 1.2rem 1.5rem !important;
            border-bottom: 2px solid #f1f5f9 !important;
        }
        #disbursementsTable tbody td {
            padding: 1.5rem !important;
            vertical-align: middle;
            border-bottom: 1px solid #f8fafc;
        }
    </style>

    <div class="px-6 py-8 min-h-screen bg-slate-50">
        <!-- HEADER -->
        <div class="gradient-header flex justify-between items-center text-white">
            <div>
                <h1 class="text-4xl font-black tracking-tight uppercase">Disbursements & Commissions</h1>
                <p class="text-white/70 font-bold uppercase text-[10px] tracking-widest mt-2">Verified Loan Payouts & Agent Yield Tracking</p>
            </div>
            <div class="flex gap-6">
                <div class="text-right">
                    <p class="text-white/40 text-[9px] font-black uppercase tracking-widest mb-1">Total Disbursed</p>
                    <p class="text-2xl font-black text-emerald-400">₹{{ number_format($leads->sum('disbursed_amount'), 2) }}</p>
                </div>
            </div>
        </div>

        <!-- TABLE CARD -->
        <div class="content-card">
            <div class="mb-8 px-4 flex justify-between items-end">
                <div>
                    <h2 class="text-2xl font-black text-slate-900 tracking-tight">Financial Closure Registry</h2>
                    <p class="text-slate-400 text-[10px] font-black uppercase tracking-[3px] mt-1">Authorized Disbursement Nodes</p>
                </div>
                <div class="bg-indigo-50 px-6 py-3 rounded-2xl border border-indigo-100 hidden md:block">
                    <p class="text-[9px] font-black text-indigo-400 uppercase mb-1">Total Commissions</p>
                    @php 
                        $totalComm = 0;
                        foreach($leads as $l) {
                            $totalComm += \App\Models\WalletTransaction::where('description', $l->id)->sum('amount');
                        }
                    @endphp
                    <p class="text-xl font-black text-indigo-700">₹{{ number_format($totalComm, 2) }}</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left" id="disbursementsTable">
                    <thead>
                        <tr>
                            <th>Customer / Lead ID</th>
                            <th>Agent Node</th>
                            <th>Disbursed Details</th>
                            <th>Tenure</th>
                            <th>Commission Paid</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leads as $lead)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td>
                                    <p class="font-black text-slate-900 text-sm tracking-tight">{{ $lead->customer_name }}</p>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase">#LL-{{ $lead->id }} • {{ $lead->loan_type }}</p>
                                </td>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-[10px] font-black text-slate-400">
                                            {{ strtoupper($lead->user->name[0] ?? '?') }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-800 text-xs">{{ $lead->user->name ?? 'SYSTEM' }}</p>
                                            <p class="text-[8px] font-black {{ ($lead->user->role ?? '') == 'PARTNER' ? 'text-emerald-500' : 'text-indigo-400' }} uppercase">{{ $lead->user->role ?? 'ADMIN' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="font-black text-emerald-600 text-sm">₹{{ number_format($lead->disbursed_amount ?: $lead->loan_amount, 2) }}</p>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase">Authenticated Value</p>
                                </td>
                                <td>
                                    <span class="px-3 py-1 bg-slate-100 text-slate-600 text-[10px] font-black rounded-lg uppercase tracking-widest border border-slate-200">
                                        {{ $lead->tenure_months ?: 'N/A' }} Months
                                    </span>
                                </td>
                                <td>
                                    @php 
                                        $comm = \App\Models\WalletTransaction::where('description', $lead->id)->sum('amount');
                                    @endphp
                                    <p class="font-black text-indigo-600 text-sm">₹{{ number_format($comm, 2) }}</p>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase">Wallet Credit Sync</p>
                                </td>
                                <td>
                                    <a href="{{ route('admin.leads.show', $lead) }}" class="w-10 h-10 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center hover:bg-slate-900 hover:text-white transition-all shadow-sm">
                                        <i class="fa-solid fa-arrow-right-long"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-20 text-center">
                                    <p class="text-slate-300 font-black uppercase text-sm tracking-[5px]">No Disbursement Nodes Detected</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#disbursementsTable').DataTable({
                "pageLength": 10,
                "ordering": true,
                "info": false,
                "language": {
                    "search": "",
                    "searchPlaceholder": "Filter financial nodes..."
                }
            });
            $('.dataTables_filter input').addClass('bg-white border-slate-200 rounded-2xl py-2 px-6 text-sm outline-none focus:ring-2 focus:ring-blue-500 transition-all w-64');
        });
    </script>
</x-admin-layout>

<x-admin-layout>

    <div class="py-6 bg-[#E2E8F0] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Colorful Header Section -->
            <div class="bg-gradient-to-r from-[#0346cbff] to-indigo-800 rounded-[2.5rem] p-10 mb-10 shadow-[0_20px_50px_-15px_rgba(3,70,203,0.3)] text-white relative overflow-hidden group">
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <h3 class="text-4xl font-black mb-2 tracking-tight">Customer Repository</h3>
                        <p class="text-blue-100 font-medium opacity-90">Manage client profiles, loan histories, and identity nodes.</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.customers.download-pdf') }}" class="px-6 py-3 bg-white text-[#0346cbff] text-xs font-black rounded-2xl transition-all shadow-lg hover:scale-105 active:scale-95 flex items-center">
                            <i class="fa-solid fa-file-pdf mr-2"></i> Download PDF
                        </a>
                    </div>
                </div>
                <!-- Decorative Blobs -->
                <div class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 bg-white/10 rounded-full blur-3xl transition-transform duration-700 group-hover:scale-125"></div>
                <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-60 h-60 bg-blue-400/20 rounded-full blur-3xl"></div>
            </div>

            <!-- Table Card -->
            <div class="bg-white rounded-[2.5rem] shadow-xl border border-white p-8 overflow-hidden group hover:border-[#0346cbff]/30 transition-all duration-500">
                <div class="mb-8 flex items-center justify-between">
                    <div>
                        <h4 class="text-2xl font-black text-slate-900 tracking-tight">Active Customers</h4>
                        <p class="text-slate-400 text-sm font-medium mt-1 uppercase tracking-widest text-[10px]">Total {{ $customers->count() }} entities registered</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table id="customersTable" class="w-full text-[13px] text-left border-separate border-spacing-y-2">
                        <thead>
                            <tr class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                <th class="px-5 py-3 whitespace-nowrap">Customer Identity</th>
                                <th class="px-5 py-3 whitespace-nowrap">Contact No</th>
                                <th class="px-5 py-3 whitespace-nowrap">Email Address</th>
                                <th class="px-5 py-3 whitespace-nowrap">Status</th>
                                <th class="px-5 py-3 whitespace-nowrap">Registration Date</th>
                                <th class="px-5 py-3 text-right whitespace-nowrap">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-transparent">
                            @forelse($customers as $customer)
                                <tr class="bg-slate-50/50 hover:bg-white hover:shadow-2xl hover:shadow-slate-200/50 transition-all duration-300 rounded-[2rem] group/row scale-100 hover:scale-[1.01]">
                                    <td class="px-5 py-3">
                                        <div class="flex items-center">
                                            <div class="w-11 h-11 rounded-xl bg-gradient-to-tr from-[#0346cbff] to-cyan-400 p-0.5 shadow-md relative overflow-hidden group-hover/row:rotate-3 transition-transform">
                                                <div class="w-full h-full rounded-xl bg-white flex items-center justify-center text-[#0346cbff] text-sm font-black italic">
                                                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="font-black text-slate-900 text-sm leading-tight">{{ $customer->name }}</div>
                                                <div class="text-[9px] font-black text-[#0346cbff] bg-[#0346cbff]/5 px-2 py-0.5 rounded-md mt-0.5 inline-block uppercase tracking-widest">ID: CST-{{ sprintf('%04d', $customer->id) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-3">
                                        <div class="text-slate-600 font-bold whitespace-nowrap">{{ $customer->phone }}</div>
                                    </td>
                                    <td class="px-5 py-3">
                                        <div class="text-slate-600 font-bold whitespace-nowrap">{{ $customer->email }}</div>
                                    </td>
                                    <td class="px-5 py-3">
                                        <span class="px-3 py-1 bg-emerald-500/10 text-emerald-600 rounded-lg text-[9px] font-black uppercase tracking-widest border border-emerald-500/10 inline-block">
                                            Active
                                        </span>
                                    </td>
                                    <td class="text-slate-500 font-bold">
                                        <div class="flex items-center whitespace-nowrap">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            {{ $customer->created_at ? $customer->created_at->format('d M, Y') : 'N/A' }}
                                        </div>
                                    </td>
                                    <td class="px-5 py-3 text-right">
                                        <div class="flex justify-end space-x-1.5">
                                            <a href="{{ route('admin.customers.show', $customer->id) }}" class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-[#0346cbff] hover:text-white transition-all shadow-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>
                                            <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" class="inline" onsubmit="return confirm('Terminate this customer node?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all shadow-sm">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-20 text-center">
                                         <div class="flex flex-col items-center justify-center">
                                            <div class="w-20 h-20 bg-slate-100 rounded-[2rem] flex items-center justify-center text-slate-300 mb-4">
                                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                            </div>
                                            <p class="text-slate-400 font-black text-lg">No Customers Found</p>
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

    <!-- Datatables config -->
    <script>
        $(document).ready(function() {
            var table = $('#customersTable').DataTable({
                layout: {
                    topStart: 'search',
                    topEnd: 'buttons'
                },
                buttons: [
                    
                    { extend: 'excel', text: '<i class="fas fa-file-excel mr-1"></i> Excel' },
                    { extend: 'print', text: '<i class="fas fa-print mr-1"></i> Print' }
                ],
                pageLength: 10,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search customers...",
                    paginate: {
                        previous: '<i class="fas fa-chevron-left"></i>',
                        next: '<i class="fas fa-chevron-right"></i>'
                    }
                },
                destroy: true
            });

            setTimeout(() => {
                $('.dt-search input').addClass('px-6 py-3 bg-white border border-slate-200 rounded-2xl shadow-sm text-sm font-medium focus:ring-4 focus:ring-[#0346cbff]/10 focus:border-[#0346cbff] transition-all w-80 outline-none');
                $('.dt-buttons').addClass('flex items-center gap-3');
            }, 100);
        });
    </script>
</x-admin-layout>

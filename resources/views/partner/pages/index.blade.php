<x-admin-layout>

    <div class="py-6 bg-[#E2E8F0] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Colorful Header Section -->
            <div class="bg-gradient-to-r from-[#0346cbff] to-indigo-800 rounded-[2.5rem] p-10 mb-10 shadow-[0_20px_50px_-15px_rgba(3,70,203,0.3)] text-white relative overflow-hidden group">
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <h3 class="text-4xl font-black mb-2 tracking-tight">Partner Directory</h3>
                        <p class="text-blue-100 font-medium opacity-90">Manage your partners, roles, and documents efficiently.</p>
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
                        <h4 class="text-2xl font-black text-slate-900 tracking-tight">Active Partners</h4>
                        <p class="text-slate-400 text-sm font-medium mt-1 uppercase tracking-widest text-[10px]">Total {{ $partners->count() }} members registered</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table id="partnersTable" class="w-full text-sm text-left border-separate border-spacing-y-4">
                        <thead>
                            <tr class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                <th class="px-6 py-4 whitespace-nowrap">Partner Identity</th>
                                <th class="px-6 py-4 whitespace-nowrap">Business Name</th>
                                <th class="px-6 py-4 whitespace-nowrap">Contact No</th>
                                <th class="px-6 py-4 whitespace-nowrap">Status</th>
                                <th class="px-6 py-4 whitespace-nowrap">Registration Date</th>
                                <th class="px-6 py-4 text-right whitespace-nowrap">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-transparent">
                            @forelse($partners as $partner)
                                <tr class="bg-slate-50/50 hover:bg-white hover:shadow-2xl hover:shadow-slate-200/50 transition-all duration-300 rounded-[2rem] group/row scale-100 hover:scale-[1.01]">
                                    <td >
                                        <div class="flex items-center">
                                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-[#0346cbff] to-cyan-400 p-0.5 shadow-lg relative overflow-hidden group-hover/row:rotate-3 transition-transform">
                                                <div class="w-full h-full rounded-2xl bg-white flex items-center justify-center text-[#0346cbff] text-xl font-black italic">
                                                    {{ strtoupper(substr($partner->name, 0, 1)) }}
                                                </div>
                                            </div>
                                            <div class="ml-5">
                                                <div class="font-black text-slate-900 text-base leading-tight">{{ $partner->name }}</div>
                                                <div class="text-[10px] font-black text-[#0346cbff] bg-[#0346cbff]/5 px-2 py-0.5 rounded-md mt-1 inline-block uppercase tracking-widest">ID: PARTNER-{{ $partner->id ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td >
                                        <div class="text-slate-600 font-bold whitespace-nowrap">{{ $partner->employeeDetail->business_name ?? 'N/A' }}</div>
                                    </td>
                                    <td >
                                        <div class="text-slate-600 font-bold whitespace-nowrap">{{ $partner->phone }}</div>
                                    </td>
                                    <td >
                                        @if($partner->status === 'APPROVED')
                                            <span class="px-4 py-1.5 bg-emerald-500/10 text-emerald-600 rounded-xl text-[10px] font-black uppercase tracking-widest border border-emerald-500/10 inline-block">
                                                Approved
                                            </span>
                                        @elseif($partner->status === 'REJECTED')
                                            <span class="px-4 py-1.5 bg-rose-500/10 text-rose-600 rounded-xl text-[10px] font-black uppercase tracking-widest border border-rose-500/10 inline-block">
                                                Rejected
                                            </span>
                                        @else
                                            <span class="px-4 py-1.5 bg-amber-500/10 text-amber-600 rounded-xl text-[10px] font-black uppercase tracking-widest border border-amber-500/10 inline-block animate-pulse">
                                                Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-slate-500 font-bold">
                                        <div class="flex items-center whitespace-nowrap">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            {{ $partner->created_at ? $partner->created_at->format('d M, Y') : 'N/A' }}
                                        </div>
                                    </td>
                                    <td class=" rounded-r-[1.5rem] text-right">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('admin.partners.show', $partner->id) }}" class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-[#0346cbff] hover:text-white transition-all shadow-sm">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>
                                            <form action="{{ route('admin.partners.destroy', $partner->id) }}" method="POST" class="inline" onsubmit="return confirm('Archive this partner?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all shadow-sm">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
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
                                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                            </div>
                                            <p class="text-slate-400 font-black text-lg">No Partners Found</p>
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

    <!-- Datatables config matching employee design exactly -->
    <script>
        $(document).ready(function() {
            var table = $('#partnersTable').DataTable({
                layout: {
                    topStart: 'search',
                    topEnd: 'buttons'
                },
                buttons: [
                    {
                        extend: 'copy',
                        text: '<i class="fas fa-copy mr-1"></i> Copy'
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel mr-1"></i> Excel'
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf mr-1"></i> PDF'
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print mr-1"></i> Print'
                    }
                ],
                pageLength: 10,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search records...",
                    paginate: {
                        previous: '<i class="fas fa-chevron-left"></i>',
                        next: '<i class="fas fa-chevron-right"></i>'
                    }
                },
                columnDefs: [
                    { orderable: false, targets: 4 }
                ],
                destroy: true
            });

            setTimeout(() => {
                $('.dt-search input').addClass('px-6 py-3 bg-white border border-slate-200 rounded-2xl shadow-sm text-sm font-medium focus:ring-4 focus:ring-[#0346cbff]/10 focus:border-[#0346cbff] transition-all w-80 outline-none');
                $('.dt-buttons').addClass('flex items-center gap-3');
            }, 100);
        });
    </script>
</x-admin-layout>

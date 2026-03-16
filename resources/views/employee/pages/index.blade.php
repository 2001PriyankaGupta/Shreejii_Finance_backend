<x-admin-layout>

<style>
   td{
    font-size: 12px !important;
   }
   th{
    font-size: 12px !important;
   }
</style>
  
    <div class="py-6 bg-[#E2E8F0] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Colorful Header Section -->
            <div class="bg-gradient-to-r from-[#0346cbff] to-indigo-800 rounded-[2rem] p-8 mb-6 shadow-[0_15px_40px_-15px_rgba(3,70,203,0.3)] text-white relative overflow-hidden group">
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-3xl font-black mb-1 tracking-tight">Employee Directory</h3>
                        <p class="text-blue-100 text-sm font-medium opacity-90">Manage your workforce, roles, and documents efficiently.</p>
                    </div>
                    <a href="{{ route('admin.employees.create') }}" class="inline-flex items-center px-6 py-3 bg-white text-[#0346cbff] text-sm font-black rounded-xl transition-all shadow-xl hover:scale-105 active:scale-95 group-hover:shadow-white/20">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                         Onboard Employee
                    </a>
                </div>
                <!-- Decorative Blobs -->
                <div class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 bg-white/10 rounded-full blur-3xl transition-transform duration-700 group-hover:scale-125"></div>
                <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-60 h-60 bg-blue-400/20 rounded-full blur-3xl"></div>
            </div>



            <!-- Table Card -->
            <div class="bg-white rounded-[2rem] shadow-xl border border-white p-6 overflow-hidden group hover:border-[#0346cbff]/30 transition-all duration-500">
                <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h4 class="text-xl font-black text-slate-900 tracking-tight">Active Employees</h4>
                        <p class="text-slate-400 text-[9px] font-medium mt-0.5 uppercase tracking-widest">Total {{ $employees->count() }} members registered</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.employees.download-pdf') }}" class="inline-flex items-center px-5 py-2.5 bg-rose-50 text-rose-600 text-[11px] font-black rounded-lg transition-all shadow-sm hover:bg-rose-600 hover:text-white group">
                            <svg class="w-3.5 h-3.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Download Repo PDF
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table id="employeeTable" class="w-full text-sm text-left border-separate border-spacing-y-4">
                        <thead>
                            <tr class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                <th class="px-6 py-4">Employee Details</th>
                                <th class="px-6 py-4">Contact Info</th>
                                <th class="px-6 py-4">Designation</th>
                                <th class="px-6 py-4">Joining Date</th>
                                <th class="px-6 py-4 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-transparent">
                            @forelse($employees as $employee)
                                <tr class="bg-slate-50/50 hover:bg-white hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300 rounded-[1.5rem] group/row scale-100 hover:scale-[1.005]">
                                    <td class="px-4 py-4 rounded-l-[1.2rem]">
                                        <div class="flex items-center">
                                            <div class="w-11 h-11 rounded-xl bg-gradient-to-tr from-[#0346cbff] to-cyan-400 p-0.5 shadow-md relative overflow-hidden group-hover/row:rotate-2 transition-transform">
                                                <div class="w-full h-full rounded-xl bg-white flex items-center justify-center text-[#0346cbff] text-base font-black italic">
                                                    @if($employee->avatar_url)
                                                        <img src="{{ asset('storage/' . $employee->avatar_url) }}" class="w-full h-full object-cover rounded-xl">
                                                    @else
                                                        {{ strtoupper(substr($employee->name, 0, 1)) }}
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="font-black text-slate-900 text-[13px] leading-tight">{{ $employee->name }}</div>
                                                <div class="text-[8px] font-black text-[#0346cbff] bg-[#0346cbff]/5 px-2 py-0.5 rounded-md mt-1 inline-block uppercase tracking-widest">ID: {{ $employee->employee_id ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="text-slate-600 font-bold text-[11px]">{{ $employee->email }}</div>
                                        <div class="text-[9px] font-black text-slate-400 tracking-wider">{{ $employee->phone }}</div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <span class="px-3 py-1 bg-indigo-500/5 text-indigo-600 rounded-lg text-[9px] font-black uppercase tracking-widest border border-indigo-500/5 mb-1 inline-block">
                                            {{ $employee->employeeDetail?->designation ?? 'UNASSIGNED' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-slate-500 font-bold text-[11px]">
                                        <div class="flex items-center">
                                            <svg class="w-3.5 h-3.5 mr-1.5 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            {{ ($employee->employeeDetail && $employee->employeeDetail->joining_date) ? date('d M, Y', strtotime($employee->employeeDetail->joining_date)) : 'N/A' }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 rounded-r-[1.2rem] text-right">
                                        <div class="flex justify-end space-x-1.5 text-[2px]">
                                            <a href="{{ route('admin.employees.show', $employee->id) }}" class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-[#0346cbff] hover:text-white transition-all shadow-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>
                                            <a href="{{ route('admin.employees.edit', $employee->id) }}" class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center hover:bg-amber-500 hover:text-white transition-all shadow-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                            <form action="{{ route('admin.employees.destroy', $employee->id) }}" method="POST" class="inline" onsubmit="return confirm('Archive this employee?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all shadow-sm">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-20 text-center">
                                         <div class="flex flex-col items-center justify-center">
                                            <div class="w-20 h-20 bg-slate-100 rounded-[2rem] flex items-center justify-center text-slate-300 mb-4">
                                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                            </div>
                                            <p class="text-slate-400 font-black text-lg">No Employees Found</p>
                                            <a href="{{ route('admin.employees.create') }}" class="text-[#0346cbff] font-black underline mt-2">Hire your first employee</a>
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

    <script>
        $(document).ready(function() {
            $('#employeeTable').DataTable({
                layout: {
                    topStart: 'search',
                    topEnd: 'buttons'
                },
                buttons: [
                    {
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel mr-1"></i> Excel',
                        exportOptions: { columns: [0, 1, 2, 3] }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print mr-1"></i> Print',
                        exportOptions: { columns: [0, 1, 2, 3] }
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
                ]
            });

            // Refined search input styling
            $('.dt-search input').addClass('px-6 py-3 bg-white border border-slate-200 rounded-2xl shadow-sm text-sm font-medium focus:ring-4 focus:ring-[#0346cbff]/10 focus:border-[#0346cbff] transition-all w-80 outline-none');
            $('.dt-buttons').addClass('flex items-center gap-3');
        });
    </script>
</x-admin-layout>

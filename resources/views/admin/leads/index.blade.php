<x-admin-layout>
    <style>
        /* Gradient Header Card */
        .gradient-header {
            background: linear-gradient(135deg, #0346cbff 0%, #1e1b4b 100%);
            border-radius: 3rem;
            padding: 3rem 4rem;
            margin-bottom: -4rem; 
            position: relative;
            z-index: 1;
            box-shadow: 0 20px 25px -5px rgba(3, 70, 203, 0.2);
        }

        /* Main Content White Card */
        .content-card {
            background: #ffffff;
            border-radius: 3.5rem;
            padding: 3rem 1.5rem 1.5rem 1.5rem;
            position: relative;
            z-index: 0;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            margin-top: 90px;
        }

        /* DataTables Custom Controls Styling */
        .dt-custom-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 1rem;
            margin-bottom: 1rem;
        }

        .search-wrapper input {
            background: #f8fafc !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 1rem !important;
            padding: 0.7rem 1.2rem !important;
            width: 280px !important;
            font-size: 13px !important;
            font-weight: 500 !important;
            color: #1e293b !important;
            outline: none !important;
            transition: all 0.3s ease;
        }
        .search-wrapper input:focus {
            border-color: #0346cbff !important;
            box-shadow: 0 0 0 3px rgba(3, 70, 203, 0.1) !important;
        }

        /* Dropdown Styling */
        .export-dropdown {
            position: relative;
            display: inline-block;
        }

        .dots-btn {
            background: #ffffffff;
            border: 1px solid #e2e8f0;
            width: 45px;
            height: 48px;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }

        .dots-btn:hover {
            background: #f8fafc;
            color: #1e293b;
            border-color: #cbd5e1;
        }

        .dropdown-menu {
            position: absolute;
            top: 110%;
            right: 0;
            background: #ffffff;
            border-radius: 1.2rem;
            box-shadow: 0 15px 30px -5px rgba(0, 0, 0, 0.15);
            border: 1px solid #f1f5f9;
            padding: 0.6rem;
            min-width: 190px;
            display: none;
            z-index: 100;
        }

        .dropdown-menu.show {
            display: block;
            animation: slideIn 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Hide original DataTables buttons */
        .dt-buttons {
            display: none !important;
        }

        .dropdown-item-custom {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.7rem 1rem;
            color: #475569;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-radius: 0.8rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .dropdown-item-custom:hover {
            background: #f1f5f9;
            color: #0346cbff;
        }

        /* Table Styling */
        #leadsTable {
            width: 100% !important;
            border-collapse: separate !important;
            border-spacing: 0 8px !important;
        }

        #leadsTable thead th {
            background: #1e293b !important;
            color: #ffffff !important;
            font-size: 11px !important;
            font-weight: 900 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.1em !important;
            padding: 1rem 1.5rem !important;
            border: none !important;
        }

        #leadsTable thead th:first-child { border-top-left-radius: 1rem; border-bottom-left-radius: 1rem; }
        #leadsTable thead th:last-child { border-top-right-radius: 1rem; border-bottom-right-radius: 1rem; }

        #leadsTable tbody td {
            background: #ffffff !important;
            padding: 1rem 1.5rem !important;
            border-top: 1px solid #f1f5f9 !important;
            border-bottom: 1px solid #f1f5f9 !important;
            vertical-align: middle;
        }

        #leadsTable tbody tr td:first-child { border-left: 1px solid #f1f5f9 !important; border-top-left-radius: 1.2rem; border-bottom-left-radius: 1.2rem; }
        #leadsTable tbody tr td:last-child { border-right: 1px solid #f1f5f9 !important; border-top-right-radius: 1.2rem; border-bottom-right-radius: 1.2rem; }

        #leadsTable tbody tr {
            transition: transform 0.2s ease;
        }

        #leadsTable tbody tr:hover {
            transform: scale(1.002);
            box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        }

        /* Action Icons */
        .action-icon-btn {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }
        .view-btn { background: #eff6ff; color: #3b82f6; }
        .delete-btn { background: #fef2f2; color: #ef4444; }

        /* Badge Styling */
        .status-badge {
            font-size: 9px;
            font-weight: 900;
            padding: 0.4rem 1rem;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }
    </style>

    <div class="px-6 py-8 min-h-screen" style="background-color: #d9d9d9ff;">
        <!-- TOP GRADIENT HEADER CARD -->
        <div class="gradient-header flex justify-between items-center text-white">
            <div>
                <h1 class="text-4xl font-black tracking-tight uppercase">Lead Management</h1>
                <p class="text-white/80 font-bold uppercase text-[10px] tracking-widest mt-2">Operational Pipeline Node & Control Interface</p>
            </div>
            <div class="hidden lg:flex items-center gap-6">
                <div class="text-right">
                    <p class="text-white/40 text-[9px] font-black uppercase tracking-widest mb-1">Total Payload</p>
                    <p class="text-2xl font-black">{{ $leads->count() }} NODES</p>
                </div>
                <div class="w-14 h-14 rounded-3xl bg-white/10 border border-white/20 flex items-center justify-center text-2xl">
                    <i class="fa-solid fa-microchip text-white/50"></i>
                </div>
            </div>
        </div>

        <!-- MAIN CONTENT WHITE CARD -->
        <div class="content-card">
            
            <!-- FILTERS SECTION WITH 3-DOTS ON RIGHT -->
            <div class="mb-6 px-4">
                <div class="flex flex-wrap items-end justify-between gap-6 border-b border-slate-50">
                    <form action="{{ route('admin.leads.index') }}" method="GET" class="flex flex-wrap items-end gap-5 flex-1">
                        <div style="width: 280px;"> {{-- Balanced width --}}
                            <label class="block text-[10px] font-black uppercase tracking-widest text-[#1e293b] mb-2 ml-4">Agent Node</label>
                            <select name="user_id" class="w-full bg-white border border-gray-200 rounded-2xl py-3 px-5 focus:ring-2 focus:ring-[#0346cbff] transition-all font-bold text-gray-800 shadow-sm appearance-none cursor-pointer">
                                <option value="">All Agents (Emp/Partner)</option>
                                <optgroup label="Employees">
                                    @foreach($employees as $emp)
                                        <option value="{{ $emp->id }}" {{ request('user_id') == $emp->id || request('employee_id') == $emp->id ? 'selected' : '' }}>
                                            {{ $emp->name }}
                                        </option>
                                    @endforeach
                                </optgroup>
                                <optgroup label="Partners">
                                    @foreach($partners as $partner)
                                        <option value="{{ $partner->id }}" {{ request('user_id') == $partner->id ? 'selected' : '' }}>
                                            {{ $partner->name }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                        <div style="width: 262px;"> {{-- Reduced width for Status Filter --}}
                            <label class="block text-[10px] font-black uppercase tracking-widest text-[#1e293b] mb-2 ml-4">Status Protocol</label>
                            <select name="status" class="w-full bg-white border border-gray-200 rounded-2xl py-3 px-5 focus:ring-2 focus:ring-[#0346cbff] transition-all font-bold text-gray-800 shadow-sm appearance-none cursor-pointer">
                                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Statuses</option>
                                @foreach(['OPEN', 'PENDING', 'APPROVED', 'REJECTED'] as $s)
                                    <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="bg-[#0346cbff] text-white font-black px-8 py-3 rounded-2xl hover:bg-[#0F172A] transition-all uppercase tracking-widest text-[10px] shadow-lg shadow-blue-100">Sync</button>
                            <a href="{{ route('admin.leads.index') }}" class="bg-slate-100 text-slate-400 font-black px-5 py-3 rounded-2xl hover:bg-slate-200 transition-all uppercase tracking-widest text-[10px]">Reset</a>
                        </div>
                    </form>

                    <!-- Export Dropdown on Right Side of Filters -->
                    <div class="export-dropdown">
                        <button class="dots-btn" id="dotsBtn" type="button">
                            <i class="fa-solid fa-ellipsis-vertical text-lg"></i>
                        </button>
                        <div class="dropdown-menu" id="exportDropdown">
                            <div class="dropdown-item-custom" onclick="triggerDTButton('copy')">
                                <i class="fa-solid fa-copy w-5 text-indigo-500"></i> Copy Pipeline
                            </div>
                            <div class="dropdown-item-custom" onclick="triggerDTButton('excel')">
                                <i class="fa-solid fa-file-excel w-5 text-emerald-500"></i> Export Excel
                            </div>
                            <div class="dropdown-item-custom" onclick="triggerDTButton('pdf')">
                                <i class="fa-solid fa-file-pdf w-5 text-rose-500"></i> Export PDF
                            </div>
                            <div class="dropdown-item-custom" onclick="triggerDTButton('print')">
                                <i class="fa-solid fa-print w-5 text-slate-500"></i> Print View
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DATATABLES HEADER (Just Search now) -->
            <div class="dt-custom-header">
                <div id="dtSearchContainer" class="search-wrapper"></div>
            </div>

            <!-- TABLE -->
            <div class="overflow-x-auto">
                <table class="w-full text-left" id="leadsTable">
                    <thead>
                        <tr>
                            <th>Customer Identity</th>
                            <th>Contact Sequences</th>
                            <th>Admin Node</th>
                            <th>Category</th>
                            <th>Protocol Status</th>
                            <th>Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leads as $lead)
                            <tr>
                                <td>
                                    <div class="flex items-center gap-4">
                                       
                                        <div>
                                            <p class="font-black text-gray-900 uppercase tracking-tight leading-none text-[13px]">{{ $lead->customer_name }}</p>
                                            <p class="text-[8px] font-black text-blue-400 mt-1 uppercase tracking-widest">ID: #LL-{{ $lead->id }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="font-black text-gray-900 text-xs tracking-tight">{{ $lead->mobile_number }}</p>
                                    <p class="text-[9px] font-bold text-gray-400 uppercase">{{ $lead->city }}</p>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center text-[8px] font-black text-slate-400 border border-slate-200">
                                            {{ strtoupper($lead->user->name[0] ?? '?') }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900 text-[11px] leading-tight mb-0.5">{{ $lead->user->name ?? 'System' }}</p>
                                            <p class="text-[7px] font-black {{ ($lead->user->role ?? '') == 'PARTNER' ? 'text-emerald-500' : 'text-slate-400' }} uppercase tracking-widest">{{ $lead->user->role ?? 'ADMIN' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="px-2.5 py-1 bg-slate-50 text-slate-500 text-[8px] font-black rounded-md border border-slate-100 uppercase tracking-widest">
                                        {{ $lead->loan_type }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $statusStyles = [
                                            'OPEN' => 'bg-blue-50 text-blue-600 border border-blue-100',
                                            'PENDING' => 'bg-amber-50 text-amber-600 border border-amber-100',
                                            'APPROVED' => 'bg-emerald-50 text-emerald-600 border border-emerald-100',
                                            'REJECTED' => 'bg-rose-50 text-rose-600 border border-rose-100',
                                        ][$lead->status] ?? 'bg-slate-50 text-slate-600 border border-slate-100';
                                    @endphp
                                    <span class="status-badge {{ $statusStyles }}">
                                        {{ $lead->status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.leads.show', $lead) }}" class="action-icon-btn view-btn shadow-sm" title="View Detail">
                                            <i class="fa-solid fa-arrow-right-long text-xs"></i>
                                        </a>
                                        <form action="{{ route('admin.leads.destroy', $lead) }}" method="POST" onsubmit="return confirm('Purge this lead node?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-icon-btn delete-btn shadow-sm" title="Delete">
                                                <i class="fa-solid fa-xmark text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-16 text-center text-slate-300 font-black uppercase text-[9px] tracking-widest">
                                    Pipeline is currently empty
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function triggerDTButton(action) {
            if(action === 'copy') $('.buttons-copy').click();
            if(action === 'excel') $('.buttons-excel').click();
            if(action === 'pdf') $('.buttons-pdf').click();
            if(action === 'print') $('.buttons-print').click();
            $('#exportDropdown').removeClass('show');
        }

        $(document).ready(function() {
            var table = $('#leadsTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'pdf', 'print'
                ],
                "pageLength": 10,
                "ordering": true,
                "info": false,
                "language": {
                    "search": "",
                    "searchPlaceholder": "Search node sequences..."
                },
                initComplete: function() {
                    $('.dataTables_filter').detach().appendTo('#dtSearchContainer');
                }
            });

            // Toggle Dropdown
            $('#dotsBtn').on('click', function(e) {
                e.stopPropagation();
                $('#exportDropdown').toggleClass('show');
            });

            $(document).on('click', function() {
                $('#exportDropdown').removeClass('show');
            });
        });
    </script>
</x-admin-layout>

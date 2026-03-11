<x-admin-layout>
    <style>
        .gradient-header {
            background: linear-gradient(135deg, #0346cbff 0%, #1e1b4b 100%);
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
        #inquiriesTable thead th {
            background: #1e293b !important;
            color: #ffffff !important;
            font-size: 11px !important;
            font-weight: 900 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.1em !important;
            padding: 1rem 1.5rem !important;
            border: none !important;
        }
        #inquiriesTable tbody td {
            background: #ffffff !important;
            padding: 1.2rem 1.5rem !important;
            border-top: 1px solid #f1f5f9 !important;
            border-bottom: 1px solid #f1f5f9 !important;
            vertical-align: middle;
        }
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
    </style>

    <div class="px-6 py-8 min-h-screen" style="background-color: #d9d9d9ff;">
        <div class="gradient-header flex justify-between items-center text-white">
            <div>
                <h1 class="text-4xl font-black tracking-tight uppercase">Customer Queries</h1>
                <p class="text-white/80 font-bold uppercase text-[10px] tracking-widest mt-2">Inquiry Stream & Communication Node</p>
            </div>
            <div class="hidden lg:flex items-center gap-6">
                <div class="text-right">
                    <p class="text-white/40 text-[9px] font-black uppercase tracking-widest mb-1">Total Signals</p>
                    <p class="text-2xl font-black">{{ $inquiries->count() }} MESSAGES</p>
                </div>
                <div class="w-14 h-14 rounded-3xl bg-white/10 border border-white/20 flex items-center justify-center text-2xl">
                    <i class="fa-solid fa-envelope-open-text text-white/50"></i>
                </div>
            </div>
        </div>

        <div class="content-card">
            <div class="dt-custom-header mb-4 px-4 flex justify-between items-center">
                <div id="dtSearchContainer" class="search-wrapper"></div>
            </div>

            <div class="overflow-x-auto px-4">
                <table class="w-full text-left" id="inquiriesTable">
                    <thead>
                        <tr>
                            <th>Sender Identity</th>
                            <th>Contact Sequences</th>
                            <th>Inquiry Vector</th>
                            <th>Timestamp</th>
                            <th>Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inquiries as $inquiry)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td>
                                    <div>
                                        <p class="font-black text-gray-900 uppercase tracking-tight leading-none text-[13px]">{{ $inquiry->first_name }} {{ $inquiry->last_name }}</p>
                                        <p class="text-[8px] font-black text-blue-400 mt-1 uppercase tracking-widest">QUERY ID: #IQ-{{ $inquiry->id }}</p>
                                    </div>
                                </td>
                                <td>
                                    <p class="font-black text-gray-900 text-xs tracking-tight">{{ $inquiry->mobile }}</p>
                                    <p class="text-[9px] font-bold text-gray-400">{{ $inquiry->email }}</p>
                                </td>
                                <td>
                                    <span class="px-2.5 py-1 bg-amber-50 text-amber-600 text-[8px] font-black rounded-md border border-amber-100 uppercase tracking-widest">
                                        {{ $inquiry->inquiry_type }}
                                    </span>
                                </td>
                                <td>
                                    <p class="text-[10px] font-bold text-gray-500 uppercase">{{ $inquiry->created_at->format('d M, Y') }}</p>
                                    <p class="text-[8px] text-gray-400">{{ $inquiry->created_at->diffForHumans() }}</p>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <button onclick="viewInquiry({{ $inquiry->id }})" class="action-icon-btn view-btn shadow-sm" title="View Transmission">
                                            <i class="fa-solid fa-eye text-xs"></i>
                                        </button>
                                        <form action="{{ route('admin.inquiries.destroy', $inquiry) }}" method="POST" onsubmit="return confirm('Purge this inquiry signal?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-icon-btn delete-btn shadow-sm" title="Delete">
                                                <i class="fa-solid fa-trash-can text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-16 text-center text-slate-300 font-black uppercase text-[9px] tracking-widest">
                                    No incoming inquiry signals detected
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-6 px-4">
                {{ $inquiries->links() }}
            </div>
        </div>
    </div>

    <!-- Inquiry View Modal -->
    <div id="inquiryModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-[2.5rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full border border-white/20">
                <div class="bg-gradient-to-r from-[#0346cbff] to-indigo-900 px-8 py-6 flex justify-between items-center text-white">
                    <div>
                        <h3 class="text-xl font-black uppercase tracking-tight">Signal Details</h3>
                        <p class="text-[9px] text-white/60 font-black tracking-widest uppercase mt-1">Decrypted Metadata & Payload</p>
                    </div>
                    <button onclick="closeModal()" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition-colors">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="px-8 py-8 space-y-6">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Sender Node</p>
                            <p id="modalName" class="font-black text-slate-800 uppercase text-sm"></p>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Contact Vector</p>
                            <p id="modalContact" class="font-bold text-slate-600 text-xs"></p>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Inquiry Type</p>
                            <span id="modalType" class="px-3 py-1 bg-amber-50 text-amber-600 text-[10px] font-black rounded-full border border-amber-100 uppercase tracking-widest"></span>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Timestamp</p>
                            <p id="modalDate" class="font-bold text-slate-600 text-xs"></p>
                        </div>
                    </div>
                    <div class="bg-slate-50 rounded-3xl p-6 border border-slate-100">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-3">Message Payload</p>
                        <p id="modalMessage" class="text-slate-700 text-sm leading-relaxed font-medium"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var table = $('#inquiriesTable').DataTable({
                "pageLength": 10,
                "ordering": true,
                "info": false,
                "language": {
                    "search": "",
                    "searchPlaceholder": "Search inquiries..."
                },
                initComplete: function() {
                    $('.dataTables_filter').detach().appendTo('#dtSearchContainer');
                }
            });
        });

        function viewInquiry(id) {
            fetch(`/admin/inquiries/${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('modalName').innerText = `${data.first_name} ${data.last_name}`;
                    document.getElementById('modalContact').innerText = `${data.mobile} | ${data.email}`;
                    document.getElementById('modalType').innerText = data.inquiry_type;
                    document.getElementById('modalDate').innerText = new Date(data.created_at).toLocaleString();
                    document.getElementById('modalMessage').innerText = data.message;
                    document.getElementById('inquiryModal').classList.remove('hidden');
                });
        }

        function closeModal() {
            document.getElementById('inquiryModal').classList.add('hidden');
        }
    </script>
</x-admin-layout>

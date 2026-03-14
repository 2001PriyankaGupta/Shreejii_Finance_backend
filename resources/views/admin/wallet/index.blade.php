<x-admin-layout>
    <x-slot name="header">
        Wallet & Payouts
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-[2rem]">
                <div class="p-8">
                    <div class="mb-6">
                        <h3 class="text-xl font-bold tracking-tight text-gray-900">Withdrawal Requests</h3>
                        <p class="text-sm text-gray-500 mt-1">Manage employee and partner payout requests here.</p>
                    </div>

                    @if(session('success'))
                        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm font-semibold flex items-center">
                            <i class="fa-solid fa-circle-check mr-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-100 text-rose-700 text-sm font-semibold flex items-center">
                            <i class="fa-solid fa-circle-exclamation mr-2"></i> {{ session('error') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto rounded-2xl border border-gray-100">
                        <table class="w-full text-sm text-left text-gray-600">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50/50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 font-semibold tracking-wider">User Details</th>
                                    <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Bank Details</th>
                                    <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Amount</th>
                                    <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Requested At</th>
                                    <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-4 font-semibold tracking-wider text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($transactions as $tx)
                                <tr class="bg-white hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-900">{{ $tx->user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $tx->user->email }}<br/>{{ $tx->user->phone }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($tx->user->bank_name)
                                            <div class="font-medium text-gray-900">{{ $tx->user->bank_name }}</div>
                                            <div class="text-xs text-gray-500">A/C: {{ $tx->user->account_number }}<br/>IFSC: {{ $tx->user->ifsc_code }}</div>
                                        @else
                                            <span class="text-rose-500 text-xs font-semibold">Missing Details</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-amber-50 text-amber-700">
                                            ₹ {{ number_format($tx->amount, 2) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $tx->created_at->format('M d, Y') }}<br/>
                                        <span class="text-xs">{{ $tx->created_at->format('h:i A') }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($tx->status === 'COMPLETED')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-emerald-100 text-emerald-800">
                                                COMPLETED
                                            </span>
                                        @elseif($tx->status === 'FAILED')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-rose-100 text-rose-800">
                                                FAILED
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-amber-100 text-amber-800">
                                                PENDING
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                        @if($tx->status === 'PENDING')
                                            <div class="flex items-center justify-end gap-2">
                                                @if($tx->payout_link_url)
                                                    <a href="{{ $tx->payout_link_url }}" target="_blank" class="px-3 py-1.5 text-xs font-bold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition-colors border border-indigo-100">
                                                        GATEWAY LINK
                                                    </a>
                                                @endif
                                                <form action="{{ route('admin.wallet.updateStatus', $tx->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="status" value="COMPLETED">
                                                    <button type="submit" class="px-3 py-1.5 text-xs font-bold text-white bg-emerald-500 hover:bg-emerald-600 rounded-lg shadow-sm transition-colors" onclick="return confirm('Are you sure you want to mark this as completed? (Make sure you have transferred the amount)');">
                                                        SETTLE
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.wallet.updateStatus', $tx->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="status" value="FAILED">
                                                    <button type="submit" class="p-1.5 text-rose-500 hover:bg-rose-50 rounded-lg transition-colors" title="Reject" onclick="return confirm('Are you sure you want to reject this request?');">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-gray-400 text-xs">No Actions</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-4">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                        </div>
                                        <p class="text-base text-gray-500 font-medium tracking-tight">No Withdrawal Requests Found</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

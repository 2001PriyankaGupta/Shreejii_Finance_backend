<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-[2.5rem] border border-slate-200">
                <div class="p-10">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12">
                        <div>
                            <h2 class="text-3xl font-black text-slate-900 tracking-tight flex items-center gap-4">
                                <i class="fa-solid fa-comments text-[#0346cbff]"></i> Secure Signal Hub
                            </h2>
                            <p class="text-slate-500 font-bold mt-2 uppercase tracking-widest text-[10px]">Real-time communication terminal</p>
                        </div>
                        <div class="flex items-center gap-4">
                            @php
                                $totalUnread = \App\Models\Message::whereNull('receiver_id')->where('is_read', false)->count();
                                $totalSignals = \App\Models\Message::count();
                            @endphp
                            <div class="px-6 py-3 bg-rose-50 border border-rose-100 rounded-2xl">
                                <p class="text-[9px] font-black text-rose-500 uppercase tracking-widest mb-1">Unseen Signals</p>
                                <p class="text-2xl font-black text-rose-600">{{ $totalUnread }}</p>
                            </div>
                            <div class="px-6 py-3 bg-slate-50 border border-slate-100 rounded-2xl">
                                <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">Total Payload</p>
                                <p class="text-2xl font-black text-slate-800">{{ $totalSignals }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-3">
                        @forelse($users as $user)
                            <a href="{{ route('admin.messages.show', $user->id) }}" class="flex items-center gap-6 p-5 bg-white hover:bg-slate-50 border border-slate-100 rounded-[2rem] transition-all group hover:shadow-lg">
                                <div class="relative">
                                    <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-[#0346cbff] group-hover:text-white transition-all shadow-inner overflow-hidden font-black uppercase">
                                        @if($user->avatar_url)
                                            <img src="{{ asset('storage/' . $user->avatar_url) }}" class="w-full h-full object-cover">
                                        @else
                                            {{ $user->name[0] }}
                                        @endif
                                    </div>
                                    @php $unread = \App\Models\Message::where('sender_id', $user->id)->whereNull('receiver_id')->where('is_read', false)->count(); @endphp
                                    @if($unread > 0)
                                        <div class="absolute -top-2 -right-2 w-6 h-6 bg-rose-500 text-white rounded-full flex items-center justify-center text-[10px] font-black border-4 border-white shadow-md animate-bounce">{{ $unread }}</div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-1">
                                        <p class="text-sm font-black text-slate-900 group-hover:text-[#0346cbff] transition-colors truncate uppercase tracking-tight">{{ $user->name }}</p>
                                        @if($user->last_message)
                                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">{{ $user->last_message->created_at->diffForHumans() }}</p>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="px-2 py-0.5 bg-blue-100 text-[#0346cbff] rounded-md text-[7px] font-black uppercase tracking-widest">{{ $user->role }}</span>
                                        @if($user->last_message)
                                            <p class="text-xs text-slate-400 font-medium truncate {{ $unread > 0 ? 'text-slate-900 font-bold' : '' }}">{{ $user->last_message->message }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="w-10 h-10 rounded-full border border-slate-100 flex items-center justify-center text-slate-300 group-hover:border-[#0346cbff] group-hover:text-[#0346cbff] transition-all">
                                    <i class="fa-solid fa-angle-right"></i>
                                </div>
                            </a>
                        @empty
                            <div class="py-24 text-center border-2 border-dashed border-slate-200 rounded-[3rem]">
                                <i class="fa-solid fa-ghost text-slate-200 text-5xl mb-6"></i>
                                <p class="text-slate-400 font-black uppercase tracking-widest text-sm">No signals detected.</p>
                                <p class="text-slate-300 text-xs mt-2">The message matrix is currently idle.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

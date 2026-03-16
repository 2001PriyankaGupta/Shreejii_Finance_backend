<x-admin-layout>
    <div class="py-6 h-[calc(100vh-100px)]">
        <div class="max-w-[1600px] mx-auto h-full px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-[2.5rem] shadow-[0_20px_60px_-15px_rgba(0,0,0,0.05)] border border-slate-100 h-full overflow-hidden flex">
                
                <!-- Left Sidebar: Conversations List -->
                <div class="w-full md:w-[380px] border-r border-slate-200 flex flex-col bg-[#f0f2f5]">
                    <!-- Sidebar Header -->
                    <div class="p-8 pb-4">
                        <div class="flex items-center justify-between mb-8">
                            <h2 class="text-2xl font-black text-slate-900 tracking-tight">Messages</h2>
                        </div>
                        
                        <!-- Search Bar -->
                        <div class="relative">
                            <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            <input type="text" id="user-search" placeholder="Search conversations..." class="w-full pl-12 pr-6 py-4 bg-white border border-slate-200 rounded-2xl text-sm font-medium focus:ring-0 focus:border-[#0346cbff] transition-all placeholder:text-slate-300 shadow-sm">
                        </div>
                    </div>

                    <!-- List Area -->
                    <div class="flex-1 overflow-y-auto px-4 pb-8 custom-scrollbar mt-4">
                        <div class="space-y-2" id="users-list">
                            @forelse($users as $user)
                                @php 
                                    $isActive = isset($selectedUser) && $selectedUser->id == $user->id;
                                    $unread = \App\Models\Message::where('sender_id', $user->id)->whereNull('receiver_id')->where('is_read', false)->count();
                                @endphp
                                <a href="{{ route('admin.messages.show', $user->id) }}" data-name="{{ strtolower($user->name) }}" class="user-item flex items-center gap-4 p-4 rounded-3xl transition-all group {{ $isActive ? 'bg-white shadow-xl shadow-blue-500/10 ring-1 ring-slate-100' : 'hover:bg-white/50' }}">
                                    <div class="relative flex-shrink-0">
                                        <div class="w-14 h-14 rounded-2xl {{ $isActive ? 'bg-[#0346cbff]' : 'bg-white border border-slate-200 shadow-sm' }} flex items-center justify-center text-white overflow-hidden font-black uppercase text-lg transition-transform group-hover:scale-105">
                                            @if($user->avatar_url)
                                                <img src="{{ asset('storage/' . $user->avatar_url) }}" class="w-full h-full object-cover">
                                            @else
                                                <span class="{{ $isActive ? 'text-white' : 'text-slate-400' }}">{{ $user->name[0] }}</span>
                                            @endif
                                        </div>
                                        @if($unread > 0)
                                            <div class="absolute -top-1 -right-1 w-5 h-5 bg-rose-500 text-white rounded-full flex items-center justify-center text-[10px] font-black border-2 border-white shadow-sm">{{ $unread }}</div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between mb-0.5">
                                            <p class="text-[13px] font-black text-slate-900 truncate tracking-tight uppercase">{{ $user->name }}</p>
                                            @if($user->last_message)
                                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">{{ $user->last_message->created_at->diffForHumans(null, true) }}</p>
                                            @endif
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <p class="text-[11px] {{ $unread > 0 ? 'text-slate-900 font-black' : 'text-slate-400 font-medium' }} truncate leading-tight pr-4">
                                                @if($user->last_message && $user->last_message->sender_id == Auth::id())
                                                    <span class="text-[#0346cbff]">You:</span>
                                                @endif
                                                {{ $user->last_message ? $user->last_message->message : 'Started a conversation' }}
                                            </p>
                                            @if($isActive)
                                                <i class="fa-solid fa-thumbtack text-[10px] text-[#0346cbff] rotate-45"></i>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center py-12">
                                    <p class="text-xs font-black text-slate-300 uppercase tracking-widest">No active chats</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Main Chat Area -->
                <div class="flex-1 flex flex-col bg-white overflow-hidden">
                    @if(isset($selectedUser))
                        <!-- Chat Header -->
                        <div class="px-8 py-6 border-b border-slate-200 flex items-center justify-between bg-[#f3f4f6]">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 overflow-hidden shadow-sm">
                                    @if($selectedUser->avatar_url)
                                        <img src="{{ asset('storage/' . $selectedUser->avatar_url) }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="font-black uppercase text-sm">{{ $selectedUser->name[0] }}</span>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="text-lg font-black text-slate-900 tracking-tight">{{ $selectedUser->name }}</h3>
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ $selectedUser->role }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <button class="w-10 h-10 rounded-xl bg-white text-slate-400 hover:text-[#0346cbff] transition-all flex items-center justify-center shadow-sm border border-slate-100 hover:border-[#0346cbff]"><i class="fa-solid fa-magnifying-glass text-sm"></i></button>
                            </div>
                        </div>

                        <!-- Chat Messages Area -->
                        <div class="flex-1 overflow-y-auto p-10 space-y-8 bg-[#f8fafc]/30 custom-scrollbar" id="chat-container">
                            @foreach($messages as $msg)
                                @php $isSender = $msg->sender_id == Auth::id() || $msg->sender_id === null; @endphp
                                <div class="flex {{ $isSender ? 'justify-end' : 'justify-start' }} group/msg">
                                    <div class="flex items-end gap-3 max-w-[70%] {{ $isSender ? 'flex-row-reverse' : '' }}">
                                        <!-- Avatar on Bubble Side -->
                                        @if(!$isSender)
                                            <div class="w-8 h-8 rounded-lg bg-white border border-slate-100 flex-shrink-0 flex items-center justify-center overflow-hidden shadow-sm">
                                                @if($selectedUser->avatar_url)
                                                    <img src="{{ asset('storage/' . $selectedUser->avatar_url) }}" class="w-full h-full object-cover">
                                                @else
                                                    <span class="text-[10px] font-black text-slate-400 uppercase">{{ $selectedUser->name[0] }}</span>
                                                @endif
                                            </div>
                                        @endif

                                        <div class="flex flex-col {{ $isSender ? 'items-end' : 'items-start' }}">
                                            @if(!$isSender)
                                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">{{ $selectedUser->name }}</span>
                                            @endif
                                            
                                            <div class="px-5 py-3.5 {{ $isSender ? 'bg-[#0346cbff] text-white rounded-[1.5rem] rounded-br-[0.3rem] shadow-[0_10px_20px_-5px_rgba(3,70,203,0.3)]' : 'bg-white border border-slate-100 text-slate-700 rounded-[1.5rem] rounded-bl-[0.3rem] shadow-sm' }}">
                                                <p class="text-[13px] font-semibold leading-relaxed tracking-tight">{{ $msg->message }}</p>
                                            </div>
                                            
                                            <div class="mt-2 flex items-center gap-2 transition-all group-hover/msg:scale-110">
                                                <span class="text-[8px] font-black text-slate-300 uppercase tracking-widest group-hover/msg:text-slate-500 transition-colors">{{ $msg->created_at->format('H:i') }}</span>
                                                @if($isSender)
                                                    <i class="fa-solid fa-check-double text-[8px] text-[#0346cbff]"></i>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Chat Input Bar -->
                        <div class="p-8 bg-white border-t border-slate-50">
                            <form action="{{ route('admin.messages.reply', $selectedUser->id) }}" method="POST" class="flex items-center gap-4 bg-slate-50 border border-slate-100 rounded-3xl p-2 pr-3 focus-within:bg-white focus-within:shadow-2xl focus-within:shadow-blue-500/10 focus-within:border-[#0346cbff] transition-all">
                                @csrf
                                <button type="button" class="w-11 h-11 rounded-2xl flex items-center justify-center text-slate-400 hover:bg-white hover:text-[#0346cbff] hover:shadow-sm transition-all"><i class="fa-solid fa-paperclip text-sm"></i></button>
                                <input type="text" name="message" placeholder="Write your message..." class="flex-1 bg-transparent border-none focus:ring-0 text-sm font-bold text-slate-700 placeholder:text-slate-300 py-3" autofocus required>
                                <div class="flex items-center gap-1">
                                    <button type="button" class="w-11 h-11 rounded-2xl flex items-center justify-center text-slate-400 hover:bg-white hover:text-amber-500 transition-all"><i class="fa-regular fa-face-smile text-lg"></i></button>
                                    <button type="button" class="w-11 h-11 rounded-2xl flex items-center justify-center text-slate-400 hover:bg-white transition-all"><i class="fa-solid fa-microphone text-sm"></i></button>
                                    <button type="submit" class="w-11 h-11 rounded-2xl bg-[#0346cbff] text-white flex items-center justify-center shadow-lg shadow-blue-500/30 hover:scale-105 active:scale-95 transition-all"><i class="fa-solid fa-paper-plane text-xs"></i></button>
                                </div>
                            </form>
                        </div>
                    @else
                        <!-- Empty State: No chat selected -->
                        <div class="h-full flex flex-col items-center justify-center text-center p-12 bg-slate-50/20">
                            <div class="w-32 h-32 rounded-[3rem] bg-white border border-slate-100 flex items-center justify-center text-slate-200 shadow-xl mb-8">
                                <i class="fa-solid fa-comments text-5xl"></i>
                            </div>
                            <h3 class="text-xl font-black text-slate-900 mb-2 uppercase tracking-tight">Select a Chat</h3>
                            <p class="text-slate-400 text-sm font-medium max-w-[280px]">Choose a conversation from the sidebar to establish a secure link.</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('chat-container');
            if(container) {
                container.scrollTop = container.scrollHeight;
            }

            // Real-time Search functionality
            const searchInput = document.getElementById('user-search');
            if(searchInput) {
                searchInput.addEventListener('input', (e) => {
                    const term = e.target.value.toLowerCase();
                    const items = document.querySelectorAll('.user-item');
                    items.forEach(item => {
                        const name = item.getAttribute('data-name');
                        if(name.includes(term)) {
                            item.style.display = 'flex';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            }
        });
    </script>
</x-admin-layout>

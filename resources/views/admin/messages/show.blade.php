<x-admin-layout>
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-[3rem] border border-slate-200 flex flex-col h-[800px]">
                <!-- Chat Header -->
                <div class="p-8 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <div class="flex items-center gap-6">
                        <a href="{{ route('admin.messages.index') }}" class="w-12 h-12 rounded-2xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-[#0346cbff] transition-all hover:shadow-lg">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                        <div class="flex items-center gap-5">
                            <div class="w-14 h-14 rounded-2xl bg-[#0346cbff] flex items-center justify-center text-white shadow-lg overflow-hidden font-black">
                                @if($user->avatar_url)
                                    <img src="{{ asset('storage/' . $user->avatar_url) }}" class="w-full h-full object-cover">
                                @else
                                    {{ $user->name[0] }}
                                @endif
                            </div>
                            <div>
                                <h3 class="text-xl font-black text-slate-900 tracking-tight">{{ $user->name }}</h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Live Connection • {{ $user->role }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chat Body -->
                <div class="flex-1 overflow-y-auto p-10 space-y-6 bg-[#fcfdfe]" id="chat-container">
                    @foreach($messages as $msg)
                        <div class="flex {{ $msg->sender_id == $user->id ? 'justify-start' : 'justify-end' }}">
                            <div class="max-w-[75%]">
                                <div class="px-6 py-4 {{ $msg->sender_id == $user->id ? 'bg-white text-slate-800 rounded-2xl rounded-tl-none border border-slate-200 shadow-sm' : 'bg-[#0346cbff] text-white rounded-2xl rounded-tr-none shadow-lg' }}">
                                    <p class="text-[13px] font-medium leading-relaxed">{{ $msg->message }}</p>
                                </div>
                                <div class="mt-2 flex items-center gap-2 {{ $msg->sender_id == $user->id ? 'justify-start' : 'justify-end' }}">
                                    <span class="text-[8px] font-black text-slate-400 uppercase tracking-[2px]">{{ $msg->created_at->format('h:i A') }}</span>
                                    <span class="w-1 h-1 rounded-full bg-slate-200"></span>
                                    <span class="text-[8px] font-black {{ $msg->sender_id == $user->id ? 'text-blue-500' : 'text-slate-400' }} uppercase tracking-[2px]">{{ $msg->sender_id == $user->id ? 'INCOMING' : 'TRANSMITTED' }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Chat Input -->
                <div class="p-8 border-t border-slate-100 bg-white">
                    <form action="{{ route('admin.messages.reply', $user->id) }}" method="POST">
                        @csrf
                        <div class="relative flex items-center gap-3 bg-slate-50 border border-slate-200 rounded-[2rem] p-2 transition-all focus-within:border-[#0346cbff] focus-within:shadow-lg focus-within:bg-white">
                            <button type="button" class="w-12 h-12 rounded-full text-slate-400 hover:text-[#0346cbff] hover:bg-blue-50 transition-all flex items-center justify-center">
                                <i class="fa-solid fa-paperclip text-lg"></i>
                            </button>
                            <input type="text" name="message" placeholder="Type a secure message..." class="flex-1 bg-transparent border-none focus:ring-0 text-sm font-medium px-2 py-3" required>
                            <button type="button" class="w-12 h-12 rounded-full text-slate-400 hover:text-[#0346cbff] hover:bg-blue-50 transition-all flex items-center justify-center">
                                <i class="fa-solid fa-face-smile text-lg"></i>
                            </button>
                            <button type="submit" class="w-12 h-12 rounded-full bg-[#0346cbff] text-white flex items-center justify-center hover:scale-105 active:scale-95 transition-all shadow-lg">
                                <i class="fa-solid fa-paper-plane"></i>
                            </button>
                        </div>
                        <p class="text-[8px] text-center mt-4 font-black text-slate-300 uppercase tracking-[3px]">Encryption Protocol active • Multi-factor verified</p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const container = document.getElementById('chat-container');
        container.scrollTop = container.scrollHeight;
    </script>
</x-admin-layout>

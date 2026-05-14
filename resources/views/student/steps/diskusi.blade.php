@extends('layouts.app')

@section('title', 'Diskusi - ' . $module->title)

@section('content')
<div class="pb-24">
    <!-- Top Header -->
    <header class="bg-white px-container-padding py-4 shadow-sm flex items-center justify-between sticky top-0 z-50">
        <x-logo variant="pill" />
        
        <div class="flex items-center gap-3">
            <div class="bg-secondary-container/10 px-3 py-1.5 rounded-full flex items-center gap-1.5 border border-secondary-container/20">
                <span class="material-symbols-outlined text-secondary text-lg" style="font-variation-settings: 'FILL' 1;">stars</span>
                <span class="font-headline text-secondary font-bold">{{ Auth::user()->points }}</span>
            </div>
            <div class="w-10 h-10 rounded-full bg-primary-container flex items-center justify-center text-white font-bold border-2 border-white shadow-sm">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
        </div>
    </header>

    <main class="px-container-padding pt-6 space-y-8 min-h-[calc(100vh-160px)] flex flex-col">
        <!-- Step Indicator & Title -->
        <div class="space-y-2">
            <div class="flex items-center gap-2 text-primary">
                <span class="material-symbols-outlined text-xl" style="font-variation-settings: 'FILL' 1;">forum</span>
                <span class="font-label text-xs uppercase tracking-widest font-bold">Fase 3: Diskusi (D)</span>
            </div>
            <h1 class="font-headline text-headline-lg text-on-surface">Mari Berdiskusi</h1>
            <p class="text-body-md text-on-surface-variant">
                {{ $module->content['D']['topic'] ?? 'Bagikan pendapatmu dengan teman sekelas tentang topik ini.' }}
            </p>
        </div>

        <!-- Chat List -->
        <section id="chat-container" class="flex-grow space-y-6 overflow-y-auto no-scrollbar max-h-[50vh] pr-2">
            @forelse($messages as $msg)
                @if($msg->user_id === Auth::id())
                    <!-- User Message (You) -->
                    <div class="flex items-start gap-3 flex-row-reverse">
                        <div class="w-10 h-10 rounded-full bg-primary-container flex items-center justify-center text-white font-bold shrink-0 border border-primary">
                            {{ substr($msg->user->name, 0, 1) }}
                        </div>
                        <div class="space-y-1 max-w-[85%] flex flex-col items-end">
                            <span class="text-xs font-bold text-primary mr-1">Kamu</span>
                            <div class="bg-primary p-4 rounded-3xl rounded-tr-none shadow-md">
                                <p class="text-sm text-white">{{ $msg->content }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Friend Message -->
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-full bg-secondary-container/20 flex items-center justify-center text-secondary font-bold shrink-0 border border-secondary/20">
                            {{ substr($msg->user->name, 0, 1) }}
                        </div>
                        <div class="space-y-1 max-w-[85%]">
                            <span class="text-xs font-bold text-on-surface-variant ml-1">{{ $msg->user->name }}</span>
                            <div class="bg-white p-4 rounded-3xl rounded-tl-none border border-outline-variant/30 shadow-sm">
                                <p class="text-sm text-on-surface">{{ $msg->content }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            @empty
                <div class="text-center py-10 opacity-50">
                    <p class="text-sm">Belum ada diskusi. Mulailah percakapan!</p>
                </div>
            @endforelse
        </section>

        <!-- Input Area -->
        <div class="space-y-4 pt-4 border-t border-outline-variant/10">
            <div class="relative">
                <input type="text" id="chat-input" placeholder="Tulis pendapatmu..." 
                       class="w-full h-14 pl-6 pr-14 bg-white border-2 border-outline-variant/30 rounded-2xl focus:border-primary focus:ring-0 transition-all text-sm">
                <button id="send-btn" class="absolute right-2 top-2 w-10 h-10 bg-primary text-white rounded-xl flex items-center justify-center active:scale-95 transition-transform">
                    <span class="material-symbols-outlined text-xl" style="font-variation-settings: 'FILL' 1;">send</span>
                </button>
            </div>

            <!-- Next Action -->
            <form action="{{ route('student.module.next', [$module->id, $step]) }}" method="POST">
                @csrf
                <button type="submit" 
                        class="w-full h-16 bg-primary text-white rounded-2xl font-headline text-button-text flex items-center justify-center gap-3 shadow-[0_4px_0_0_#410000] active:translate-y-[2px] active:shadow-[0_2px_0_0_#410000] hover:bg-primary-container transition-all">
                    <span>Lanjut ke Ungkapkan</span>
                    <span class="material-symbols-outlined">arrow_forward</span>
                </button>
            </form>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const chatContainer = document.getElementById('chat-container');
                const chatInput = document.getElementById('chat-input');
                const sendBtn = document.getElementById('send-btn');

                // Scroll to bottom
                chatContainer.scrollTop = chatContainer.scrollHeight;

                function sendMessage() {
                    const content = chatInput.value.trim();
                    if (!content) return;

                    sendBtn.disabled = true;
                    sendBtn.innerHTML = '<span class="animate-spin material-symbols-outlined text-xl">progress_activity</span>';

                    fetch("{{ route('student.discussion.store') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            module_id: {{ $module->id }},
                            content: content
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            chatInput.value = '';
                            appendMessage(data.message);
                            chatContainer.scrollTop = chatContainer.scrollHeight;
                        }
                    })
                    .catch(error => console.error('Error:', error))
                    .finally(() => {
                        sendBtn.disabled = false;
                        sendBtn.innerHTML = '<span class="material-symbols-outlined text-xl" style="font-variation-settings: \'FILL\' 1;">send</span>';
                    });
                }

                function appendMessage(msg) {
                    const div = document.createElement('div');
                    div.className = 'flex items-start gap-3 flex-row-reverse animate-in fade-in slide-in-from-right-4 duration-300';
                    div.innerHTML = `
                        <div class="w-10 h-10 rounded-full bg-primary-container flex items-center justify-center text-white font-bold shrink-0 border border-primary">
                            ${msg.user.name.charAt(0)}
                        </div>
                        <div class="space-y-1 max-w-[85%] flex flex-col items-end">
                            <span class="text-xs font-bold text-primary mr-1">Kamu</span>
                            <div class="bg-primary p-4 rounded-3xl rounded-tr-none shadow-md">
                                <p class="text-sm text-white">${msg.content}</p>
                            </div>
                        </div>
                    `;
                    
                    // Remove empty message placeholder if exists
                    if (chatContainer.querySelector('.opacity-50')) {
                        chatContainer.innerHTML = '';
                    }
                    
                    chatContainer.appendChild(div);
                }

                sendBtn.addEventListener('click', sendMessage);
                chatInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') sendMessage();
                });
            });
        </script>
    </main>

    <!-- Bottom Nav -->
    <nav class="fixed bottom-0 left-0 w-full bg-white/80 backdrop-blur-lg border-t border-outline-variant/30 px-6 py-3 flex justify-between items-center z-50">
        <a href="{{ route('student.dashboard') }}" class="flex flex-col items-center gap-1 text-outline">
            <span class="material-symbols-outlined">home</span>
            <span class="text-[10px] font-bold">Beranda</span>
        </a>
        <a href="#" class="flex flex-col items-center gap-1 text-primary">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">menu_book</span>
            <span class="text-[10px] font-bold">Modul</span>
        </a>
        <a href="#" class="flex flex-col items-center gap-1 text-outline">
            <span class="material-symbols-outlined">forum</span>
            <span class="text-[10px] font-bold">Diskusi</span>
        </a>
        <a href="#" class="flex flex-col items-center gap-1 text-outline">
            <span class="material-symbols-outlined">edit_square</span>
            <span class="text-[10px] font-bold">Jurnal</span>
        </a>
        <a href="#" class="flex flex-col items-center gap-1 text-outline">
            <span class="material-symbols-outlined">person</span>
            <span class="text-[10px] font-bold">Profil</span>
        </a>
    </nav>
</div>
@endsection

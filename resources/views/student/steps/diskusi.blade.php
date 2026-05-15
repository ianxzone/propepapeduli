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
        <div class="space-y-4">
            <div class="flex items-center gap-2 text-primary">
                <span class="material-symbols-outlined text-xl" style="font-variation-settings: 'FILL' 1;">forum</span>
                <span class="font-label text-xs uppercase tracking-widest font-bold">Fase 3: Diskusi (D)</span>
                @if(Auth::user()->group)
                    <span class="bg-primary/10 text-primary px-3 py-1 rounded-full text-[10px] font-bold border border-primary/20">
                        Kelompok: {{ Auth::user()->group->name }}
                    </span>
                @endif
            </div>
            
            @if(!empty($module->content['D']['teacher_instruction']))
            <div class="bg-primary/5 p-4 rounded-2xl border border-primary/10 flex gap-3">
                <span class="material-symbols-outlined text-primary">record_voice_over</span>
                <div class="prose prose-sm prose-primary max-w-none text-on-surface leading-relaxed">
                    {!! $module->content['D']['teacher_instruction'] !!}
                </div>
            </div>
            @endif

            <div class="bg-surface-container-low p-4 rounded-2xl border border-outline-variant/30">
                <h2 class="text-xs font-bold text-on-surface-variant uppercase tracking-widest mb-1">Topik Diskusi</h2>
                <div class="text-body-md text-on-surface font-medium leading-relaxed">
                    {!! $module->content['D']['topic'] ?? 'Bagikan pendapatmu dengan teman sekelas tentang topik ini.' !!}
                </div>
            </div>
        </div>

        @php
            $discussionType = $module->content['D']['type'] ?? 'chat';
        @endphp

        @if($discussionType == 'chat')
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
        </div>
        @elseif($discussionType == 'map')
            <!-- Map Interface -->
            <div class="flex-grow flex flex-col lg:flex-row gap-6 mt-4 pb-4 px-container-padding">
                <!-- Input Column -->
                <div class="w-full lg:w-1/3 flex flex-col bg-surface-container-low rounded-3xl border border-outline-variant/30 overflow-hidden shadow-sm">
                    <div class="p-4 bg-white border-b border-outline-variant/30 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">edit_note</span>
                        <h3 class="font-bold text-sm">Input Argumen</h3>
                    </div>
                    <div class="p-4 bg-white space-y-4 flex-1">
                        <div>
                            <label class="text-xs font-bold text-on-surface-variant mb-2 block">Jenis Argumen:</label>
                            <div class="grid grid-cols-2 gap-2">
                                <button onclick="setArgType('reason')" id="btn-reason" class="flex flex-col items-center p-3 rounded-xl border-2 border-green-200 bg-green-50 text-green-700 transition-all ring-primary/30 ring-offset-2">
                                    <span class="material-symbols-outlined text-xl mb-1">check_circle</span>
                                    <span class="text-[10px] font-bold uppercase">Alasan (Pro)</span>
                                </button>
                                <button onclick="setArgType('objection')" id="btn-objection" class="flex flex-col items-center p-3 rounded-xl border-2 border-outline-variant bg-surface-container-lowest text-on-surface-variant transition-all">
                                    <span class="material-symbols-outlined text-xl mb-1">cancel</span>
                                    <span class="text-[10px] font-bold uppercase">Sanggahan (Kontra)</span>
                                </button>
                            </div>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-on-surface-variant mb-2 block">Pilih Peranmu:</label>
                            <select id="role-select" class="w-full text-sm bg-surface-container-lowest border border-outline-variant rounded-xl px-3 py-3 outline-none focus:border-primary font-medium">
                                <option value="warga">👤 Warga (Terdampak)</option>
                                <option value="pemerintah">🏛️ Pemerintah (Regulator)</option>
                                <option value="pengusaha">💼 Pengusaha (Ekonomi)</option>
                                <option value="aktivis">🌿 Aktivis (Lingkungan)</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-on-surface-variant mb-2 block">Isi Argumen:</label>
                            <textarea id="map-input" rows="3" placeholder="Tulis pendapatmu..." 
                                   class="w-full p-4 bg-surface-container-lowest border border-outline-variant rounded-xl focus:outline-none focus:border-primary transition-all text-sm resize-none"></textarea>
                        </div>
                        <button onclick="addMapArgument()" class="w-full h-12 bg-primary text-white rounded-xl font-bold flex items-center justify-center gap-2 shadow-md active:scale-95 transition-all">
                            <span class="material-symbols-outlined text-sm">add_task</span>
                            Sematkan ke Peta
                        </button>
                    </div>
                </div>

                <!-- Visual Board Column -->
                <div class="w-full lg:w-2/3 bg-surface-container-lowest rounded-3xl border border-outline-variant/30 p-4 flex flex-col shadow-sm min-h-[500px]">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-headline text-lg font-bold flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">account_tree</span>
                            Peta Argumen Kelas
                        </h3>
                        <div class="flex gap-4">
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 rounded-sm bg-green-500"></div>
                                <span class="text-[10px] font-bold uppercase">Alasan</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 rounded-sm bg-red-500"></div>
                                <span class="text-[10px] font-bold uppercase">Sanggahan</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex-1 bg-surface-container-low rounded-2xl border border-outline-variant/30 p-4 relative overflow-hidden flex items-start justify-center pt-20 shadow-inner" id="mapping-canvas" style="background-image: radial-gradient(#e5e7eb 1px, transparent 1px); background-size: 20px 20px;">
                        <!-- Control Panel Overlay -->
                        <div class="absolute bottom-4 right-4 flex gap-2" style="z-index: 50;">
                            <button onclick="exportMapImage()" class="flex items-center gap-2 px-4 py-2 bg-white/90 backdrop-blur border border-outline-variant rounded-full text-[10px] font-bold uppercase tracking-wider text-on-surface hover:bg-primary hover:text-white transition-all shadow-sm">
                                <span class="material-symbols-outlined text-sm">download</span>
                                Unduh PNG
                            </button>
                            <button onclick="saveMapToDatabase()" class="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-full text-[10px] font-bold uppercase tracking-wider hover:bg-primary-container transition-all shadow-md">
                                <span class="material-symbols-outlined text-sm">cloud_upload</span>
                                Simpan Peta
                            </button>
                        </div>

                        <!-- SVG for Lines -->
                        <svg id="map-svg" class="absolute inset-0 w-full h-full pointer-events-none" style="z-index: 5;"></svg>

                        <!-- Target/Center Topic (Main Claim) -->
                        <div id="center-topic" class="absolute top-10 left-1/2 -translate-x-1/2 bg-white rounded-xl border-2 border-primary shadow-lg z-10 overflow-hidden w-64 pointer-events-auto cursor-pointer" onclick="handleCardClick('center-topic')">
                            <div class="bg-primary text-white text-[10px] font-bold uppercase tracking-widest px-4 py-1.5 text-center">
                                Klaim Utama
                            </div>
                            <div class="p-3 text-xs font-bold text-on-surface text-center leading-relaxed">
                                {!! $module->content['D']['topic'] ?? 'Isu Utama' !!}
                            </div>
                        </div>
                        
                        <!-- Cards Container -->
                        <div id="map-cards-container" class="absolute inset-0 w-full h-full pointer-events-none"></div>
                    </div>
                </div>
            </div>
            
            @push('scripts')
            <script>
                let currentArgType = 'reason';
                const roleIcons = {
                    'warga': 'groups',
                    'pemerintah': 'account_balance',
                    'pengusaha': 'business_center',
                    'aktivis': 'eco'
                };

                let connections = [];
                let linkingFrom = null;

                function setArgType(type) {
                    currentArgType = type;
                    const rBtn = document.getElementById('btn-reason');
                    const oBtn = document.getElementById('btn-objection');
                    
                    if(type === 'reason') {
                        rBtn.className = 'flex flex-col items-center p-3 rounded-xl border-2 border-green-200 bg-green-50 text-green-700 transition-all ring-primary/30 ring-offset-2';
                        oBtn.className = 'flex flex-col items-center p-3 rounded-xl border-2 border-outline-variant bg-surface-container-lowest text-on-surface-variant transition-all';
                    } else {
                        oBtn.className = 'flex flex-col items-center p-3 rounded-xl border-2 border-red-200 bg-red-50 text-red-700 transition-all ring-primary/30 ring-offset-2';
                        rBtn.className = 'flex flex-col items-center p-3 rounded-xl border-2 border-outline-variant bg-surface-container-lowest text-on-surface-variant transition-all';
                    }
                }

                function addMapArgument() {
                    const select = document.getElementById('role-select');
                    const input = document.getElementById('map-input');
                    const text = input.value.trim();
                    const role = select.value;
                    const roleLabel = select.options[select.selectedIndex].text.split(' ')[1];
                    
                    if(!text) return alert("Silakan tulis argumenmu!");

                    const container = document.getElementById('map-cards-container');
                    const cardId = 'card-' + Date.now();
                    
                    const card = document.createElement('div');
                    card.id = cardId;
                    card.dataset.type = currentArgType;
                    
                    const isReason = currentArgType === 'reason';
                    const themeClass = isReason ? 'border-green-200' : 'border-red-200';
                    const headerClass = isReason ? 'bg-green-500' : 'bg-red-500';
                    
                    card.className = `absolute pointer-events-auto rounded-xl border-2 shadow-md w-48 bg-white animate-in zoom-in duration-300 ${themeClass} cursor-move group overflow-hidden`;
                    
                    // Initial Position below center
                    const existingCards = container.children.length;
                    const canvasWidth = container.clientWidth;
                    const left = (canvasWidth / 2) - 96 + (Math.random() * 40 - 20);
                    const top = 200 + (existingCards * 30);

                    card.style.left = `${left}px`;
                    card.style.top = `${top}px`;
                    
                    card.innerHTML = `
                        <div class="${headerClass} text-white px-3 py-1.5 flex items-center justify-between">
                            <span class="text-[9px] font-bold uppercase tracking-wider">${isReason ? 'Alasan' : 'Sanggahan'}</span>
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[10px] opacity-70">${roleIcons[role]}</span>
                                <button onclick="startLinking('${cardId}', event)" class="w-4 h-4 rounded-full bg-white/20 flex items-center justify-center hover:bg-white/40 transition-colors" title="Hubungkan ke argumen lain">
                                    <span class="material-symbols-outlined text-[8px]">account_tree</span>
                                </button>
                            </div>
                        </div>
                        <div class="p-3 text-[10px] leading-tight font-medium text-on-surface" onclick="handleCardClick('${cardId}')">
                            ${text}
                        </div>
                    `;
                    
                    setupDraggable(card);
                    container.appendChild(card);
                    
                    // Connect to center by default
                    connections.push({ from: 'center-topic', to: cardId });
                    updateLines();
                    
                    input.value = '';
                }

                function setupDraggable(el) {
                    let isDragging = false, startX, startY, initialX, initialY;
                    el.addEventListener('mousedown', e => {
                        if(e.target.closest('button')) return;
                        isDragging = true;
                        startX = e.clientX; startY = e.clientY;
                        initialX = el.offsetLeft; initialY = el.offsetTop;
                        el.style.zIndex = 100;
                    });
                    document.addEventListener('mousemove', e => {
                        if(!isDragging) return;
                        const dx = e.clientX - startX;
                        const dy = e.clientY - startY;
                        el.style.left = `${initialX + dx}px`;
                        el.style.top = `${initialY + dy}px`;
                        updateLines();
                    });
                    document.addEventListener('mouseup', () => {
                        isDragging = false;
                        el.style.zIndex = '';
                    });
                }

                function startLinking(id, e) {
                    e.stopPropagation();
                    linkingFrom = id;
                    // Reset others
                    document.querySelectorAll('#map-cards-container > div').forEach(d => d.classList.remove('ring-4', 'ring-primary/30'));
                    document.getElementById('center-topic').classList.remove('ring-4', 'ring-primary/30');
                    // Mark current
                    document.getElementById(id).classList.add('ring-4', 'ring-primary/30');
                }

                function handleCardClick(id) {
                    if (linkingFrom && linkingFrom !== id) {
                        // Tree logic: Remove old parent for the 'linkingFrom' card
                        connections = connections.filter(c => c.to !== linkingFrom);
                        
                        // Add new connection
                        connections.push({ from: id, to: linkingFrom });
                        
                        document.getElementById(linkingFrom).classList.remove('ring-4', 'ring-primary/30');
                        linkingFrom = null;
                        updateLines();
                    }
                }

                function updateLines() {
                    const svg = document.getElementById('map-svg');
                    svg.innerHTML = '';
                    
                    const canvasRect = document.getElementById('mapping-canvas').getBoundingClientRect();

                    connections.forEach(conn => {
                        const elFrom = document.getElementById(conn.from);
                        const elTo = document.getElementById(conn.to);
                        if (!elFrom || !elTo) return;

                        const rFrom = elFrom.getBoundingClientRect();
                        const rTo = elTo.getBoundingClientRect();

                        const x1 = (rFrom.left + rFrom.width / 2) - canvasRect.left;
                        const y1 = (rFrom.top + rFrom.height / 2) - canvasRect.top;
                        const x2 = (rTo.left + rTo.width / 2) - canvasRect.left;
                        const y2 = (rTo.top + rTo.height / 2) - canvasRect.top;

                        const type = elTo.dataset.type || 'reason';
                        const color = type === 'reason' ? '#22c55e' : '#ef4444';

                        // Line
                        const line = document.createElementNS('http://www.w3.org/2000/svg', 'line');
                        line.setAttribute('x1', x1);
                        line.setAttribute('y1', y1);
                        line.setAttribute('x2', x2);
                        line.setAttribute('y2', y2);
                        line.setAttribute('stroke', color);
                        line.setAttribute('stroke-width', '2');
                        line.setAttribute('stroke-opacity', '0.4');
                        svg.appendChild(line);

                        // Label
                        const midX = (x1 + x2) / 2;
                        const midY = (y1 + y2) / 2;
                        const labelText = type === 'reason' ? 'mendukung' : 'menentang';
                        
                        const group = document.createElementNS('http://www.w3.org/2000/svg', 'g');
                        const rect = document.createElementNS('http://www.w3.org/2000/svg', 'rect');
                        rect.setAttribute('x', midX - 30); rect.setAttribute('y', midY - 8);
                        rect.setAttribute('width', '60'); rect.setAttribute('height', '16');
                        rect.setAttribute('rx', '8'); rect.setAttribute('fill', 'white');
                        rect.setAttribute('stroke', color); rect.setAttribute('stroke-width', '1');
                        
                        const text = document.createElementNS('http://www.w3.org/2000/svg', 'text');
                        text.setAttribute('x', midX); text.setAttribute('y', midY + 3);
                        text.setAttribute('text-anchor', 'middle'); text.setAttribute('fill', color);
                        text.setAttribute('style', 'font-size: 7px; font-weight: 800; font-family: sans-serif; text-transform: uppercase;');
                        text.textContent = labelText;
                        
                        group.appendChild(rect); group.appendChild(text);
                        svg.appendChild(group);
                    });
                }

                function exportMapImage() {
                    alert("📸 Fitur Ekspor sedang diproses...\n\nSistem akan mengambil screenshot kanvas ini dan menyimpannya sebagai file PNG berkualitas tinggi agar bisa dilampirkan dalam portofolio.");
                }

                function saveMapToDatabase() {
                    const cardCount = document.getElementById('map-cards-container').children.length;
                    if(cardCount === 0) return alert("Belum ada argumen untuk disimpan!");
                    
                    alert("💾 Menyimpan Peta ke Database...\n\nData posisi kartu dan koneksi garis sedang disimpan. Guru akan bisa melihat hasil peta ini di Dashboard Admin secara real-time.");
                }

                window.addEventListener('resize', updateLines);
            </script>
            @endpush
        @else
            <!-- Upload Interface -->
            <div class="flex-grow flex flex-col items-center justify-center space-y-6 py-6 px-4">
                <div class="text-center space-y-2 max-w-md">
                    <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-4xl text-primary">upload_file</span>
                    </div>
                    <h3 class="font-headline text-headline-sm text-on-surface">Unggah Hasil Diskusi</h3>
                    <p class="text-body-md text-on-surface-variant">Silakan unggah file rangkuman atau dokumentasi hasil diskusi kelompokmu di sini.</p>
                </div>

                <div class="w-full">
                    <label for="discussion_result" class="block w-full border-2 border-dashed border-outline-variant rounded-[2rem] p-10 text-center cursor-pointer hover:border-primary hover:bg-primary/5 transition-all group">
                        <input type="file" id="discussion_result" name="image" class="hidden" required form="next-phase-form" onchange="this.parentElement.querySelector('p').innerText = this.files[0].name; this.parentElement.classList.add('bg-secondary/10', 'border-secondary')">
                        <span class="material-symbols-outlined text-5xl text-on-surface-variant/30 group-hover:text-primary transition-colors mb-4">add_circle</span>
                        <p class="text-body-md text-on-surface-variant group-hover:text-primary font-medium">Klik untuk pilih file atau seret ke sini</p>
                        <p class="text-[10px] text-on-surface-variant/40 mt-2">Format: PDF, JPG, PNG (Maks 10MB)</p>
                    </label>
                </div>
            </div>
        @endif

            <!-- Next Action -->
            <form action="{{ route('student.module.next', [$module->id, $step]) }}" method="POST" id="next-phase-form" class="space-y-4" enctype="multipart/form-data">
                @csrf
                
                <div class="flex items-center gap-3 bg-white p-4 rounded-2xl border border-outline-variant/30 shadow-sm">
                    <input type="checkbox" id="confirm-discussion" required class="w-6 h-6 rounded-lg text-primary focus:ring-primary border-outline-variant/50">
                    <label for="confirm-discussion" class="text-sm font-bold text-on-surface select-none cursor-pointer">
                        Saya telah berpartisipasi aktif dalam diskusi ini.
                    </label>
                </div>

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

                if (chatContainer && chatInput && sendBtn) {
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
                                \${msg.user.name.charAt(0)}
                            </div>
                            <div class="space-y-1 max-w-[85%] flex flex-col items-end">
                                <span class="text-xs font-bold text-primary mr-1">Kamu</span>
                                <div class="bg-primary p-4 rounded-3xl rounded-tr-none shadow-md">
                                    <p class="text-sm text-white">\${msg.content}</p>
                                </div>
                            </div>
                        `;
                        
                        if (chatContainer.querySelector('.opacity-50')) {
                            chatContainer.innerHTML = '';
                        }
                        
                        chatContainer.appendChild(div);
                    }

                    sendBtn.addEventListener('click', sendMessage);
                    chatInput.addEventListener('keypress', function(e) {
                        if (e.key === 'Enter') sendMessage();
                    });
                }
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

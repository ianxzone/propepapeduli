@extends(Auth::user()->role === 'teacher' ? 'layouts.teacher' : 'layouts.admin')

@section('title', 'Forum Diskusi - ProPePa')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                <h2 class="font-headline text-headline-md text-on-surface">Monitor Forum Diskusi</h2>
                @if(in_array(Auth::user()->role, ['admin', 'dosen']))
                    <form action="{{ route('teacher.forum.index') }}" method="GET" id="class-selector-form-forum">
                        <select name="class_id" onchange="this.form.submit()" class="bg-surface-container-low border-none rounded-full px-4 py-1 text-xs font-bold text-primary focus:ring-2 focus:ring-primary">
                            <option value="">Pilih Kelas...</option>
                            @foreach($classes as $c)
                                <option value="{{ $c->id }}" {{ ($class?->id == $c->id) ? 'selected' : '' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </form>
                @endif
            </div>
            <p class="text-on-surface-variant text-sm">Lihat aktivitas diskusi siswa di kelas {{ $class?->name ?? '---' }}.</p>
        </div>
        
        <!-- Selectors -->
        <form action="{{ route('teacher.forum.index') }}" method="GET" class="flex flex-wrap items-center gap-4">
            <input type="hidden" name="class_id" value="{{ $class?->id }}">
            <div class="flex items-center gap-2">
                <label class="text-xs font-bold text-outline uppercase tracking-widest whitespace-nowrap">Modul:</label>
                <select name="module_id" onchange="this.form.submit()" class="bg-white border border-outline-variant/30 rounded-xl px-4 py-2 text-xs font-bold focus:border-primary focus:ring-0">
                    @foreach($modules as $module)
                        <option value="{{ $module->id }}" {{ $selectedModuleId == $module->id ? 'selected' : '' }}>{{ $module->title }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex items-center gap-2">
                <label class="text-xs font-bold text-outline uppercase tracking-widest whitespace-nowrap">Kelompok:</label>
                <select name="group_id" onchange="this.form.submit()" class="bg-white border border-outline-variant/30 rounded-xl px-4 py-2 text-xs font-bold focus:border-primary focus:ring-0">
                    <option value="">Semua Kelompok</option>
                    @foreach($groups as $group)
                        <option value="{{ $group->id }}" {{ $selectedGroupId == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    <!-- Monitoring Area -->
    @php
        $discussionType = $selectedModule->content['D']['type'] ?? 'chat';
    @endphp

    @if($discussionType === 'map')
        <div class="bg-white rounded-[2rem] border border-outline-variant/30 shadow-sm overflow-hidden flex flex-col h-[700px]">
            <div class="p-6 border-b border-outline-variant/30 bg-surface-container-low flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">account_tree</span>
                    <span class="font-bold">Peta Argumen: {{ $groups->where('id', $selectedGroupId)->first()?->name ?? 'Pilih Kelompok' }}</span>
                </div>
            </div>

            <div class="flex-1 relative bg-surface-container-low overflow-hidden shadow-inner" id="mapping-canvas" style="background-image: radial-gradient(#e5e7eb 1px, transparent 1px); background-size: 20px 20px;">
                @if(!$selectedGroupId)
                    <div class="absolute inset-0 flex flex-col items-center justify-center text-on-surface-variant italic">
                        <span class="material-symbols-outlined text-5xl mb-3 opacity-20">groups</span>
                        <p>Pilih kelompok untuk melihat peta argumen mereka.</p>
                    </div>
                @elseif(!$groupMap)
                    <div class="absolute inset-0 flex flex-col items-center justify-center text-on-surface-variant italic">
                        <span class="material-symbols-outlined text-5xl mb-3 opacity-20">cloud_off</span>
                        <p>Kelompok ini belum menyimpan peta argumen.</p>
                    </div>
                @else
                    <!-- SVG for Lines -->
                    <svg id="map-svg" class="absolute inset-0 w-full h-full pointer-events-none" style="z-index: 5;"></svg>

                    <!-- Target/Center Topic -->
                    <div id="center-topic" class="absolute top-10 left-1/2 -translate-x-1/2 bg-white rounded-xl border-2 border-primary shadow-lg z-10 overflow-hidden w-64">
                        <div class="bg-primary text-white text-[10px] font-bold uppercase tracking-widest px-4 py-1.5 text-center">Isu Utama</div>
                        <div class="p-3 text-xs font-bold text-on-surface text-center leading-relaxed">
                            {!! $selectedModule->content['D']['topic'] ?? 'Isu Utama' !!}
                        </div>
                    </div>
                    
                    <!-- Cards Container -->
                    <div id="map-cards-container" class="absolute inset-0 w-full h-full pointer-events-none">
                        @foreach($groupMap->content['cards'] as $card)
                            <div id="{{ $card['id'] }}" data-type="{{ $card['type'] }}" 
                                 class="absolute pointer-events-none rounded-xl border-2 shadow-md w-48 bg-white {{ $card['type'] === 'reason' ? 'border-green-200' : 'border-red-200' }} overflow-hidden"
                                 style="left: {{ $card['left'] }}; top: {{ $card['top'] }};">
                                <div class="{{ $card['type'] === 'reason' ? 'bg-green-500' : 'bg-red-500' }} text-white px-3 py-1.5 flex items-center justify-between">
                                    <span class="text-[9px] font-bold uppercase tracking-wider">{{ $card['type'] === 'reason' ? 'Alasan' : 'Sanggahan' }}</span>
                                    <span class="text-[8px] opacity-70 font-bold">{{ $card['role'] ?? '' }}</span>
                                </div>
                                <div class="p-3 text-[10px] leading-tight font-medium text-on-surface">
                                    {{ $card['text'] }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <script>
                        let connections = {!! json_encode($groupMap->content['connections'] ?? []) !!};
                        
                        function renderMap(data) {
                            if (!data || !data.cards) return;
                            const container = document.getElementById('map-cards-container');
                            
                            // Store existing IDs to avoid re-rendering everything
                            data.cards.forEach(cardData => {
                                let card = document.getElementById(cardData.id);
                                if (!card) {
                                    card = document.createElement('div');
                                    card.id = cardData.id;
                                    container.appendChild(card);
                                }
                                
                                card.dataset.type = cardData.type;
                                const isReason = cardData.type === 'reason';
                                const themeClass = isReason ? 'border-green-200' : 'border-red-200';
                                const headerClass = isReason ? 'bg-green-500' : 'bg-red-500';
                                
                                card.className = `absolute pointer-events-none rounded-xl border-2 shadow-md w-48 bg-white ${themeClass} overflow-hidden`;
                                card.style.left = cardData.left;
                                card.style.top = cardData.top;
                                
                                card.innerHTML = `
                                    <div class="${headerClass} text-white px-3 py-1.5 flex items-center justify-between">
                                        <span class="text-[9px] font-bold uppercase tracking-wider">${isReason ? 'Alasan' : 'Sanggahan'}</span>
                                        <span class="text-[8px] opacity-70 font-bold">${cardData.role || ''}</span>
                                    </div>
                                    <div class="p-3 text-[10px] leading-tight font-medium text-on-surface">
                                        ${cardData.text}
                                    </div>
                                `;
                            });

                            connections = data.connections || [];
                            updateLines();
                        }

                        function updateLines() {
                            const svg = document.getElementById('map-svg');
                            if(!svg) return;
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

                                const line = document.createElementNS('http://www.w3.org/2000/svg', 'line');
                                line.setAttribute('x1', x1); line.setAttribute('y1', y1);
                                line.setAttribute('x2', x2); line.setAttribute('y2', y2);
                                line.setAttribute('stroke', color); line.setAttribute('stroke-width', '2');
                                line.setAttribute('stroke-opacity', '0.4');
                                svg.appendChild(line);
                            });
                        }

                        window.addEventListener('load', updateLines);
                        window.addEventListener('resize', updateLines);

                        // Auto-Sync Polling for Teacher
                        setInterval(() => {
                            fetch("{{ route('student.discussion.map.get') }}?module_id={{ $selectedModuleId }}&group_id={{ $selectedGroupId }}")
                                .then(res => res.json())
                                .then(data => {
                                    if (data.success && data.map) {
                                        renderMap(data.map.content);
                                    }
                                });
                        }, 15000); // 15 seconds
                    </script>
                @endif
            </div>
        </div>
    @else
        <!-- Chat Monitoring Area -->
        <div class="bg-white rounded-[2rem] border border-outline-variant/30 shadow-sm overflow-hidden flex flex-col h-[600px]">
            <div class="p-6 border-b border-outline-variant/30 bg-surface-container-low flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">forum</span>
                    <span class="font-bold">Diskusi Kelas</span>
                </div>
                <span class="text-xs font-medium text-on-surface-variant">{{ count($messages) }} Pesan Terkirim</span>
            </div>

            <div class="flex-1 overflow-y-auto p-6 space-y-6 bg-surface-container-lowest">
                @forelse($messages as $msg)
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary-container text-white flex items-center justify-center font-bold shrink-0">
                            {{ substr($msg->user->name, 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <div class="flex items-baseline gap-2 mb-1">
                                <span class="font-bold text-sm text-on-surface">{{ $msg->user->name }}</span>
                                @if($msg->group)
                                    <span class="bg-secondary/10 text-secondary text-[8px] font-bold px-2 py-0.5 rounded-full border border-secondary/20">{{ $msg->group->name }}</span>
                                @endif
                                <span class="text-[10px] text-on-surface-variant">{{ $msg->created_at->format('H:i') }}</span>
                            </div>
                            <div class="bg-white border border-outline-variant/20 p-4 rounded-2xl rounded-tl-none shadow-sm inline-block max-w-[80%]">
                                <p class="text-sm text-on-surface leading-relaxed">{{ $msg->content }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="h-full flex flex-col items-center justify-center text-on-surface-variant italic">
                        <span class="material-symbols-outlined text-5xl mb-3 opacity-20">chat_bubble</span>
                        <p>Belum ada diskusi di modul ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    @endif
</div>
@endsection

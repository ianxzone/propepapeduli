@extends(Auth::user()->role === 'teacher' ? 'layouts.teacher' : 'layouts.admin')

@section('title', 'Kelola Kelompok - ' . $class->name)
@section('header_title', 'Manajemen Kel. Diskusi')

@section('content')
<div class="space-y-6">
    <!-- Header Action -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                <h1 class="font-headline text-headline-md text-on-surface">Kelompok Kelas {{ $class?->name ?? '---' }}</h1>
                @if(Auth::user()->role === 'admin')
                    <form action="{{ route('teacher.groups.index') }}" method="GET" id="class-selector-form">
                        <select name="class_id" onchange="this.form.submit()" class="bg-surface-container-low border-none rounded-full px-4 py-1 text-xs font-bold text-primary focus:ring-2 focus:ring-primary">
                            <option value="">Pilih Kelas...</option>
                            @foreach($classes as $c)
                                <option value="{{ $c->id }}" {{ ($class?->id == $c->id) ? 'selected' : '' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </form>
                @endif
            </div>
            <p class="text-sm text-on-surface-variant">Tentukan kelompok diskusi agar siswa bisa berkolaborasi dalam tim kecil.</p>
        </div>
        @if($class)
        <button onclick="document.getElementById('modal-add-group').classList.remove('hidden')" class="bg-primary text-white px-6 py-3 rounded-2xl font-bold flex items-center gap-2 shadow-sm hover:bg-primary-container transition-all">
            <span class="material-symbols-outlined">group_add</span>
            Buat Kelompok Baru
        </button>
        @endif
    </div>

    <!-- Groups Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($groups as $group)
        <div class="bg-white rounded-3xl border border-outline-variant/30 shadow-sm overflow-hidden flex flex-col">
            <div class="p-6 border-b border-outline-variant/10 bg-surface-container-low flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-secondary-container/20 text-secondary flex items-center justify-center font-bold">
                        {{ substr($group->name, 0, 1) }}
                    </div>
                    <h3 class="font-bold text-on-surface">{{ $group->name }}</h3>
                </div>
                <form action="{{ route('teacher.groups.delete', $group->id) }}" method="POST" onsubmit="return confirm('Hapus kelompok ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-outline hover:text-error transition-colors">
                        <span class="material-symbols-outlined text-xl">delete</span>
                    </button>
                </form>
            </div>
            
            <div class="p-6 flex-1 space-y-4">
                <div class="flex items-center justify-between text-xs font-bold text-outline uppercase tracking-widest">
                    <span>Anggota ({{ $group->students->count() }})</span>
                    <button onclick="openAssignModal('{{ $group->id }}', '{{ $group->name }}')" class="text-primary hover:underline">Kelola Anggota</button>
                </div>
                
                <div class="space-y-2 max-h-48 overflow-y-auto no-scrollbar">
                    @forelse($group->students as $student)
                    <div class="flex items-center gap-2 p-2 bg-surface-container-lowest rounded-xl border border-outline-variant/20">
                        <div class="w-6 h-6 rounded-full bg-primary/10 text-primary text-[10px] flex items-center justify-center font-bold">
                            {{ substr($student->name, 0, 1) }}
                        </div>
                        <span class="text-xs font-medium text-on-surface">{{ $student->name }}</span>
                    </div>
                    @empty
                    <p class="text-[10px] text-on-surface-variant italic text-center py-4">Belum ada anggota.</p>
                    @endforelse
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full bg-surface-container-lowest border-2 border-dashed border-outline-variant/30 rounded-[2rem] p-12 text-center">
            <span class="material-symbols-outlined text-6xl text-outline/30 mb-4">groups</span>
            <h3 class="font-bold text-on-surface">Belum Ada Kelompok</h3>
            <p class="text-sm text-on-surface-variant max-w-xs mx-auto mt-2">Buat kelompok pertama untuk membagi siswa ke dalam tim diskusi kecil.</p>
        </div>
        @endforelse
    </div>

    <!-- Student List Without Group -->
    @php
        $unassignedStudents = $students->whereNull('group_id');
    @endphp
    @if($unassignedStudents->count() > 0)
    <div class="bg-secondary-container/5 rounded-[2rem] border border-secondary-container/20 p-8">
        <div class="flex items-center gap-3 mb-6">
            <span class="material-symbols-outlined text-secondary">person_off</span>
            <h2 class="font-headline text-headline-sm text-on-surface">Siswa Belum Berkelompok</h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($unassignedStudents as $student)
            <div class="bg-white p-3 rounded-2xl border border-outline-variant/30 text-center space-y-2">
                <div class="w-10 h-10 rounded-full bg-surface-variant/20 mx-auto flex items-center justify-center text-outline font-bold">
                    {{ substr($student->name, 0, 1) }}
                </div>
                <p class="text-[10px] font-bold text-on-surface truncate">{{ $student->name }}</p>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<!-- Modal: Add Group -->
<div id="modal-add-group" class="fixed inset-0 z-[100] hidden overflow-y-auto">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="this.parentElement.classList.add('hidden')"></div>
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md bg-white rounded-[2rem] shadow-2xl overflow-hidden animate-in zoom-in duration-200">
            <div class="p-8 space-y-6">
                <h3 class="font-headline text-headline-sm text-primary">Buat Kelompok Baru</h3>
                <form action="{{ route('teacher.groups.store') }}" method="POST" class="space-y-4">
                    @csrf
                    @if($class)
                        <input type="hidden" name="class_id" value="{{ $class->id }}">
                    @endif
                    <div>
                        <label class="text-xs font-bold text-outline uppercase tracking-widest mb-2 block">Nama Kelompok</label>
                        <input type="text" name="name" required placeholder="Contoh: Kelompok Merpati" class="w-full h-12 px-4 rounded-xl border-2 border-outline-variant/30 focus:border-primary focus:ring-0 transition-all text-sm">
                    </div>
                    <div class="flex gap-3 pt-2">
                        <button type="button" onclick="document.getElementById('modal-add-group').classList.add('hidden')" class="flex-1 h-12 rounded-xl border border-outline-variant font-bold text-on-surface-variant hover:bg-surface-container transition-all">Batal</button>
                        <button type="submit" class="flex-1 h-12 rounded-xl bg-primary text-white font-bold shadow-md hover:bg-primary-container transition-all">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Assign Students -->
<div id="modal-assign" class="fixed inset-0 z-[100] hidden overflow-y-auto">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="this.parentElement.classList.add('hidden')"></div>
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-2xl bg-white rounded-[2rem] shadow-2xl overflow-hidden animate-in zoom-in duration-200">
            <div class="p-6 md:p-8 space-y-6">
                <div class="flex items-center justify-between">
                    <h3 class="font-headline text-headline-sm text-primary">Kelola Anggota: <span id="group-name-label" class="text-on-surface"></span></h3>
                    <button onclick="document.getElementById('modal-assign').classList.add('hidden')" class="text-outline hover:text-on-surface">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                
                <form id="assign-form" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-[50vh] overflow-y-auto p-2 border border-outline-variant/20 rounded-2xl bg-surface-container-low">
                        @foreach($students as $student)
                        <label class="flex items-center gap-3 p-3 bg-white rounded-xl border border-outline-variant/30 cursor-pointer hover:border-primary transition-all">
                            <input type="checkbox" name="student_ids[]" value="{{ $student->id }}" 
                                   class="w-5 h-5 rounded text-primary focus:ring-primary border-outline-variant/50"
                                   @if($student->group_id) data-current-group="{{ $student->group_id }}" @endif>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-on-surface">{{ $student->name }}</p>
                                @if($student->group_id)
                                    <p class="text-[10px] text-secondary font-bold uppercase tracking-widest">Saat ini: {{ $student->group->name }}</p>
                                @else
                                    <p class="text-[10px] text-outline-variant font-bold uppercase tracking-widest italic">Belum berkelompok</p>
                                @endif
                            </div>
                        </label>
                        @endforeach
                    </div>
                    
                    <div class="bg-primary/5 p-4 rounded-xl border border-primary/10 flex gap-3">
                        <span class="material-symbols-outlined text-primary text-sm">info</span>
                        <p class="text-[10px] text-on-surface-variant italic">Memasukkan siswa ke kelompok ini akan secara otomatis mengeluarkan mereka dari kelompok sebelumnya.</p>
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" onclick="document.getElementById('modal-assign').classList.add('hidden')" class="px-6 h-12 rounded-xl border border-outline-variant font-bold text-on-surface-variant hover:bg-surface-container transition-all">Batal</button>
                        <button type="submit" class="px-8 h-12 rounded-xl bg-primary text-white font-bold shadow-md hover:bg-primary-container transition-all">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openAssignModal(groupId, groupName) {
        document.getElementById('group-name-label').innerText = groupName;
        const form = document.getElementById('assign-form');
        form.action = "{{ url('guru/groups') }}/" + groupId + "/assign";
        
        // Reset checkboxes
        const checkboxes = form.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(cb => {
            cb.checked = cb.getAttribute('data-current-group') === groupId;
        });

        document.getElementById('modal-assign').classList.remove('hidden');
    }
</script>
@endsection

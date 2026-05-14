@props(['active' => 'home'])

<nav class="fixed bottom-0 left-0 w-full bg-white/80 backdrop-blur-lg border-t border-outline-variant/30 px-6 py-3 flex justify-between items-center z-50">
    <a href="{{ route('student.dashboard') }}" class="flex flex-col items-center gap-1 {{ $active === 'home' ? 'text-primary' : 'text-outline' }}">
        <span class="material-symbols-outlined" style="{{ $active === 'home' ? "font-variation-settings: 'FILL' 1;" : "" }}">home</span>
        <span class="text-[10px] font-bold">Beranda</span>
    </a>
    <a href="#" class="flex flex-col items-center gap-1 {{ $active === 'modul' ? 'text-primary' : 'text-outline' }}">
        <span class="material-symbols-outlined" style="{{ $active === 'modul' ? "font-variation-settings: 'FILL' 1;" : "" }}">menu_book</span>
        <span class="text-[10px] font-bold">Modul</span>
    </a>
    <a href="{{ route('student.leaderboard') }}" class="flex flex-col items-center gap-1 {{ $active === 'leaderboard' ? 'text-primary' : 'text-outline' }}">
        <span class="material-symbols-outlined" style="{{ $active === 'leaderboard' ? "font-variation-settings: 'FILL' 1;" : "" }}">leaderboard</span>
        <span class="text-[10px] font-bold">Peringkat</span>
    </a>
    <a href="{{ route('student.journals.index') }}" class="flex flex-col items-center gap-1 {{ $active === 'jurnal' ? 'text-primary' : 'text-outline' }}">
        <span class="material-symbols-outlined" style="{{ $active === 'jurnal' ? "font-variation-settings: 'FILL' 1;" : "" }}">edit_square</span>
        <span class="text-[10px] font-bold">Jurnal</span>
    </a>
    <a href="{{ route('student.profile') }}" class="flex flex-col items-center gap-1 {{ $active === 'profil' ? 'text-primary' : 'text-outline' }}">
        <span class="material-symbols-outlined" style="{{ $active === 'profil' ? "font-variation-settings: 'FILL' 1;" : "" }}">person</span>
        <span class="text-[10px] font-bold">Profil</span>
    </a>
</nav>

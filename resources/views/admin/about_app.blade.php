@extends('layouts.admin')

@section('title', 'Tentang Aplikasi - ProPePa')
@section('header_title', 'Tentang Aplikasi')

@section('content')
<div class="space-y-8">
    <!-- Hero Info -->
    <div class="bg-primary rounded-[3rem] p-12 text-white relative overflow-hidden shadow-2xl">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 blur-3xl rounded-full translate-x-1/2 -translate-y-1/2"></div>
        <div class="relative z-10 max-w-2xl space-y-6">
            <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-md px-4 py-2 rounded-full text-xs font-bold uppercase tracking-widest">
                Versi 1.0.0 Stable
            </div>
            <h1 class="font-headline text-4xl md:text-5xl font-bold">ProPePa PEDULI</h1>
            <p class="text-white/80 text-lg leading-relaxed">
                Platform Learning Management System (LMS) inovatif yang dirancang khusus untuk mendukung Proyek Penguatan Profil Pelajar Pancasila melalui pendekatan Isu Sosiosaintifik.
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- System Status -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-[2.5rem] p-8 border border-outline-variant/30 shadow-sm">
                <h3 class="font-headline font-bold text-xl mb-6">Informasi Sistem</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-3 border-b border-outline-variant/20">
                        <span class="text-sm text-on-surface-variant">Tipe Platform</span>
                        <span class="text-sm font-bold text-primary">LMS Portabel</span>
                    </div>
                    <div class="flex justify-between items-center py-3">
                        <span class="text-sm text-on-surface-variant">Update Terakhir</span>
                        <span class="text-sm font-bold text-on-surface">{{ date('d M Y') }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-secondary/5 rounded-[2.5rem] p-8 border border-secondary/10">
                <div class="w-12 h-12 rounded-2xl bg-secondary text-white flex items-center justify-center mb-6">
                    <span class="material-symbols-outlined">verified_user</span>
                </div>
                <h3 class="font-headline font-bold text-xl mb-4 text-on-surface">Keamanan Terintegrasi</h3>
                <p class="text-sm text-on-surface-variant leading-relaxed">
                    Dilengkapi dengan proteksi Rate Limiting, Security Headers (CSP), dan sistem Activity Log untuk menjamin integritas data dan keamanan pengguna.
                </p>
            </div>
        </div>

        <!-- App Capabilities -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-[2.5rem] p-10 border border-outline-variant/30 shadow-sm space-y-8">
                <h3 class="font-headline font-bold text-2xl text-on-surface">Keunggulan Platform</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center font-bold">01</div>
                        <div>
                            <h4 class="font-bold text-on-surface mb-2">Siklus PEDULI</h4>
                            <p class="text-xs text-on-surface-variant leading-relaxed">Metodologi 6 fase (Peka, Eksplorasi, Diskusi, Ungkapkan, Lakukan, Introspeksi) yang terstruktur.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center font-bold">02</div>
                        <div>
                            <h4 class="font-bold text-on-surface mb-2">Gamifikasi</h4>
                            <p class="text-xs text-on-surface-variant leading-relaxed">Sistem poin dan lencana untuk meningkatkan motivasi belajar siswa sekolah dasar.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center font-bold">03</div>
                        <div>
                            <h4 class="font-bold text-on-surface mb-2">Real-time Forum</h4>
                            <p class="text-xs text-on-surface-variant leading-relaxed">Interaksi diskusi antar siswa dan bimbingan guru secara langsung dalam platform.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center font-bold">04</div>
                        <div>
                            <h4 class="font-bold text-on-surface mb-2">Audit Trail</h4>
                            <p class="text-xs text-on-surface-variant leading-relaxed">Pencatatan setiap aktivitas administratif untuk transparansi pengelolaan data.</p>
                        </div>
                    </div>
                </div>

                <hr class="border-outline-variant/20">

                <div class="space-y-4">
                    <h4 class="font-bold text-on-surface">Tim Pengembang</h4>
                    <p class="text-sm text-on-surface-variant leading-relaxed">
                        Platform ini dikembangkan oleh tim ahli pendidikan dan teknologi untuk mewujudkan transformasi digital pendidikan di Indonesia, selaras dengan visi Indonesia Emas 2045.
                    </p>
                    <div class="flex items-center gap-4 pt-2">
                        <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white font-bold text-xs">F</div>
                        <div class="w-10 h-10 rounded-full bg-secondary flex items-center justify-center text-white font-bold text-xs">B</div>
                        <div class="w-10 h-10 rounded-full bg-tertiary flex items-center justify-center text-white font-bold text-xs">M</div>
                        <span class="text-xs font-bold text-outline">+ Tim Ahli</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.admin')

@section('title', 'Tentang Aplikasi - ProPePa')
@section('header_title', 'Tentang Aplikasi')

@section('content')
<div class="space-y-8">
    <!-- Hero Info -->
    <div class="bg-primary rounded-[3rem] p-8 md:p-12 text-white relative overflow-hidden shadow-2xl">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 blur-3xl rounded-full translate-x-1/2 -translate-y-1/2"></div>
        <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            <!-- Left Side: LMS Info -->
            <div class="lg:col-span-7 space-y-6">
                <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-md px-4 py-2 rounded-full text-xs font-bold uppercase tracking-widest">
                    Versi 1.0.0 Stable
                </div>
                <h1 class="font-headline text-4xl md:text-5xl font-bold">ProPePa PEDULI</h1>
                <p class="text-white/80 text-base md:text-lg leading-relaxed">
                    Platform Learning Management System (LMS) inovatif yang dirancang khusus untuk mendukung Proyek Penguatan Profil Pelajar Pancasila melalui pendekatan Isu Sosiosaintifik.
                </p>
            </div>

            <!-- Right Side: MATEK Promotion (Beautiful glassmorphism matching the design system) -->
            <div class="lg:col-span-5 bg-white/10 backdrop-blur-md p-6 rounded-3xl border border-white/20 space-y-4">
                <div class="space-y-1.5">
                    <h4 class="font-headline font-bold text-base md:text-lg text-white">Tertarik Membangun LMS Serupa?</h4>
                    <p class="text-xs text-white/80 leading-relaxed">
                        Hubungi tim pengembang kami di <strong>CV. Murni Abadi Teknologi (MATEK)</strong> untuk konsultasi kebutuhan website, aplikasi, atau LMS kustom Anda.
                    </p>
                </div>
                <div class="flex flex-wrap gap-2 pt-1">
                    <a href="https://murniabadi.co.id" target="_blank" class="px-3.5 py-2 bg-white/20 hover:bg-white/30 text-white rounded-xl text-xs font-bold transition-all border border-white/25 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-sm">language</span>
                        Website
                    </a>
                    <a href="https://wa.me/6285215353973?text=Halo%20MATEK,%20saya%20tertarik%20untuk%20berkonsultasi%20membuat%20sistem%20atau%20LMS%20serupa%20dengan%20ProPePa%20PEDULI." target="_blank" class="px-3.5 py-2 bg-white rounded-xl text-xs font-bold shadow-md transition-all flex items-center gap-1.5 hover:bg-white/95" style="color: #410002;">
                        <span class="material-symbols-outlined text-sm">chat</span>
                        Hubungi WA
                    </a>
                </div>
            </div>
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

                <div class="space-y-6">
                    <div>
                        <h4 class="font-bold text-on-surface text-lg">Tim Pengembang & Mitra Akademik</h4>
                        <p class="text-xs text-on-surface-variant mt-1">
                            Platform ini lahir dari kolaborasi erat antara peneliti pendidikan dan praktisi teknologi informasi terpercaya.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Member 1 -->
                        <div class="flex items-center gap-3.5 p-3 rounded-2xl bg-surface-container-low border border-outline-variant/20 transition-all hover:shadow-sm">
                            <div class="w-12 h-12 rounded-full overflow-hidden border border-outline-variant/30 shrink-0">
                                <img src="https://propepapeduli.id/assets/img/team/farid.png" alt="Faridillah Fahmi N" class="w-full h-full object-cover" onerror="this.src='https://ui-avatars.com/api/?name=Faridillah+Fahmi+N&size=100&background=F9DEDC&color=410002'">
                            </div>
                            <div class="min-w-0">
                                <h5 class="text-xs font-bold text-on-surface truncate">Faridillah Fahmi N, M.Pd.</h5>
                                <p class="text-[10px] text-primary font-semibold leading-none mt-0.5">Peneliti Utama (Disertasi)</p>
                                <p class="text-[9px] text-on-surface-variant font-semibold mt-0.5">IKIP Siliwangi / UPI</p>
                            </div>
                        </div>

                        <!-- Member 2 -->
                        <div class="flex items-center gap-3.5 p-3 rounded-2xl bg-surface-container-low border border-outline-variant/20 transition-all hover:shadow-sm">
                            <div class="w-12 h-12 rounded-full overflow-hidden border border-outline-variant/30 shrink-0">
                                <img src="https://propepapeduli.id/assets/img/team/bunyamin.png" alt="Prof. Dr. Bunyamin Maftuh" class="w-full h-full object-cover" onerror="this.src='https://ui-avatars.com/api/?name=Bunyamin+Maftuh&size=100&background=F9DEDC&color=410002'">
                            </div>
                            <div class="min-w-0">
                                <h5 class="text-xs font-bold text-on-surface truncate">Prof. Dr. Bunyamin Maftuh, M.Pd., M.A.</h5>
                                <p class="text-[10px] text-primary font-semibold leading-none mt-0.5">Promotor</p>
                                <p class="text-[9px] text-on-surface-variant font-semibold mt-0.5">Universitas Pendidikan Indonesia</p>
                            </div>
                        </div>

                        <!-- Member 3 -->
                        <div class="flex items-center gap-3.5 p-3 rounded-2xl bg-surface-container-low border border-outline-variant/20 transition-all hover:shadow-sm">
                            <div class="w-12 h-12 rounded-full overflow-hidden border border-outline-variant/30 shrink-0">
                                <img src="https://propepapeduli.id/assets/img/team/mubiar.png" alt="Prof. Dr. Mubiar Agustin" class="w-full h-full object-cover" onerror="this.src='https://ui-avatars.com/api/?name=Mubiar+Agustin&size=100&background=F9DEDC&color=410002'">
                            </div>
                            <div class="min-w-0">
                                <h5 class="text-xs font-bold text-on-surface truncate">Prof. Dr. Mubiar Agustin, M.Pd.</h5>
                                <p class="text-[10px] text-primary font-semibold leading-none mt-0.5">Co-Promotor</p>
                                <p class="text-[9px] text-on-surface-variant font-semibold mt-0.5">Universitas Pendidikan Indonesia</p>
                            </div>
                        </div>

                        <!-- Member 4 (MATEK) -->
                        <div class="flex items-center gap-3.5 p-3 rounded-2xl bg-surface-container-low border border-outline-variant/20 transition-all hover:shadow-sm">
                            <div class="w-12 h-12 rounded-full overflow-hidden border border-outline-variant/30 bg-white shrink-0 p-1.5 flex items-center justify-center">
                                <img src="https://murniabadi.co.id/gambar/logomatek.png" alt="Logo MATEK" class="w-full h-auto object-contain">
                            </div>
                            <div class="min-w-0">
                                <h5 class="text-xs font-bold text-on-surface truncate">CV. Murni Abadi Teknologi</h5>
                                <p class="text-[10px] text-primary font-semibold leading-none mt-0.5">Sistem & Tek. Developer (MATEK)</p>
                                <p class="text-[9px] text-on-surface-variant font-semibold mt-0.5">Mitra Teknologi Informasi</p>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
@endsection

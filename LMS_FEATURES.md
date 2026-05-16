# ProPePa PEDULI LMS - Technical & Feature Specification

## Overview
**ProPePa PEDULI** adalah Platform Learning Management System (LMS) modern yang dirancang khusus untuk mendukung pembelajaran berbasis proyek dengan fokus pada pengembangan karakter **Profil Pelajar Pancasila**. Platform ini mengimplementasikan siklus pedagogi **PEDULI** (Pelajari, Eksplorasi, Diskusi, Ungkapkan, Lakukan, Introspeksi, Selesai).

> [!IMPORTANT]
> **Detail Teknis Implementasi Modul:**
> Untuk memahami bagaimana alur PEDULI diproses secara kode (JSON & Controller), silakan baca [MODULE_IMPLEMENTATION.md](file:///c:/laragon/www/propepapeduli/MODULE_IMPLEMENTATION.md).

## Technical Stack
- **Backend**: Laravel 11.x (PHP 8.3+)
- **Frontend**: Tailwind CSS, Vanilla JS, Blade Templates
- **Design System**: Material Design 3 inspired (Custom Tokens)
- **Features**: Real-time Discussion, SVG-based Argument Mapping, Activity Logging, Point-based Gamification.

## Role Hierarchy (Hirarki Peran)
1. **Super Admin**: Akses penuh ke pengaturan sistem, manajemen user, backup, dan log aktivitas.
2. **Dosen (Researcher/Supervisor)**: 
   - Memiliki akses ke area `/admin` dan `/guru`.
   - Mengelola kurikulum (Modul), Data Master (Sekolah, Kelas, Guru, Siswa).
   - Memantau seluruh forum diskusi dan laporan kemajuan siswa secara lintas kelas.
3. **Guru (Classroom Manager)**:
   - Terbatas pada area `/guru`.
   - Mengelola kelas spesifik, pembagian kelompok, penilaian jurnal, dan forum diskusi kelas.
4. **Student (Siswa)**:
   - Akses ke area dashboard siswa untuk mengikuti modul pembelajaran.
   - Fitur utama: Jurnal harian, Peta Argumen interaktif, dan Papan Peringkat (Leaderboard).

## Core Pedagogical Features
### 1. Siklus PEDULI
- **Pelajari (P)**: Penyampaian materi awal.
- **Eksplorasi (E)**: Pendalaman materi secara mandiri.
- **Diskusi (D)**: Kolaborasi kelompok menggunakan **Argument Mapping Board** (SVG interaktif) atau Chat.
- **Ungkapkan (U)**: Refleksi tertulis (Jurnal) dengan dukungan umpan balik guru.
- **Lakukan (L)**: Implementasi proyek nyata.
- **Introspeksi (I)**: Evaluasi diri.
- **Selesai (S)**: Penilaian akhir dan pemberian poin.

### 2. Argument Mapping Board
Fitur interaktif yang memungkinkan siswa membangun struktur argumen secara visual (hierarkis) dengan garis koneksi dinamis.

### 3. Gamification System
Siswa mendapatkan poin berdasarkan aktivitas dan kualitas jurnal. Terdapat sistem Leaderboard untuk meningkatkan motivasi.

## Recent Enhancements (Mei 2026)
- **Home Base Dosen**: Penambahan data institusi asal (Home Base) untuk profil Dosen Peneliti.
- **Notification Contrast**: Perbaikan UI lencana notifikasi (merah terang) untuk keterbacaan yang lebih baik.
- **Security**: Implementasi CAPTCHA pada login Guru untuk mencegah serangan brute force.
- **Activity Logs**: Pencatatan detail setiap aksi administratif untuk audit keamanan.

## SEO & AI Optimization
Platform ini menggunakan tag meta deskriptif dan struktur HTML semantik (H1-H4) untuk memastikan konten mudah dipahami oleh mesin pencari dan agen AI.

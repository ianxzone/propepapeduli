# 📝 Catatan Teknis - ProPePa LMS

Log keputusan teknis dan hal-hal penting yang perlu diingat selama pengembangan.

---

## 🔧 Environment & Infrastruktur

| Item | Detail |
|------|--------|
| **Framework** | Laravel 13.7 |
| **PHP Version** | 8.3.28 (Laragon) |
| **Frontend** | Tailwind CSS (utility-first, mobile-first) |
| **Database** | MySQL/MariaDB — database: `propepapeduli` |
| **Local Server** | Laragon (Windows) |
| **Production** | Webuzo (Cloud Hosting + CDN) |
| **Tipe Aplikasi** | Progressive Web App (PWA) |

## 🎨 Branding & Visual

| Item | Detail |
|------|--------|
| **Warna Primer** | Merah Maroon `#800000` |
| **Warna Aksen** | Gold/Kuning (gamifikasi) |
| **Font Min. Size** | 14pt (aksesibilitas siswa SD) |
| **Logo Utama** | ProPePa |
| **Logo Pendukung** | UPI, IKIP Siliwangi |
| **Footer** | "Developed by Murni Abadi" |

## 🔐 Sistem Login

- **Siswa**: Login via `class_code` → Pilih nama dari daftar
- **Guru**: Login via akun sekolah (email/password)
- **Admin**: Akses global, manajemen data induk sekolah

## 📚 Siklus PEDULI (Urutan Wajib)

1. **P** - Pelajari (Video 3 menit + Infografis)
2. **E** - Eksplorasi (Kacamata Perspektif — swipe card 4 stakeholder)
3. **D** - Diskusi (Forum Socratic real-time + voting)
4. **U** - Ungkapkan (Jurnal Empati Digital — teks, emoji, voice note)
5. **L** - Lakukan (Panduan aksi nyata + upload foto)
6. **I** - Introspeksi (Self-assessment + portofolio akhir)

## 🎮 Gamifikasi — Poin Peduli

| Aksi | Poin | Tipe |
|------|------|------|
| Menyelesaikan modul | 100pt | Otomatis |
| Skenario keputusan | 40pt | Otomatis |
| Partisipasi diskusi substantif | 30pt | Validasi Guru |
| Aksi Nyata / Agen Perubahan | 150pt | Validasi Guru |
| Streak jurnal 7 hari | 50pt bonus | Otomatis |

## 📈 Dashboard Guru

- Grafik progres empati mingguan per dimensi
- Alert: siswa tidak aktif 3+ hari / indikasi distress emosional
- Export laporan: PDF / Excel

---

## ⚠️ Catatan Penting

### [2026-05-14] Setup Awal
- Project Laravel 13 sudah di-init (fresh install).
- Database masih set ke `sqlite` → **perlu diubah ke MySQL** (`propepapeduli`).
- PHP path di Laragon: `c:\laragon\bin\php\php-8.3.28-Win32-vs16-x64\php.exe`
- PHP belum ada di system PATH PowerShell → perlu pakai full path atau set PATH dulu.

### [2026-05-14] Desain UI
- **Folder stitch `stitch_propepa_lms_platform` belum tersedia di workspace.**
- User berencana menambahkan referensi desain stitch sebagai panduan tampilan setiap halaman.
- Pengembangan UI di-hold sampai stitch tersedia.

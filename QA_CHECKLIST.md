# 🧪 DOKUMEN QUALITY ASSURANCE (QA) CHECKLIST
## PLATFORM LMS PROPEPA PEDULI

Dokumen ini disusun sebagai panduan pengujian menyeluruh (Quality Assurance) untuk memastikan platform siap dideploy ke lingkungan produksi dan dicoba oleh klien. Pengujian dibagi ke dalam 4 pilar utama: **Tampilan (UI/UX)**, **Fungsi (Features)**, **Kredensial (RBAC)**, dan **Keamanan (Security)**.

---

## 🎨 1. PILAR 1: QA TAMPILAN (UI/UX & RESPONSIVENESS)
Memastikan elemen visual konsisten, nyaman dipandang, dan responsif di seluruh perangkat (Mobile, Tablet, Desktop 1080p).

### Checklist Pengujian Visual:
- [ ] **Hamburger Menu & Sidebar (Mobile & Tablet):**
  - Buka dashboard menggunakan HP/Chrome DevTools (Mode Mobile).
  - Klik tombol hamburger menu: Sidebar harus bergeser mulus dari kiri ke kanan.
  - Klik overlay gelap (backdrop) atau tombol tutup "X": Sidebar harus tertutup dengan transisi CSS yang halus.
- [ ] **Squeezed Content & Overlapping (Desktop 1920x1080):**
  - Buka halaman **Tentang Aplikasi** pada layar monitor lebar.
  - Pastikan teks deskripsi dan card promosi tidak saling menumpuk atau terhimpit di sebelah kiri (Lebar layout seimbang).
- [ ] **Desain Glassmorphism Hero Card:**
  - Pastikan card promosi developer (MATEK) di halaman "Tentang Aplikasi" memiliki efek blur transparan (*backdrop blur*) yang kontras dan elegan di atas latar belakang maroon.
  - Pastikan kedua tombol Call-to-Action (Website & Hubungi WA) memiliki tinggi, padding, dan bentuk bulat (*border-radius*) yang seragam. Tombol WhatsApp wajib menggunakan warna hijau solid `#25D366` dengan teks putih kontras.
- [ ] **Tim Pengembang Dinamis:**
  - Pastikan foto tim di halaman "Tentang Aplikasi" membulat sempurna (`rounded-full`) dan tidak gepeng (*object-cover*).
  - Pastikan inisial avatar (`ui-avatars.com`) tampil rapi dengan warna senada (Maroon/Pink hangat) apabila foto di database tidak diunggah atau url-nya rusak.

---

## ⚙️ 2. PILAR 2: QA FUNGSI (FUNCTIONAL & FEATURE INTEGRATION)
Memastikan semua alur proses bisnis pendidikan berjalan lancar tanpa error/bug logis.

### Checklist Pengujian Fungsional:
- [ ] **Alur Siklus PEDULI (Siswa):**
  - **P (Peka terhadap Masalah) & E (Eksplorasi Isu):** Iframe video YouTube harus terintegrasi dengan baik, deskripsi modul ter-load dinamis.
  - **D (Diskusi Solusi):** Kanvas peta argumen interaktif (*Argument Mapping Board*) dapat menambahkan node baru, menghubungkan antar-node via garis SVG, dan diekspor dengan sukses menjadi gambar PNG.
  - **U (Ungkapkan Pendapat):** Fitur Speech-to-Text (Voice Typing) menangkap suara mikrofon dengan baik dan menyalinnya menjadi teks jurnal, serta tersimpan otomatis secara lokal.
  - **L (Lakukan Aksi) & I (Introspeksi Diri):** Berhasil mengirim tugas aksi nyata dan mencatat penambahan poin siswa.
- [ ] **Notifikasi & Navigasi Guru:**
  - Sebagai Guru, klik salah satu notifikasi masuk (misal: "Siswa telah menyelesaikan jurnal").
  - Pastikan sistem mengarahkan link secara tepat ke halaman detail siswa: `/guru/student/{id}?module_id={module_id}` tanpa memicu error 404.
- [ ] **Manajemen Tim Dinamis:**
  - Masuk sebagai Super Admin, buka menu **Manajemen Tim** (`/admin/teams`).
  - Tambah/edit salah satu anggota tim dan unggah foto baru.
  - Akses halaman **Tentang Aplikasi** (`/about-app`) dan pastikan foto serta data anggota yang baru diubah langsung ter-update otomatis.
- [ ] **Fitur Penilaian & Feedback Guru:**
  - Guru dapat memeriksa tulisan jurnal siswa, mengisi kolom feedback nilai, dan menyimpannya.
  - Siswa dapat melihat feedback guru tersebut secara real-time di dashboard profilnya.

---

## 🔐 3. PILAR 3: QA KREDENSIAL (ROLE-BASED ACCESS CONTROL)
Memastikan hak akses (izin) terisolasi secara sempurna di antara masing-masing peran pengguna.

### Checklist Pengujian Kredensial:
- [ ] **Isolasi Fitur Guru vs Dosen:**
  - Login sebagai **Guru**. Pastikan menu/tombol untuk **menambah sekolah baru** atau **melihat daftar seluruh sekolah** **TIDAK MUNCUL** di sidebar atau dashboard guru (fitur dibatasi hanya untuk Super Admin dan Dosen).
  - Coba tembak url `/admin/schools` secara paksa saat login sebagai Guru. Pastikan sistem menolak dengan kode status `403 Forbidden`.
- [ ] **Akses Menu "Tentang Aplikasi" Lintas Portal:**
  - Login sebagai **Super Admin/Dosen Peneliti**. Buka halaman `/about-app`. Pastikan halaman dirender menggunakan layout Sidebar Admin (Gelap).
  - Login sebagai **Guru Kelas**. Buka halaman `/about-app` melalui menu sidebar guru. Pastikan halaman dirender menggunakan layout Sidebar Guru (Terang).
- [ ] **Metode Login Siswa:**
  - Uji coba login siswa menggunakan **Kode Kelas** (`123456`, `5A-2024`, dll.).
  - Pastikan dropdown nama siswa hanya menampilkan daftar siswa yang terdaftar di kelas bersangkutan saja.

---

## 🛡️ 4. PILAR 4: QA KEAMANAN (SECURITY & STABILITY)
Memastikan aplikasi aman dari celah eksploitasi umum dan memiliki pertahanan data yang kuat.

### Checklist Pengujian Keamanan:
- [ ] **Proteksi CSRF (Cross-Site Request Forgery):**
  - Pastikan setiap formulir inputan di seluruh platform (termasuk tombol keluar/logout, pengiriman feedback, dan pengaturan) dibungkus dengan token `@csrf`.
- [ ] **Rate Limiting Login (Anti Brute Force):**
  - Coba masukkan email/password salah secara sengaja sebanyak **5 kali berturut-turut** pada halaman login Guru (`/guru/login`) atau login Admin (`/admin/login`).
  - Pastikan sistem mengaktifkan blokir login sementara (*lockout*) dan menampilkan pesan peringatan durasi tunggu detik.
- [ ] **Keamanan Mass Assignment Model:**
  - Seluruh parameter inputan database pada model Laravel (`User`, `Team`, `School`, dll.) wajib terproteksi menggunakan atribut `#[Fillable]` untuk mencegah penyerangan injeksi parameter HTTP.
- [ ] **Validasi Captcha:**
  - Aktifkan fitur Captcha melalui menu Pengaturan Sistem sebagai Admin.
  - Pastikan Captcha muncul di halaman login dan memblokir upaya login jika kode Captcha yang dimasukkan salah.
